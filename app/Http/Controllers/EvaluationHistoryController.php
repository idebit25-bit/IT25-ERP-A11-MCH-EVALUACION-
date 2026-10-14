<?php

namespace App\Http\Controllers;

use App\Models\{Evaluation, User, EvaluationTemplate, EvaluationPeriod, EvaluationType};
use App\Services\EvaluationHistoryService;
use Illuminate\Http\Request;

class EvaluationHistoryController extends Controller
{
    public function index(Request $request, EvaluationHistoryService $service)
    {
        $personal = $request->routeIs('mis-evaluaciones.history');
        if (! $personal) abort_unless($request->user()->hasModulePermission('reportes.consultar'), 403);
        $filters = $request->validate([
            'user_id' => $personal ? ['prohibited'] : ['nullable', 'integer', 'exists:users,id'],
            'template_id' => ['nullable', 'integer', 'exists:evaluation_templates,id'],
            'period_id' => ['nullable', 'integer', 'exists:evaluation_periods,id'],
            'evaluation_type_id' => ['nullable', 'integer', 'exists:evaluation_types,id'],
        ]);
        $employee = $personal ? $request->user() : User::find($filters['user_id'] ?? null);
        $base = Evaluation::where('user_id', $employee?->id ?? 0);
        $templates = EvaluationTemplate::whereIn('id', (clone $base)->select('template_id'))->orderBy('name')->get();
        $periods = EvaluationPeriod::whereIn('id', (clone $base)->select('period_id'))->orderByDesc('start_date')->get();
        $types = EvaluationType::whereIn('id', (clone $base)->select('evaluation_type_id'))->orderBy('name')->get();
        foreach (['template_id', 'period_id', 'evaluation_type_id'] as $field) {
            if (! empty($filters[$field])) $base->where($field, $filters[$field]);
        }
        $published = (clone $base)->where('status', 'completed')->whereNotNull('published_at')->with('period')->get();
        $indicators = $service->indicators($published, ! empty($filters['template_id']));
        $evaluations = $base->with(['template', 'period', 'evaluationType', 'evaluator'])
            ->orderByDesc('evaluation_date')->orderByDesc('id')->paginate(15)->withQueryString();
        $users = $personal ? collect() : User::orderBy('first_name')->orderBy('id')->get();
        return view('evaluaciones.history', compact('personal', 'employee', 'filters', 'templates', 'periods', 'types', 'indicators', 'evaluations', 'users'));
    }

    public function show(Request $request, int $id)
    {
        abort_unless($request->user()->hasModulePermission('reportes.consultar'), 403);
        $evaluation = Evaluation::with(['user', 'evaluator', 'template', 'period', 'evaluationType', 'answers.question'])->findOrFail($id);
        return view('evaluaciones.history-detail', compact('evaluation'));
    }
}
