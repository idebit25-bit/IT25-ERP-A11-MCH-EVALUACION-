<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
       $user = \App\Models\User::findOrFail($this->route('id'));

        return [

            // Identificación
            'employee_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'employee_code')->ignore($user),
            ],

            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'paternal_surname' => 'nullable|string|max:255',
            'maternal_surname' => 'nullable|string|max:255',

            // Laboral
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'entry_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',

            // Contacto
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],

            'email_personal' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',

            // Acceso
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user),
            ],

            'password' => 'prohibited',
            'password_confirmation' => 'prohibited',

            // Personales
            'gender' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',

        ];
    }

    /**
     * Nombres amigables.
     */
    public function attributes(): array
    {
        return [
            'employee_code' => 'código de colaborador',
            'first_name' => 'nombre',
            'paternal_surname' => 'apellido paterno',
            'maternal_surname' => 'apellido materno',
            'department_id' => 'departamento',
            'position_id' => 'puesto',
            'entry_date' => 'fecha de ingreso',
            'email' => 'correo electrónico',
            'email_personal' => 'correo personal',
            'phone' => 'teléfono',
            'emergency_number' => 'teléfono de emergencia',
            'username' => 'usuario',
            'password' => 'contraseña',
        ];
    }
}
