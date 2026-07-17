<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationPeriodRequest extends FormRequest
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

            'name' => 'required|string|max:150',

            'description' => 'nullable|string',

            'year' => 'required|integer|min:2020|max:2100',

            'start_date' => 'required|date',

            'end_date' => 'required|date|after_or_equal:start_date',

            'is_active' => 'required|boolean',

        ];
    }

    /**
     * Nombres amigables.
     */
    public function attributes(): array
    {
        return [

            'name' => 'nombre',

            'description' => 'descripción',

            'year' => 'año',

            'start_date' => 'fecha de inicio',

            'end_date' => 'fecha de fin',

            'is_active' => 'estado',

        ];
    }
}