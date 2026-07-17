<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationQuestionRequest;
use App\Http\Requests\UpdateEvaluationQuestionRequest;
use App\Models\EvaluationCategory;
use App\Models\EvaluationCompetency;
use App\Models\EvaluationQuestion;
use App\Models\EvaluationScale;
use App\Models\EvaluationType;
use App\Services\ActivityLogService;

class EvaluationQuestionController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationQuestions = EvaluationQuestion::with([
            'evaluationType',
            'category',
            'competency',
            'scale'
        ])
        ->orderBy('order_number')
        ->get();

        return view(
            'configuracion.evaluation-questions.index',
            compact('evaluationQuestions')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $evaluationTypes = EvaluationType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = EvaluationCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $competencies = EvaluationCompetency::where('is_active', true)
            ->orderBy('name')
            ->get();

        $scales = EvaluationScale::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-questions.create',
            compact(
                'evaluationTypes',
                'categories',
                'competencies',
                'scales'
            )
        );
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationQuestionRequest $request)
    {
 $evaluationQuestion = EvaluationQuestion::create(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Banco de preguntas',
    'action' => 'Crear',
    'description' => 'Creó la pregunta "' . $evaluationQuestion->question . '".',
    'record_id' => $evaluationQuestion->id,
]);

        return redirect()
            ->route('evaluation-questions.index')
            ->with(
                'success',
                'Pregunta creada correctamente.'
            );
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationQuestion = EvaluationQuestion::with([
            'evaluationType',
            'category',
            'competency',
            'scale'
        ])->findOrFail($id);

        return view(
            'configuracion.evaluation-questions.show',
            compact('evaluationQuestion')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationQuestion = EvaluationQuestion::findOrFail($id);

        $evaluationTypes = EvaluationType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = EvaluationCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $competencies = EvaluationCompetency::where('is_active', true)
            ->orderBy('name')
            ->get();

        $scales = EvaluationScale::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-questions.edit',
            compact(
                'evaluationQuestion',
                'evaluationTypes',
                'categories',
                'competencies',
                'scales'
            )
        );
    }

    /**
     * Actualizar registro.
     */
    public function update(
        UpdateEvaluationQuestionRequest $request,
        $id
    ) {
        $evaluationQuestion = EvaluationQuestion::findOrFail($id);

        $evaluationQuestion->update(
            $request->validated()
        );
        
        ActivityLogService::log([
            'module' => 'Banco de preguntas',
            'action' => 'Actualizar',
            'description' => 'Actualizó la pregunta "' . $evaluationQuestion->question . '".',
            'record_id' => $evaluationQuestion->id,
        ]);
        return redirect()
            ->route('evaluation-questions.index')
            ->with(
                'success',
                'Pregunta actualizada correctamente.'
            );
    }

    /**
     * Activar o desactivar registro.
     */
    public function destroy($id)
    {
        $evaluationQuestion = EvaluationQuestion::findOrFail($id);

        $evaluationQuestion->is_active =
            !$evaluationQuestion->is_active;

            
            $evaluationQuestion->save();
            
            ActivityLogService::log([
                'module' => 'Banco de preguntas',
                'action' => $evaluationQuestion->is_active
                    ? 'Activar'
                    : 'Desactivar',
                'description' => $evaluationQuestion->is_active
                    ? 'Activó la pregunta "' . $evaluationQuestion->question . '".'
                    : 'Desactivó la pregunta "' . $evaluationQuestion->question . '".',
                'record_id' => $evaluationQuestion->id,
            ]);       

        $message = $evaluationQuestion->is_active
            ? 'Pregunta activada correctamente.'
            : 'Pregunta desactivada correctamente.';

        return redirect()
            ->route('evaluation-questions.index')
            ->with('success', $message);
    }
}