<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Services\ActivityDescriptionFormatter;
use Tests\TestCase;

class ActivityDescriptionTest extends TestCase
{
    public function test_structured_history_preserves_nested_values_and_plain_descriptions(): void
    {
        $formatter = new ActivityDescriptionFormatter;
        $text = $formatter->format(json_encode(['motivo' => 'Corregir respuestas', 'calificacion_anterior' => 0,
            'respuestas_anteriores' => [['question_id' => 4, 'answer' => 'Nunca', 'numeric_value' => 0]],
            'comparison_snapshot' => ['questions' => [['required' => false]]], 'reviewed_at' => null]));
        foreach (['Motivo: Corregir respuestas', 'Calificación anterior: 0', 'ID de la pregunta: 4', 'Respuesta: Nunca',
            'Valor numérico: 0', 'Obligatoria: No', 'Fecha de revisión: Sin registrar'] as $expected) {
            $this->assertStringContainsString($expected, $text);
        }
        $this->assertSame('Inició sesión.', $formatter->format('Inició sesión.'));
        $this->assertSame('{dato incompleto', $formatter->format('{dato incompleto'));
    }

    public function test_description_view_escapes_user_content_and_keeps_long_details_available(): void
    {
        $log = new ActivityLog(['description' => json_encode(['nota' => '<script>alert(1)</script>',
            'cambios' => ['antes' => str_repeat('Texto anterior ', 40), 'despues' => 'completed']])]);
        $html = view('configuracion.bitacora.description', compact('log'))->render();
        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringContainsString('Ver detalles del movimiento', $html);
        $this->assertStringContainsString('Después: Cerrado', $html);
        $this->assertStringContainsString(str_repeat('Texto anterior ', 40), $html);
    }
}
