<?php

namespace App\Http\Controllers;

use App\Models\{Evaluation, ImprovementPlan, User};
use App\Notifications\ImprovementPlanNotification;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ImprovementPlanController extends Controller
{
    private function manager(Request $request): void
    {
        abort_unless($request->user()->hasModulePermission('evaluaciones.gestionar'), 403);
    }

    private function version(Request $request, $record): void
    {
        $data = $request->validate(['version' => ['required', 'integer', 'min:1']]);
        abort_unless((int) $data['version'] === (int) $record->version, 409, 'Este registro cambió. Recarga la página antes de guardar nuevamente.');
    }

    private function actionRules(): array
    {
        return ['description' => ['required', 'string', 'max:1000'],
            'responsible_id' => ['required', 'integer', Rule::exists('users', 'id')->where('status', 'active')],
            'due_date' => ['required', 'date_format:Y-m-d']];
    }

    private function activePlan(int $id): ImprovementPlan
    {
        $plan = ImprovementPlan::visibleTo(auth()->user())->lockForUpdate()->findOrFail($id);
        abort_unless($plan->status === 'active', 409, 'Reabre el plan antes de modificarlo.');
        return $plan;
    }

    // Solo notificaciones de base de datos: quedan en la misma transacción.
    private function record(ImprovementPlan $plan, Request $request, string $event, string $note, array $changes = [], ?int $actionId = null): void
    {
        $plan->updates()->create(['user_id' => $request->user()->id, 'action_id' => $actionId,
            'event' => $event, 'note' => $note, 'changes' => $changes]);
        ActivityLogService::log(['module' => 'Planes de mejora', 'action' => $event, 'record_id' => $plan->id,
            'description' => json_encode(['nota' => $note, 'accion_id' => $actionId, 'cambios' => $changes], JSON_UNESCAPED_UNICODE)]);
        $participants = $plan->actions()->pluck('responsible_id')->push($plan->user_id)->unique()->all();
        User::where('status', 'active')->where(function ($query) use ($participants) {
            $query->whereIn('id', $participants)->orWhereHas('accessRoles', fn ($roles) => $roles->whereIn('name', ['Admin', 'Super Admin']));
        })->with('accessRoles.permissions')->get()
            ->filter(fn ($user) => $user->id !== $request->user()->id && (in_array($user->id, $participants) || $user->hasModulePermission('evaluaciones.gestionar')))
            ->each(fn ($user) => $user->notify(new ImprovementPlanNotification($plan->id, $event.' en el plan de mejora #'.$plan->id.'.')));
    }

    public function index(Request $request)
    {
        $filters = $request->validate(['status' => ['nullable', Rule::in(['active', 'completed', 'cancelled', 'overdue'])],
            'evaluation_id' => ['nullable', 'integer'], 'search' => ['nullable', 'string', 'max:100']]);
        $query = ImprovementPlan::visibleTo($request->user());
        if ($status = $filters['status'] ?? null) {
            if ($status === 'overdue') $query->where('status', 'active')->whereHas('actions', fn ($q) => $q->where('progress', '<', 100)->where('due_date', '<', today()->toDateString()));
            else $query->where('status', $status);
        }
        if (! empty($filters['evaluation_id'])) $query->where('evaluation_id', $filters['evaluation_id']);
        if ($search = $filters['search'] ?? null) $query->where('title', 'like', '%'.$search.'%');
        $plans = $query->with('user')->withCount('actions')->withAvg('actions', 'progress')->orderByDesc('id')->paginate(10)->withQueryString();
        return view('planes.index', compact('plans', 'filters'));
    }

    public function create(Request $request)
    {
        $this->manager($request);
        $selection = $request->validate(['evaluation_id' => ['nullable', 'integer', 'exists:evaluations,id']]);
        if (! empty($selection['evaluation_id']) && ($existing = ImprovementPlan::where('evaluation_id', $selection['evaluation_id'])->first())) {
            return redirect()->route('planes.show', $existing->id)->with('success', 'Esta evaluación ya tiene un plan de mejora. Puedes continuar su seguimiento aquí.');
        }
        $evaluations = Evaluation::where('status', 'completed')->whereNotNull('published_at')
            ->whereNotIn('id', ImprovementPlan::select('evaluation_id'))->with(['user', 'template', 'period'])->orderByDesc('id')->get();
        $users = User::where('status', 'active')->orderBy('first_name')->get();
        return view('planes.create', compact('evaluations', 'users'));
    }

    public function store(Request $request)
    {
        $this->manager($request);
        $data = $request->validate($this->actionRules() + [
            'evaluation_id' => ['required', 'integer', 'exists:evaluations,id'],
            'title' => ['required', 'string', 'max:180'], 'objective' => ['required', 'string', 'max:3000'],
        ]);
        $request->validate(['due_date' => ['after_or_equal:today']]);
        $plan = DB::transaction(function () use ($request, $data) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($data['evaluation_id']);
            abort_unless($evaluation->status === 'completed' && $evaluation->published_at, 409, 'El resultado debe estar completado y publicado.');
            abort_if(ImprovementPlan::where('evaluation_id', $evaluation->id)->exists(), 409, 'Esta evaluación ya tiene un plan. Consulta el plan existente.');
            abort_unless(User::whereKey($data['responsible_id'])->lockForUpdate()->value('status') === 'active', 409, 'El responsable ya no está activo.');
            $plan = ImprovementPlan::create(['evaluation_id' => $evaluation->id, 'user_id' => $evaluation->user_id,
                'created_by' => $request->user()->id, 'title' => $data['title'], 'objective' => $data['objective'], 'status' => 'active',
                'source_result' => $evaluation->only(['total_score', 'published_at', 'template_id', 'period_id', 'evaluation_type_id'])]);
            $action = $plan->actions()->create(collect($data)->only(['description', 'responsible_id', 'due_date'])->all());
            $this->record($plan, $request, 'Plan creado', 'Se registró el objetivo y la primera acción.', ['plan' => $plan->only(['title', 'objective', 'evaluation_id']), 'accion' => $action->only(['description', 'responsible_id', 'due_date'])], $action->id);
            return $plan;
        });
        return redirect()->route('planes.show', $plan->id)->with('success', 'Plan creado. Se notificó a los participantes y administradores autorizados.');
    }

    public function show(Request $request, int $id)
    {
        $plan = ImprovementPlan::visibleTo($request->user())->with(['user', 'evaluation', 'actions.responsible'])->findOrFail($id);
        $manager = $request->user()->hasModulePermission('evaluaciones.gestionar');
        $users = $manager ? User::where('status', 'active')->orderBy('first_name')->get() : collect();
        $updates = $plan->updates()->with('user')->latest('id')->paginate(15)->fragment('plan-history');
        return view('planes.show', compact('plan', 'manager', 'users', 'updates'));
    }

    public function update(Request $request, int $id)
    {
        $this->manager($request);
        $data = $request->validate(['title' => ['required', 'string', 'max:180'], 'objective' => ['required', 'string', 'max:3000'], 'note' => ['required', 'string', 'max:2000']]);
        DB::transaction(function () use ($request, $id, $data) {
            $plan = $this->activePlan($id);
            $this->version($request, $plan);
            $before = $plan->only(['title', 'objective']);
            $plan->update(['title' => $data['title'], 'objective' => $data['objective'], 'version' => $plan->version + 1]);
            $this->record($plan, $request, 'Objetivo actualizado', $data['note'], ['antes' => $before, 'despues' => $plan->only(['title', 'objective'])]);
        });
        return back()->with('success', 'Objetivo actualizado y registrado en el seguimiento.');
    }

    public function addAction(Request $request, int $id)
    {
        $this->manager($request);
        $data = $request->validate($this->actionRules());
        $request->validate(['due_date' => ['after_or_equal:today']]);
        DB::transaction(function () use ($request, $id, $data) {
            $plan = $this->activePlan($id);
            $this->version($request, $plan);
            abort_unless(User::whereKey($data['responsible_id'])->lockForUpdate()->value('status') === 'active', 409, 'El responsable ya no está activo.');
            $action = $plan->actions()->create($data);
            $plan->increment('version');
            $this->record($plan, $request, 'Acción agregada', $data['description'], $data, $action->id);
        });
        return back()->with('success', 'Acción agregada al plan.');
    }

    public function updateAction(Request $request, int $id, int $actionId)
    {
        $this->manager($request);
        $data = $request->validate($this->actionRules() + ['note' => ['required', 'string', 'max:2000']]);
        DB::transaction(function () use ($request, $id, $actionId, $data) {
            $plan = $this->activePlan($id);
            $action = $plan->actions()->lockForUpdate()->findOrFail($actionId);
            $this->version($request, $action);
            if ($action->due_date->toDateString() !== $data['due_date']) $request->validate(['due_date' => ['after_or_equal:today']]);
            abort_unless(User::whereKey($data['responsible_id'])->lockForUpdate()->value('status') === 'active', 409, 'El responsable ya no está activo.');
            $before = $action->only(['description', 'responsible_id', 'due_date']);
            $action->update(collect($data)->except('note')->all() + ['version' => $action->version + 1]);
            $plan->increment('version');
            $this->record($plan, $request, 'Acción actualizada', $data['note'], ['antes' => $before, 'despues' => $action->only(['description', 'responsible_id', 'due_date'])], $action->id);
        });
        return back()->with('success', 'Acción actualizada. Se conservó el cambio anterior en el seguimiento.');
    }

    public function progress(Request $request, int $id, int $actionId)
    {
        $data = $request->validate(['progress' => ['required', 'integer', 'between:0,100'], 'note' => ['required', 'string', 'max:2000']]);
        DB::transaction(function () use ($request, $id, $actionId, $data) {
            $plan = $this->activePlan($id);
            $action = $plan->actions()->lockForUpdate()->findOrFail($actionId);
            abort_unless($request->user()->hasModulePermission('evaluaciones.gestionar') || $action->responsible_id == $request->user()->id, 403);
            $this->version($request, $action);
            $before = $action->progress;
            $action->update(['progress' => $data['progress'], 'version' => $action->version + 1]);
            $plan->increment('version');
            $this->record($plan, $request, 'Avance registrado', $data['note'], ['antes' => $before, 'despues' => (int) $data['progress']], $action->id);
        });
        return back()->with('success', 'Avance registrado y notificado. Al llegar al 100 %, el plan aún requiere cierre administrativo.');
    }

    public function transition(Request $request, int $id)
    {
        $this->manager($request);
        $data = $request->validate(['status' => ['required', Rule::in(['completed', 'cancelled', 'active'])], 'note' => ['required', 'string', 'min:10', 'max:2000']]);
        DB::transaction(function () use ($request, $id, $data) {
            $plan = ImprovementPlan::lockForUpdate()->findOrFail($id);
            $this->version($request, $plan);
            abort_unless($data['status'] === 'active' ? $plan->status !== 'active' : $plan->status === 'active', 409, 'El cambio de estado no corresponde al estado actual del plan.');
            if ($data['status'] === 'completed') abort_unless($plan->actions()->exists() && ! $plan->actions()->where('progress', '<', 100)->exists(), 409, 'Todas las acciones deben reportar 100 % antes de cerrar.');
            $before = $plan->status;
            $plan->update(['status' => $data['status'], 'version' => $plan->version + 1,
                'closed_at' => $data['status'] === 'active' ? null : now(), 'closed_by' => $data['status'] === 'active' ? null : $request->user()->id]);
            $event = ['active' => 'Plan reabierto', 'completed' => 'Plan cerrado', 'cancelled' => 'Plan cancelado'][$data['status']];
            $this->record($plan, $request, $event, $data['note'], ['antes' => $before, 'despues' => $data['status']]);
        });
        return back()->with('success', 'Estado del plan actualizado. El motivo quedó registrado.');
    }
}
