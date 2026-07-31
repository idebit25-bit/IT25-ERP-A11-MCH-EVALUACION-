<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ColaboradoresExport implements FromCollection, WithHeadings
{
    /**
     * Datos del reporte.
     */
    protected Collection $colaboradores;

    /**
     * Constructor.
     */
    public function __construct(Collection $colaboradores)
    {
        $this->colaboradores = $colaboradores;
    }

    /**
     * Encabezados.
     */
    public function headings(): array
    {
        return [

            'Código',

            'Colaborador',

            'Departamento',

            'Puesto',

            'Estado',

        ];
    }

    /**
     * Información del reporte.
     */
    public function collection()
    {
        return $this->colaboradores->map(function ($usuario) {

            return [

                $usuario->employee_code,

                $usuario->full_name,

                $usuario->department?->name,

                $usuario->position?->name,

                ucfirst($usuario->status),

            ];

        });
    }
}