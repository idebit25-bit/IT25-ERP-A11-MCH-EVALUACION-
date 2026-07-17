<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationTemplateRequest extends FormRequest
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

            'name' => 'required|string|max:150',

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

            'evaluation_type_id' => 'tipo de evaluación',

            'name' => 'nombre',

            'description' => 'descripción',

            'is_active' => 'estado',

        ];
    }
}