<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentosExport implements FromCollection, WithHeadings
{
    /**
     * Datos del reporte.
     */
    protected Collection $documentos;

    /**
     * Constructor.
     */
    public function __construct(Collection $documentos)
    {
        $this->documentos = $documentos;
    }

    /**
     * Encabezados.
     */
    public function headings(): array
    {
        return [

            'Código',

            'Documento',

            'Tipo',

            'Versión',

            'Estado',

            'Vigencia',

        ];
    }

    /**
     * Información del reporte.
     */
    public function collection()
    {
        return $this->documentos->map(function ($documento) {

            return [

                $documento->code,

                $documento->name,

                $documento->type,

                $documento->version,

                $documento->status,

                optional($documento->expiration_date)
                    ? \Carbon\Carbon::parse($documento->expiration_date)->format('d/m/Y')
                    : null,

            ];

        });
    }
}