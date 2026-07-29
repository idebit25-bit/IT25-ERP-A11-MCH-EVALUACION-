<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EvaluacionesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Colección de evaluaciones.
     */
    protected Collection $evaluaciones;

    /**
     * Constructor.
     */
    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    /**
     * Obtener la colección para exportar.
     */
    public function collection()
    {
        return $this->evaluaciones;
    }

/**
 * Encabezados del archivo Excel.
 */
public function headings(): array
{
    return [
        'Colaborador',
        'Departamento',
        'Tipo de evaluación',
        'Período',
        'Evaluador',
        'Calificación',
        'Estado',
    ];
}

/**
 * Mapear cada evaluación a una fila.
 */
public function map($evaluacion): array
{
    return [
        $evaluacion->user?->full_name,
        $evaluacion->user?->department?->name,
        $evaluacion->evaluationType?->name,
        $evaluacion->period?->name,
        $evaluacion->evaluator?->full_name,
        number_format($evaluacion->total_score, 2),
        $evaluacion->status_label,
    ];
}
}