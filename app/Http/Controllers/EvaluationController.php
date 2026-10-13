<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\EvaluationType;
use App\Models\EvaluationPeriod;
use App\Models\EvaluationTemplate;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
/**
 * Mostrar listado de evaluaciones.
 */
public function index()
{
    // Obtener evaluaciones con relaciones

    $evaluations = Evaluation::with([
        'user',
        'evaluationType',
        'period',
        'template',
        'evaluator',
    ]);

    // Buscar evaluación

    if (request('search')) {

        $search = request('search');

        $evaluations->where(function ($query) use ($search) {

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('paternal_surname', 'like', "%{$search}%");

            })

            ->orWhereHas('evaluationType', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%");

            })

            ->orWhereHas('evaluator', function ($q) use ($search) {

                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('paternal_surname', 'like', "%{$search}%");

            });

        });

    }

    // Filtrar por estado

    if (request('status')) {

        $evaluations->where('status', request('status'));

    }

    // Ordenar resultados

    $ordenes = [

        'evaluation_date',
        'status',
        'total_score',

    ];

    if (
        request('order') &&
        in_array(request('order'), $ordenes)
    ) {

        $evaluations->orderBy(request('order'));

    } else {

        $evaluations->orderByDesc('id');

    }

    $evaluations = $evaluations->orderByDesc('id')->get();
    $activeCount = Evaluation::whereIn('status', ['draft', 'in_progress'])->count();
    $pendingCount = Evaluation::where('status', 'draft')->count();
    $completedCount = Evaluation::where('status', 'completed')->count();

    return view(
        'evaluaciones.index',
        compact('evaluations', 'activeCount', 'pendingCount', 'completedCount')
    );
}

    /**
 * Mostrar formulario para crear una evaluación.
 */
public function create()
{
    // Obtener colaboradores activos
    $users = User::orderBy('first_name')->get();

    // Obtener tipos de evaluación activos
    $evaluationTypes = EvaluationType::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Obtener periodos activos
    $periods = EvaluationPeriod::where('is_active', true)
        ->orderByDesc('year')
        ->orderBy('name')
        ->get();

    // Obtener plantillas activas
    $templates = EvaluationTemplate::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Obtener posibles evaluadores
    $evaluators = User::orderBy('first_name')->get();

    return view('evaluaciones.create', compact(
        'users',
        'evaluationTypes',
        'periods',
        'templates',
        'evaluators'
    ));
}

/**
 * Mostrar formulario para editar una evaluación.
 */
public function edit($id)
{
    // Obtener evaluación
    $evaluation = Evaluation::findOrFail($id);

    // Validar que la evaluación pueda editarse
if ($evaluation->status !== 'draft') {
    return redirect()
        ->route('evaluaciones.show', $evaluation->id)
        ->with(
            'error',
            'La evaluación ya fue finalizada y no puede modificarse.'
        );
}

    // Obtener colaboradores activos
    $users = User::orderBy('first_name')->get();

    // Obtener tipos de evaluación activos
    $evaluationTypes = EvaluationType::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Obtener periodos activos
    $periods = EvaluationPeriod::where('is_active', true)
        ->orderByDesc('year')
        ->orderBy('name')
        ->get();

    // Obtener plantillas activas
    $templates = EvaluationTemplate::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Obtener posibles evaluadores
    $evaluators = User::orderBy('first_name')->get();

    return view('evaluaciones.edit', compact(
        'evaluation',
        'users',
        'evaluationTypes',
        'periods',
        'templates',
        'evaluators'
    ));
}

/**
 * Actualizar una evaluación.
 */
public function update(UpdateEvaluationRequest $request, $id)
{
    DB::transaction(function () use ($request, $id) {
        $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
        abort_unless($evaluation->status === 'draft', 409, 'Reabre la evaluacion antes de modificarla.');
        $data = $request->validated();
        if ($evaluation->answers()->exists()) {
            abort_if($evaluation->user_id != $data['user_id'] || $evaluation->template_id != $data['template_id'], 422, 'Debe conservar el colaborador y la plantilla de las respuestas existentes.');
            unset($data['observations']);
        }
        $before = $evaluation->only(array_keys($data));
        $evaluation->update($data);
        \App\Services\ActivityLogService::log(['module' => 'Evaluaciones', 'action' => 'Actualizar asignacion', 'record_id' => $evaluation->id, 'description' => json_encode(['anterior' => $before, 'nuevo' => $data], JSON_UNESCAPED_UNICODE)]);
    });

    return redirect()
        ->route('evaluaciones.index')
        ->with('success', 'Evaluación actualizada correctamente.');
}

/**
 * Mostrar el detalle de una evaluación.
 */
public function show($id)
{
    // Obtener evaluación con toda la información relacionada
    $evaluation = Evaluation::with([
        'user',
        'evaluator',
        'period',
        'evaluationType',
        'template',
        'answers.question.category',
        'answers.question.competency',
    ])->findOrFail($id);

    return view('evaluaciones.show', compact('evaluation'));
}

/**
 * Guardar una nueva evaluación.
 */
public function store(StoreEvaluationRequest $request)
{
    // Obtener datos validados
    $data = $request->validated();

    // Inicializar valores del sistema
    $data['status'] = 'draft';
    $data['total_score'] = 0;

    // Registrar evaluación
    Evaluation::create($data);

    return redirect()
        ->route('evaluaciones.index')
        ->with('success', 'Evaluación registrada correctamente.');
}

/**
 * Eliminar una evaluación.
 */
public function destroy($id)
{
    DB::transaction(function () use ($id) {
        $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
        abort_unless($evaluation->status === 'draft' && ! $evaluation->answers()->exists(), 409, 'No se puede eliminar una prueba procesada o con respuestas.');
        $evaluation->delete();
    });

    return redirect()
        ->route('evaluaciones.index')
        ->with('success', 'Evaluación eliminada correctamente.');
}

/**
 * Mostrar la evaluación para su aplicación.
 */
public function apply($id)
{
    return redirect()->route('mis-evaluaciones.show', $id);
}

/**
 * Guardar respuestas de una evaluación.
 */
public function submit(Request $request, $id)
{
    return app(MyEvaluationController::class)->submit($request, (int) $id);
}


}
