<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\EvaluationType;
use App\Models\EvaluationPeriod;
use App\Models\EvaluationTemplate;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\EvaluationAnswer;
use App\Models\EvaluationScaleValue;
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

        $evaluations->orderByDesc('evaluation_date');

    }

    $evaluations = $evaluations->get();

    return view(
        'evaluaciones.index',
        compact('evaluations')
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
    // Obtener evaluación
    $evaluation = Evaluation::findOrFail($id);

    // Obtener datos validados
    $data = $request->validated();

    // Actualizar evaluación
    $evaluation->update($data);

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
    // Obtener evaluación
    $evaluation = Evaluation::findOrFail($id);

    // Validar que pueda eliminarse
    if ($evaluation->status !== 'draft') {

        return redirect()
            ->route('evaluaciones.index')
            ->with('error', 'La evaluación no puede eliminarse porque ya fue procesada.');
    }

    // Eliminar evaluación
    $evaluation->delete();

    return redirect()
        ->route('evaluaciones.index')
        ->with('success', 'Evaluación eliminada correctamente.');
}

/**
 * Mostrar la evaluación para su aplicación.
 */
public function apply($id)
{
    $evaluation = Evaluation::with([
        'user',
        'evaluator',
        'period',
        'evaluationType',
        'template.questions.category',
        'template.questions.competency',
        'template.questions.scale',
        'template.questions.scale.values',
    ])->findOrFail($id);

    return view('evaluaciones.apply', compact('evaluation'));
}

/**
 * Guardar respuestas de una evaluación.
 */
public function submit(Request $request, $id)
{
    // Obtener evaluación
    $evaluation = Evaluation::findOrFail($id);

    // Obtener respuestas enviadas
    $answers = $request->input('answers', []);

    // Obtener observaciones
$observations = $request->input('observations');

    DB::transaction(function () use ($evaluation, $answers) {

        // Eliminar respuestas anteriores
        EvaluationAnswer::where(
            'evaluation_id',
            $evaluation->id
        )->delete();

        // Guardar respuestas
        foreach ($answers as $questionId => $scaleValueId) {

            // Obtener valor seleccionado
            $scaleValue = EvaluationScaleValue::findOrFail($scaleValueId);

            // Registrar respuesta
            EvaluationAnswer::create([
                'evaluation_id' => $evaluation->id,
                'question_id'   => $questionId,
                'answer'        => $scaleValue->label,
                'numeric_value' => $scaleValue->numeric_value,
                'comments'      => null,
            ]);
        }

    });

    // Guardar observaciones
$evaluation->observations = $observations;
$evaluation->save();

    // Calcular la calificación final
$totalScore = $this->calculateScore($evaluation);

// Actualizar la evaluación
$evaluation->update([
    'total_score' => $totalScore,
    'status' => 'completed',
]);

    return redirect()
        ->route('evaluaciones.index')
        ->with(
            'success',
            'La evaluación se guardó correctamente.'
        );
}


/**
 * Calcular la calificación de una evaluación.
 */
private function calculateScore(Evaluation $evaluation): float
{
    // Obtener promedio de las respuestas
    return (float) EvaluationAnswer::where(
        'evaluation_id',
        $evaluation->id
    )->avg('numeric_value');
}

}