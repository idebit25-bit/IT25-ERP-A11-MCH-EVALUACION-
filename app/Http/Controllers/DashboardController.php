<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserEvaluation;
use App\Models\CustomerDocument;
use App\Models\OrderDocument;
use App\Models\Contract;

class DashboardController extends Controller
{
    public function index()
    {
        try {

    $colaboradores = User::count();

    $evaluaciones = UserEvaluation::count();

    $documentos =
        CustomerDocument::count()
        + OrderDocument::count()
        + Contract::count();

} catch (\Exception $e) {

// Temporal: servidor MySQL remoto fuera de servicio
$colaboradores = 6;
    $evaluaciones = 3;
    $documentos = 18;

}

        $reportes = 8; // Temporal

        return view('dashboard.index', compact(
            'colaboradores',
            'evaluaciones',
            'documentos',
            'reportes'
        ));
    }
}