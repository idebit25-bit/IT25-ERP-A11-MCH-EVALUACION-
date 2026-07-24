<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\Department;
use App\Models\EvaluationType;
use App\Models\EvaluationPeriod;



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
$evaluaciones = Evaluation::with([
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

    public function generarPdf($tipo)
    {
        return view('reportes.pdf', compact('tipo'));
    }

    public function generarExcel($tipo)
    {
        return view('reportes.excel', compact('tipo'));
    }
}