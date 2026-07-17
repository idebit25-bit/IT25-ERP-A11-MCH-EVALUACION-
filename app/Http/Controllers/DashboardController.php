<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserEvaluation;

class DashboardController extends Controller
{
    public function index()
    {
        try {

            $colaboradores = User::count();

            $evaluaciones = UserEvaluation::count();

            $documentos = 0;

        } catch (\Exception $e) {

            $colaboradores = 6;
            $evaluaciones = 3;
            $documentos = 18;
        }

        $reportes = 8;

        return view('dashboard.index', compact(
            'colaboradores',
            'evaluaciones',
            'documentos',
            'reportes'
        ));
    }
}