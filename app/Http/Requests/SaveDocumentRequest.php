<?php

namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasModulePermission('documentos.gestionar') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(Document::TYPES)],
            'version' => ['required', 'string', 'max:20'],
            'status' => ['required', Rule::in(Document::STATUSES)],
            'expiration_date' => ['nullable', 'date'],
            'document' => [$this->isMethod('POST') ? 'required' : 'nullable', 'bail', 'file', 'mimes:pdf', 'max:5120', function ($attribute, $value, $fail) {
                $header = file_get_contents($value->getRealPath(), false, null, 0, 1024);
                if ($header === false || ! str_contains($header, '%PDF-')) {
                    $fail('El archivo no contiene un PDF válido.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Escribe el nombre del documento.',
            'type.required' => 'Selecciona el tipo de documento.',
            'type.in' => 'Selecciona un tipo de documento válido.',
            'version.required' => 'Indica la versión del documento.',
            'version.max' => 'La versión no debe superar los 20 caracteres.',
            'status.required' => 'Selecciona el estado del documento.',
            'status.in' => 'Selecciona un estado válido.',
            'expiration_date.date' => 'La fecha de vencimiento no es válida.',
            'document.required' => 'Adjunta el archivo PDF.',
            'document.mimes' => 'El archivo debe ser un PDF válido.',
            'document.max' => 'El PDF no debe superar los 5 MB.',
            'document.uploaded' => 'No se pudo cargar el archivo. Comprueba su tamaño e inténtalo nuevamente.',
        ];
    }
}
