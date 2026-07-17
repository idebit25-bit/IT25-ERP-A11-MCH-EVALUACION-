<?php

namespace App\Http\Controllers;

use App\Models\EvaluationTemplate;
use App\Models\EvaluationQuestion;
use App\Models\EvaluationTemplateQuestion;
use App\Http\Requests\UpdateEvaluationTemplateQuestionRequest;

class EvaluationTemplateQuestionController extends Controller
{
    /**
     * Mostrar las preguntas de una plantilla.
     */
    public function index($template)
    {
        $evaluationTemplate = EvaluationTemplate::with([
            'evaluationType',
            'templateQuestions.question.category',
            'templateQuestions.question.competency',
            'templateQuestions.question.scale'
        ])->findOrFail($template);

        $templateQuestions = $evaluationTemplate
            ->templateQuestions()
            ->with('question')
            ->orderBy('order_number')
            ->get();

        return view(
            'configuracion.template-questions.index',
            compact(
                'evaluationTemplate',
                'templateQuestions'
            )
        );
    }

 /**
 * Mostrar preguntas disponibles para la plantilla.
 */
public function create($template)
{
    $evaluationTemplate = EvaluationTemplate::findOrFail($template);

    $assignedQuestions = $evaluationTemplate
        ->templateQuestions()
        ->pluck('question_id');

    $availableQuestions = \App\Models\EvaluationQuestion::with([
        'evaluationType',
        'category',
        'competency',
        'scale'
    ])
    ->whereNotIn('id', $assignedQuestions)
    ->where('is_active', true)
    ->orderBy('order_number')
    ->get();

    return view(
        'configuracion.template-questions.create',
        compact(
            'evaluationTemplate',
            'availableQuestions'
        )
    );
}

/**
 * Agregar pregunta a la plantilla.
 */
public function store($template, $question)
{
    $evaluationTemplate = EvaluationTemplate::findOrFail($template);

    $evaluationQuestion = EvaluationQuestion::findOrFail($question);

    // Evitar duplicados
    $exists = EvaluationTemplateQuestion::where('template_id', $template)
        ->where('question_id', $question)
        ->exists();

    if ($exists) {

        return redirect()
            ->route('template-questions.index', $template)
            ->with(
                'success',
                'La pregunta ya se encuentra asignada.'
            );
    }

    // Obtener siguiente orden
    $nextOrder = EvaluationTemplateQuestion::where('template_id', $template)
        ->max('order_number');

    $nextOrder = $nextOrder ? $nextOrder + 1 : 1;

    EvaluationTemplateQuestion::create([

        'template_id' => $template,

        'question_id' => $question,

        'order_number' => $nextOrder,

        'weight' => $evaluationQuestion->weight,

        'is_required' => $evaluationQuestion->is_required,

    ]);

    return redirect()
        ->route('template-questions.index', $template)
        ->with(
            'success',
            'Pregunta agregada correctamente.'
        );
}

/**
 * Mostrar formulario para editar la configuración
 * de una pregunta dentro de la plantilla.
 */
public function edit($template, $id)
{
    $evaluationTemplate = EvaluationTemplate::findOrFail($template);

    $templateQuestion = EvaluationTemplateQuestion::with('question')
        ->findOrFail($id);

    return view(
        'configuracion.template-questions.edit',
        compact(
            'evaluationTemplate',
            'templateQuestion'
        )
    );
}

/**
 * Actualizar configuración de la pregunta.
 */
public function update(
    UpdateEvaluationTemplateQuestionRequest $request,
    $template,
    $id
) {
    $templateQuestion = EvaluationTemplateQuestion::findOrFail($id);

    $templateQuestion->update(
        $request->validated()
    );

    return redirect()
        ->route(
            'template-questions.index',
            $template
        )
        ->with(
            'success',
            'Configuración actualizada correctamente.'
        );
}

/**
 * Eliminar pregunta de la plantilla.
 */
public function destroy($template, $id)
{
    $templateQuestion = EvaluationTemplateQuestion::findOrFail($id);

    $templateQuestion->delete();

    return redirect()
        ->route(
            'template-questions.index',
            $template
        )
        ->with(
            'success',
            'Pregunta eliminada correctamente de la plantilla.'
        );
}
}