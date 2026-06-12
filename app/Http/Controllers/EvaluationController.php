<?php

namespace App\Http\Controllers;

use App\Models\UserEvaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = UserEvaluation::with('user')->get();

        return view('evaluaciones.index', compact('evaluations'));
    }
}