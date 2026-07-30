<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use App\Models\Document;

class DashboardController extends Controller
{
public function index()
{
    try {

        // Obtener indicadores

        $colaboradores = User::count();

        $evaluaciones = Evaluation::count();

        $documentos = Document::count();

        // Reportes disponibles

        $reportes = 4;

    } catch (\Exception $e) {

        $colaboradores = 0;
        $evaluaciones = 0;
        $documentos = 0;
        $reportes = 0;
    }

    // Obtener las últimas evaluaciones

$ultimasEvaluaciones = Evaluation::with([
    'user',
    'evaluationType',
])
->orderByDesc('evaluation_date')
->take(5)
->get();

return view('dashboard.index', compact(
    'colaboradores',
    'evaluaciones',
    'documentos',
    'reportes',
    'ultimasEvaluaciones'
));

}

}