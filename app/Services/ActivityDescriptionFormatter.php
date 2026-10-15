<?php

namespace App\Services;

class ActivityDescriptionFormatter
{
    public function format(?string $description): string
    {
        if ($description === null || $description === '') return 'Sin descripción.';

        $data = json_decode($description, true);
        // Descripciones comunes y registros antiguos no válidos se conservan.
        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($data)) return $description;

        return $this->lines($data) ?: 'Sin detalles adicionales.';
    }

    private function lines(array $data, int $depth = 0): string
    {
        $labels = [
            'nota' => 'Nota', 'motivo' => 'Motivo', 'accion_id' => 'ID de la acción',
            'cambios' => 'Cambios registrados', 'antes' => 'Antes', 'despues' => 'Después',
            'plan' => 'Plan', 'accion' => 'Acción', 'title' => 'Nombre', 'objective' => 'Objetivo',
            'description' => 'Descripción', 'responsible_id' => 'ID del responsable',
            'due_date' => 'Fecha compromiso', 'progress' => 'Avance (%)', 'status' => 'Estado',
            'evaluation_id' => 'ID de la evaluación', 'version' => 'Versión', 'note' => 'Comentario',
            'calificacion_anterior' => 'Calificación anterior', 'observaciones_anteriores' => 'Observaciones anteriores',
            'respuestas_anteriores' => 'Respuestas anteriores', 'question_id' => 'ID de la pregunta',
            'answer' => 'Respuesta', 'numeric_value' => 'Valor numérico',
            'reviewed_at' => 'Fecha de revisión', 'reviewed_by' => 'ID de quien revisó', 'review_notes' => 'Observaciones de revisión',
            'validated_at' => 'Fecha de validación', 'validated_by' => 'ID de quien validó',
            'published_at' => 'Fecha de publicación', 'published_by' => 'ID de quien publicó',
            'comparison_snapshot' => 'Referencia histórica de comparación', 'calculation' => 'Cálculo',
            'template_id' => 'ID de la plantilla', 'type_id' => 'ID del tipo de evaluación',
            'answered_ids' => 'Preguntas respondidas (ID)', 'questions' => 'Preguntas',
            'id' => 'ID', 'text' => 'Texto', 'help' => 'Ayuda', 'type' => 'Tipo',
            'required' => 'Obligatoria', 'weight' => 'Peso', 'scale_id' => 'ID de la escala',
            'values' => 'Opciones de respuesta', 'label' => 'Opción', 'value' => 'Valor',
        ];
        $lines = [];
        foreach ($data as $key => $value) {
            $label = is_int($key) ? 'Registro '.($key + 1) : ($labels[$key] ?? ucfirst(str_replace('_', ' ', $key)));
            $prefix = str_repeat('  ', $depth).$label.':';
            if (is_array($value)) {
                $lines[] = $value === [] ? $prefix.' Sin registros.' : $prefix."\n".$this->lines($value, $depth + 1);
                continue;
            }
            if ($key === 'status' || in_array($key, ['antes', 'despues'], true)) {
                $value = ['active' => 'En seguimiento', 'completed' => 'Cerrado', 'cancelled' => 'Cancelado'][$value ?? ''] ?? $value;
            }
            if ($key === 'calculation' && $value === 'mean_numeric_values') $value = 'Promedio de valores numéricos';
            if ($key === 'type' && $value === 'radio') $value = 'Selección única';
            $text = is_bool($value) ? ($value ? 'Sí' : 'No') : ($value === null || $value === '' ? 'Sin registrar' : (string) $value);
            $lines[] = $prefix.' '.$text;
        }
        return implode("\n", $lines);
    }
}
