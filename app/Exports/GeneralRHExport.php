<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralRHExport implements FromCollection, WithHeadings
{
    /**
     * Datos del reporte.
     */
    protected array $datos;

    /**
     * Constructor.
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Encabezados.
     */
    public function headings(): array
    {
        return [

            'Indicador',

            'Total',

        ];
    }

    /**
     * Información del reporte.
     */
    public function collection()
    {
        return new Collection([

            [

                'Colaboradores registrados',

                $this->datos['colaboradores'],

            ],

            [

                'Evaluaciones registradas',

                $this->datos['evaluaciones'],

            ],

            [

                'Documentos registrados',

                $this->datos['documentos'],

            ],

            [

                'Departamentos registrados',

                $this->datos['departamentos'],

            ],

        ]);
    }
}