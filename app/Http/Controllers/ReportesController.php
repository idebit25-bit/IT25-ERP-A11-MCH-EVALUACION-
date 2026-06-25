<?php

namespace App\Http\Controllers;

class ReportesController extends Controller
{
public function index()
{
    try {

        // Cuando vuelva la BD aquí irán las consultas reales

    // UserEvaluation::count()
    $evaluacionesRealizadas = 0;
    // Promedio general de evaluaciones
    $promedioGeneral = 0;
    // CustomerDocument + OrderDocument + Contract
    $documentosActivos = 35;
    // User::count()
    $colaboradores = 6;

    $desempeñoDepartamentos = [
        [
            'nombre' => 'Ingeniería y Proyectos',
            'porcentaje' => 90
             ],
            [
                'nombre' => 'Recursos Humanos',
                'porcentaje' => 75
            ],
            [
                'nombre' => 'Administración y Finanzas',
                'porcentaje' => 80
            ],
            [
                'nombre' => 'Sistemas (TI)',
                'porcentaje' => 65
            ],
       
    ];

    $resumenMensual = [

    [
        'mes' => 'Enero',
        'evaluaciones' => 15
    ],

    [
        'mes' => 'Febrero',
        'evaluaciones' => 22
    ],

    [
        'mes' => 'Marzo',
        'evaluaciones' => 18
    ],

    [
        'mes' => 'Abril',
        'evaluaciones' => 27
    ],

    [
        'mes' => 'Mayo',
        'evaluaciones' => 31
    ],

    [
        'mes' => 'Junio',
        'evaluaciones' => 43
    ]

];

$ultimosReportes = [

    [
        'nombre' => 'Evaluaciones Mayo 2026',
        'tipo' => 'Evaluaciones'
    ],

    [
        'nombre' => 'Resumen Recursos Humanos',
        'tipo' => 'RH'
    ],

    [
        'nombre' => 'Documentos Vigentes',
        'tipo' => 'Documentos'
    ],

    [
        'nombre' => 'Reporte General RH',
        'tipo' => 'General'
    ]

];

$historialReportes = [

    [
        'id' => 'REP-001',
        'nombre' => 'Evaluaciones Mayo',
        'tipo' => 'Evaluaciones',
        'fecha' => '31/05/2026',
        'usuario' => 'César Hernández',
        'estado' => 'Disponible'
    ],

    [
        'id' => 'REP-002',
        'nombre' => 'Reporte General RH',
        'tipo' => 'General RH',
        'fecha' => '30/05/2026',
        'usuario' => 'César Hernández',
        'estado' => 'Disponible'
    ]

];

    } catch (\Exception $e) {

        // Valores de respaldo

        $evaluacionesRealizadas = 0;
        $colaboradores = 0;
        $documentosActivos = 0;
        $promedioGeneral = 0;
        $desempeñoDepartamentos = [];
        $resumenMensual = [];
        $ultimosReportes = [];
        $historialReportes = [];
    }

    return view('reportes.index', compact(
        'evaluacionesRealizadas',
        'promedioGeneral',
        'documentosActivos',
        'colaboradores',
        'desempeñoDepartamentos',
        'resumenMensual',
        'ultimosReportes',
        'historialReportes'
    ));
}

    public function generarPdf($tipo)
    {
        return view('reportes.pdf', compact('tipo'));
    }

    public function generarExcel($tipo)
    {
        return view('reportes.excel', compact('tipo'));
    }
}