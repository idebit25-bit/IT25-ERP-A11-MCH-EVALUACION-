<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = collect([

            [
                'id' => 'DOC-001',
                'nombre' => 'Manual ERP',
                'tipo' => 'Manual',
                'version' => '1.0',
                'vigencia' => '31/12/2026',
                'fecha' => '28/05/2026',
                'estado' => 'Vigente'
            ],

            [
                'id' => 'DOC-002',
                'nombre' => 'Formato Evaluación',
                'tipo' => 'Formato',
                'version' => '2.1',
                'vigencia' => '31/12/2026',
                'fecha' => '29/05/2026',
                'estado' => 'Actualizado'
            ],

            [
                'id' => 'DOC-003',
                'nombre' => 'Política RH',
                'tipo' => 'Política',
                'version' => '1.3',
                'vigencia' => '31/12/2026',
                'fecha' => '30/05/2026',
                'estado' => 'Vigente'
            ],
            
            [
                'id' => 'DOC-004',
                'nombre' => 'Procedimiento Calidad',
                'tipo' => 'Procedimiento',
                'version' => '3.0',
                'vigencia' => '31/12/2022',
                'fecha' => '31/05/2020',
                'estado' => 'Vencido'
            ],

            [
                'id' => 'DOC-005',
                'nombre' => 'Instructivo Seguridad',
                'tipo' => 'Manual',
                'version' => '1.2',
                'vigencia' => '31/12/2026',
                'fecha' => '01/06/2026',
                'estado' => 'Vigente'
            ]

            

        ]);


        // Buscador

        if(request('search'))
        {
            $search = strtolower(request('search'));

            $documentos = $documentos->filter(function($documento) use ($search)
            {
                return str_contains(
                    strtolower($documento['nombre']),
                    $search
                )
                ||
                str_contains(
                    strtolower($documento['tipo']),
                    $search
                )
                ||
                str_contains(
                    strtolower($documento['id']),
                    $search
                );
            });
        }

        // Filtrar por tipo

if(request('tipo'))
{
    $documentos = $documentos->filter(function($documento)
    {
        return $documento['tipo'] == request('tipo');
    });
}

        // Ordenamiento

if(request('order'))
{
    switch(request('order'))
    {
        case 'nombre':
            $documentos = $documentos->sortBy('nombre');
            break;

        case 'tipo':
            $documentos = $documentos->sortBy('tipo');
            break;

        case 'version':
            $documentos = $documentos->sortBy('version');
            break;

        case 'vigencia':
            $documentos = $documentos->sortBy('vigencia');
            break;

        case 'fecha':
            $documentos = $documentos->sortBy('fecha');
            break;

        case 'estado':
            $documentos = $documentos->sortBy('estado');
            break;
    }
}

        return view(
            'documentos.index',
            compact('documentos')
        );
    }

public function show($id)
{
    $documentos = collect([

        [
            'id' => 'DOC-001',
            'nombre' => 'Manual ERP',
            'tipo' => 'Manual',
            'version' => '1.0',
            'vigencia' => '31/12/2026',
            'fecha' => '28/05/2026',
            'estado' => 'Vigente',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-002',
            'nombre' => 'Formato Evaluación',
            'tipo' => 'Formato',
            'version' => '2.1',
            'vigencia' => '31/12/2026',
            'fecha' => '29/05/2026',
            'estado' => 'Actualizado',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-003',
            'nombre' => 'Política RH',
            'tipo' => 'Política',
            'version' => '1.3',
            'vigencia' => '31/12/2026',
            'fecha' => '30/05/2026',
            'estado' => 'Vigente',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-004',
            'nombre' => 'Procedimiento Calidad',
            'tipo' => 'Procedimiento',
            'version' => '3.0',
            'vigencia' => '31/12/2022',
            'fecha' => '31/05/2020',
            'estado' => 'Vencido',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-005',
            'nombre' => 'Instructivo Seguridad',
            'tipo' => 'Manual',
            'version' => '1.2',
            'vigencia' => '31/12/2026',
            'fecha' => '01/06/2026',
            'estado' => 'Vigente',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        // Manuales
    [ 
    'id' => 'MAN-001',
    'nombre' => 'Manual ERP Capital Humano',
    'tipo' => 'Manual',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'MAN-002',
    'nombre' => 'Manual de Evaluaciones',
    'tipo' => 'Manual',
    'version' => '1.2',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente' ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

// Formatos
[
    'id' => 'FOR-001',
    'nombre' => 'Formato de Evaluación de Desempeño',
    'tipo' => 'Formato',
    'version' => '2.1',
    'vigencia' => '31/12/2026',
    'fecha' => '29/05/2026',
    'estado' => 'Vigente' ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'FOR-002',
    'nombre' => 'Formato Solicitud de Vacaciones',
    'tipo' => 'Formato',
    'version' => '1.3',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente' ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

// Políticas
[
    'id' => 'POL-001',
    'nombre' => 'Política de Asistencia',
    'tipo' => 'Política',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'POL-002',
    'nombre' => 'Política de Vacaciones',
    'tipo' => 'Política',
    'version' => '1.2',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente' ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

// Procedimientos
[
    'id' => 'PROC-001',
    'nombre' => 'Proceso de Reclutamiento',
    'tipo' => 'Procedimiento',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'PROC-002',
    'nombre' => 'Proceso de Evaluación',
    'tipo' => 'Procedimiento',
    'version' => '1.1',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente' ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

    ]);

    $documento = $documentos->firstWhere('id', $id);

    abort_if(!$documento, 404);

    return view(
        'documentos.show',
        compact('documento')
    );
}

public function edit($id)
{
    $documentos = collect([

        [
            'id' => 'DOC-001',
            'nombre' => 'Manual ERP',
            'tipo' => 'Manual',
            'version' => '1.0',
            'vigencia' => '31/12/2026',
            'fecha' => '28/05/2026',
            'estado' => 'Vigente' ,
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-002',
            'nombre' => 'Formato Evaluación',
            'tipo' => 'Formato',
            'version' => '2.1',
            'vigencia' => '31/12/2026',
            'fecha' => '29/05/2026',
            'estado' => 'Actualizado',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-003',
            'nombre' => 'Política RH',
            'tipo' => 'Política',
            'version' => '1.3',
            'vigencia' => '31/12/2026',
            'fecha' => '30/05/2026',
            'estado' => 'Vigente',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-004',
            'nombre' => 'Procedimiento Calidad',
            'tipo' => 'Procedimiento',
            'version' => '3.0',
            'vigencia' => '31/12/2022',
            'fecha' => '31/05/2020',
            'estado' => 'Vencido',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

        [
            'id' => 'DOC-005',
            'nombre' => 'Instructivo Seguridad',
            'tipo' => 'Manual',
            'version' => '1.2',
            'vigencia' => '31/12/2026',
            'fecha' => '01/06/2026',
            'estado' => 'Vigente',
            'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ],

// Manuales

[ 
    'id' => 'MAN-001',
    'nombre' => 'Manual ERP Capital Humano',
    'tipo' => 'Manual',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'MAN-002',
    'nombre' => 'Manual de Evaluaciones',
    'tipo' => 'Manual',
    'version' => '1.2',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],
// Formatos

[
    'id' => 'FOR-001',
    'nombre' => 'Formato de Evaluación de Desempeño',
    'tipo' => 'Formato',
    'version' => '2.1',
    'vigencia' => '31/12/2026',
    'fecha' => '29/05/2026',
    'estado' => 'Vigente'   ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'FOR-002',
    'nombre' => 'Formato Solicitud de Vacaciones',
    'tipo' => 'Formato',
    'version' => '1.3',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente'  ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

// Políticas
[
    'id' => 'POL-001',
    'nombre' => 'Política de Asistencia',
    'tipo' => 'Política',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente'   ,
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'POL-002',
    'nombre' => 'Política de Vacaciones',
    'tipo' => 'Política',
    'version' => '1.2',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

// Procedimientos
[
    'id' => 'PROC-001',
    'nombre' => 'Proceso de Reclutamiento',
    'tipo' => 'Procedimiento',
    'version' => '1.0',
    'vigencia' => '31/12/2026',
    'fecha' => '28/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],

[
    'id' => 'PROC-002',
    'nombre' => 'Proceso de Evaluación',
    'tipo' => 'Procedimiento',
    'version' => '1.1',
    'vigencia' => '31/12/2026',
    'fecha' => '30/05/2026',
    'estado' => 'Vigente',
    'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
],
    ]);

    $documento = $documentos->firstWhere('id', $id);

    abort_if(!$documento, 404);

    return view(
        'documentos.edit',
        compact('documento')
    );
}
}