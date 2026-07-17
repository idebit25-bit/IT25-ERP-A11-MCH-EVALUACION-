<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEvaluationTypeRequest extends FormRequest
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
        $evaluationType = $this->route('id');

        return [

            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('evaluation_types', 'code')->ignore($evaluationType),
            ],

            'name' => 'required|string|max:100',

            'description' => 'nullable|string',

            'is_active' => 'required|boolean',

        ];
    }

    /**
     * Nombres amigables.
     */
    public function attributes(): array
    {
        return [

            'code' => 'código',

            'name' => 'nombre',

            'description' => 'descripción',

            'is_active' => 'estado',

        ];
    }
}