<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationQuestionRequest extends FormRequest
{
    /**
     * Determina si el usuario puede realizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [

            'evaluation_type_id' => 'required|exists:evaluation_types,id',

            'category_id' => 'required|exists:evaluation_categories,id',

            'competency_id' => 'required|exists:evaluation_competencies,id',

            'scale_id' => 'required|exists:evaluation_scales,id',

            'question_type' => 'required|string|max:50',

            'question' => 'required|string|max:1000',

            'help_text' => 'nullable|string',

            'weight' => 'required|numeric|min:0',

            'order_number' => 'required|integer|min:1',

            'is_required' => 'required|boolean',

            'is_active' => 'required|boolean',

        ];
    }

    /**
     * Nombres amigables.
     */
    public function attributes(): array
    {
        return [

            'evaluation_type_id' => 'tipo de evaluación',

            'category_id' => 'categoría',

            'competency_id' => 'competencia',

            'scale_id' => 'escala',

            'question_type' => 'tipo de pregunta',

            'question' => 'pregunta',

            'help_text' => 'texto de ayuda',

            'weight' => 'peso',

            'order_number' => 'orden',

            'is_required' => 'obligatoria',

            'is_active' => 'estado',

        ];
    }
}