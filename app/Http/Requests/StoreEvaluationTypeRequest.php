<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationTypeRequest extends FormRequest
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

            'code' => 'required|string|max:20|unique:evaluation_types,code',

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