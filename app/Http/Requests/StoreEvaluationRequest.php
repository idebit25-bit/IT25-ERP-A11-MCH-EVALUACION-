<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
public function rules(): array
{
    return [

        'user_id' => [
            'required',
            'exists:users,id',
        ],

        'evaluation_type_id' => [
            'required',
            'exists:evaluation_types,id',
        ],

        'period_id' => [
            'required',
            'exists:evaluation_periods,id',
        ],

        'template_id' => [
            'required',
            'exists:evaluation_templates,id',
        ],

        'evaluator_id' => [
            'required',
            'exists:users,id',
        ],

        'evaluation_date' => [
            'required',
            'date',
        ],

        'observations' => [
            'nullable',
            'string',
            'max:1000',
        ],

    ];
}

public function messages(): array
{
    return [

        'user_id.required' => 'Debe seleccionar un colaborador.',
        'user_id.exists' => 'El colaborador seleccionado no es válido.',

        'evaluation_type_id.required' => 'Debe seleccionar un tipo de evaluación.',
        'evaluation_type_id.exists' => 'El tipo de evaluación seleccionado no es válido.',

        'period_id.required' => 'Debe seleccionar un período.',
        'period_id.exists' => 'El período seleccionado no es válido.',

        'template_id.required' => 'Debe seleccionar una plantilla.',
        'template_id.exists' => 'La plantilla seleccionada no es válida.',

        'evaluator_id.required' => 'Debe seleccionar un evaluador.',
        'evaluator_id.exists' => 'El evaluador seleccionado no es válido.',

        'evaluation_date.required' => 'Debe indicar la fecha de la evaluación.',
        'evaluation_date.date' => 'La fecha de evaluación no es válida.',

        'observations.max' => 'Las observaciones no pueden exceder los 1000 caracteres.',

    ];
}


}
