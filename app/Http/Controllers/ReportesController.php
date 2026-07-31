<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\Department;
use App\Models\EvaluationType;
use App\Models\EvaluationPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\EvaluacionesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Document;
use App\Exports\ColaboradoresExport;
use App\Exports\DocumentosExport;
use App\Exports\GeneralRHExport;



class ReportesController extends Controller
{

public function index()
{
    try {

// Obtener evaluaciones para el Dashboard
$evaluacionesDashboard = Evaluation::with([
    'user',
    'evaluationType',
    'period',
    'evaluator'
])->get();

// Total de evaluaciones
$evaluacionesRealizadas = $evaluacionesDashboard->count();

// Promedio general
$promedioGeneral = round(
    $evaluacionesDashboard->avg('total_score') ?? 0,
    2
);

// Temporal mientras se integra el módulo de documentos
$documentosActivos = 35;

// Total de colaboradores
$colaboradores = User::count();


    $desempeñoDepartamentos = Department::with([
    'users.evaluations'
])->get()->map(function ($department) {

    $evaluaciones = $department->users
        ->flatMap(function ($user) {
            return $user->evaluations;
        });

    $promedio = round($evaluaciones->avg('total_score') ?? 0, 2);

    return [
        'nombre' => $department->name,
        'porcentaje' => $promedio
    ];

})->toArray();

$resumenMensual = $evaluacionesDashboard
    ->groupBy(function ($evaluacion) {
        return \Carbon\Carbon::parse($evaluacion->evaluation_date)->translatedFormat('F');
    })
    ->map(function ($evaluaciones, $mes) {
        return [
            'mes' => ucfirst($mes),
            'evaluaciones' => $evaluaciones->count()
        ];
    })
    ->values()
    ->toArray();


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

// Catálogos para filtros

$usuarios = User::where('status', 'active')
    ->orderBy('first_name')
    ->get();

$departamentos = Department::where('is_active', true)
    ->orderBy('name')
    ->get();

$tiposEvaluacion = EvaluationType::where('is_active', true)
    ->orderBy('name')
    ->get();

$periodos = EvaluationPeriod::where('is_active', true)
    ->orderBy('name')
    ->get();

// Evaluaciones para el historial
$evaluaciones = $this->obtenerEvaluaciones();

return view('reportes.index', compact(
    'evaluaciones',
    'evaluacionesRealizadas',
    'promedioGeneral',
    'documentosActivos',
    'colaboradores',
    'desempeñoDepartamentos',
    'resumenMensual',

    'usuarios',
    'departamentos',
    'tiposEvaluacion',
    'periodos'
));

}

/**
 * Generar reporte en PDF.
 */
public function generarPdf(Request $request, $tipo)
{
    // Obtener información del reporte

    switch ($tipo) {

        case 'colaboradores':

            $datos = $this->obtenerColaboradores();

            break;

        case 'documentos':

            $datos = $this->obtenerDocumentos();

            break;

        case 'general':

            $datos = $this->obtenerResumenGeneral();

            break;

        default:

            $datos = $this->obtenerEvaluaciones();

            break;

    }

    // Variables para la vista

    $variables = [

        'tipo' => $tipo,

        'usuario' => auth()->user(),

    ];

    // El reporte de evaluaciones utiliza la variable original

    if ($tipo == 'evaluaciones') {

        $variables['evaluaciones'] = $datos;

    } else {

        $variables['datos'] = $datos;

    }

    // Generar PDF

    $pdf = Pdf::loadView(

        'reportes.pdf.' . $tipo,

        $variables

    );

    return $pdf->stream(

        'reporte_' . $tipo . '.pdf'

    );
}

/**
 * Generar reporte en Excel.
 */
public function generarExcel(Request $request, $tipo)
{
    switch ($tipo) {

        case 'colaboradores':

            return Excel::download(

                new ColaboradoresExport(
                    $this->obtenerColaboradores()
                ),

                'reporte_colaboradores.xlsx'

            );

        case 'documentos':

            return Excel::download(

                new DocumentosExport(
                    $this->obtenerDocumentos()
                ),

                'reporte_documentos.xlsx'

            );

        case 'general':

            return Excel::download(

                new GeneralRHExport(
                    $this->obtenerResumenGeneral()
                ),

                'reporte_general_rh.xlsx'

            );

        default:

            return Excel::download(

                new EvaluacionesExport(
                    $this->obtenerEvaluaciones()
                ),

                'reporte_evaluaciones.xlsx'

            );

    }
}

private function obtenerEvaluaciones()
{
    return Evaluation::with([
        'user.department',
        'evaluationType',
        'period',
        'evaluator'
    ])

    ->when(request('user_id'), function ($query) {
        $query->where('user_id', request('user_id'));
    })

    ->when(request('department_id'), function ($query) {
        $query->whereHas('user', function ($q) {
            $q->where('department_id', request('department_id'));
        });
    })

    ->when(request('evaluation_type_id'), function ($query) {
        $query->where('evaluation_type_id', request('evaluation_type_id'));
    })

    ->when(request('period_id'), function ($query) {
        $query->where('period_id', request('period_id'));
    })

    ->when(request('status'), function ($query) {
        $query->where('status', request('status'));
    })

    ->latest()
    ->get();
}

/**
 * Obtener colaboradores para el reporte.
 */
private function obtenerColaboradores()
{
    return User::with([
        'department',
        'position',
    ])
    ->orderBy('first_name')
    ->get();
}

/**
 * Obtener documentos para el reporte.
 */
private function obtenerDocumentos()
{
    return Document::orderByDesc('created_at')
        ->get();
}

/**
 * Obtener resumen general del módulo.
 */
private function obtenerResumenGeneral()
{
    return [

        'colaboradores' => User::count(),

        'evaluaciones' => Evaluation::count(),

        'documentos' => Document::count(),

        'departamentos' => Department::count(),

    ];
}

}