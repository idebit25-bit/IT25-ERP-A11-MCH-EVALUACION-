<?php

namespace App\Services;

use App\Models\Evaluation;
use Illuminate\Support\Collection;

class EvaluationHistoryService
{
    // Se conserva al enviar; nunca se reconstruye con el catálogo actual.
    public function snapshot(Evaluation $evaluation, Collection $questions, array $answeredIds): array
    {
        sort($answeredIds, SORT_NUMERIC);
        return [
            'version' => 1,
            'calculation' => 'mean_numeric_values',
            'template_id' => (int) $evaluation->template_id,
            'type_id' => (int) $evaluation->evaluation_type_id,
            'answered_ids' => array_map('intval', $answeredIds),
            'questions' => $questions->sortBy('id')->map(fn ($question) => [
                'id' => (int) $question->id,
                'text' => $question->question,
                'help' => $question->help_text,
                'type' => $question->question_type,
                'required' => (bool) $question->pivot->is_required,
                'weight' => (float) $question->pivot->weight,
                'scale_id' => (int) $question->scale_id,
                'values' => $question->scale->values->where('is_active', true)->sortBy('id')->map(fn ($value) => [
                    'id' => (int) $value->id, 'label' => $value->label, 'value' => (float) $value->numeric_value,
                ])->values()->all(),
            ])->values()->all(),
        ];
    }

    public function indicators(Collection $published, bool $templateSelected): array
    {
        $result = ['count' => $published->count(), 'latest' => null, 'previous' => null, 'delta' => null,
            'series' => collect(), 'message' => 'Selecciona una plantilla para consultar sus indicadores.'];
        if (! $templateSelected) return $result;
        if ($published->isEmpty()) {
            $result['message'] = 'No hay resultados publicados para estos filtros.';
            return $result;
        }
        // Una observación por periodo: la última evaluación por fecha e ID.
        $ordered = $published->sortByDesc(fn ($evaluation) => [
            $evaluation->period?->start_date ?? '', $evaluation->period?->end_date ?? '',
            $evaluation->evaluation_date ?? '', $evaluation->id,
        ])->values();
        $periods = $ordered->unique('period_id')->values();
        $latest = $result['latest'] = $periods->first();
        $previous = $result['previous'] = $periods->get(1);
        if (! $latest->comparison_snapshot || ! $latest->period?->start_date) {
            $result['message'] = 'El último resultado no tiene una referencia histórica verificable de preguntas y escalas, o su periodo no tiene fecha de inicio. Se muestra sin comparación.';
            return $result;
        }
        $result['series']->push($latest);
        foreach ($periods->skip(1) as $evaluation) {
            if (! $evaluation->period?->start_date || ! $evaluation->comparison_snapshot
                || $evaluation->comparison_snapshot != $latest->comparison_snapshot
                || $evaluation->evaluation_type_id != $latest->evaluation_type_id
                || $evaluation->period->start_date === $latest->period->start_date) break;
            $result['series']->push($evaluation);
        }
        $result['series'] = $result['series']->reverse()->values();
        if ($result['series']->count() >= 2) {
            $result['delta'] = round((float) $latest->total_score - (float) $previous->total_score, 2);
            $result['message'] = 'Comparación entre periodos con la misma plantilla, preguntas, escalas y preguntas respondidas. La diferencia se expresa en puntos.';
        } else {
            $result['message'] = $previous
                ? 'El resultado anterior no es comparable: falta su referencia histórica o cambió el tipo, las preguntas, las escalas o las preguntas respondidas. Los periodos deben tener fechas de inicio distintas.'
                : 'Sin resultado anterior para comparar.';
        }
        return $result;
    }
}
