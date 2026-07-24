<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
{
    /**
     * Determinar si el usuario puede realizar esta solicitud.
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
            'user_id' => 'required|exists:users,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'period_id' => 'required|exists:evaluation_periods,id',
            'template_id' => 'required|exists:evaluation_templates,id',
            'evaluator_id' => 'required|exists:users,id',
            'evaluation_date' => 'required|date',
            'observations' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Debe seleccionar un colaborador.',
            'user_id.exists' => 'El colaborador seleccionado no existe.',

            'evaluation_type_id.required' => 'Debe seleccionar un tipo de evaluación.',
            'evaluation_type_id.exists' => 'El tipo de evaluación seleccionado no existe.',

            'period_id.required' => 'Debe seleccionar un período.',
            'period_id.exists' => 'El período seleccionado no existe.',

            'template_id.required' => 'Debe seleccionar una plantilla.',
            'template_id.exists' => 'La plantilla seleccionada no existe.',

            'evaluator_id.required' => 'Debe seleccionar un evaluador.',
            'evaluator_id.exists' => 'El evaluador seleccionado no existe.',

            'evaluation_date.required' => 'Debe indicar la fecha de evaluación.',
            'evaluation_date.date' => 'La fecha de evaluación no es válida.',

            'observations.max' => 'Las observaciones no pueden superar los 1000 caracteres.',
        ];
    }
}