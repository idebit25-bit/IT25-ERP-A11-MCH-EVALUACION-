<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ColaboradorController;

/* Ruta principal */

Route::get('/', function () {
    return redirect('/dashboard');
});

/* Dashboard */

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

/* Evaluaciones */

Route::get('/evaluaciones', [EvaluationController::class, 'index']);

Route::get('/evaluaciones/create', function () {
    return view('evaluaciones.create');
});

/* Documentos */

Route::get('/documentos', function () {
    return view('documentos.index');
});

Route::get('/documentos/manuales', function () {
    return view('documentos.manuales');
});

Route::get('/documentos/formatos', function () {
    return view('documentos.formatos');
});

Route::get('/documentos/politicas', function () {
    return view('documentos.politicas');
});

Route::get('/documentos/procedimientos', function () {
    return view('documentos.procedimientos');
});

/* Configuracion */

Route::get('/configuracion', function () {
    return view('configuracion.index');
});

Route::get('/configuracion/usuarios', function () {
    return view('configuracion.usuarios');
});

Route::get('/configuracion/roles', function () {
    return view('configuracion.roles');
});

Route::get('/configuracion/perfil', function () {
    return view('configuracion.perfil');
});

Route::get('/configuracion/empresa', function () {
    return view('configuracion.empresa');
});

/* Colaboradores */

Route::get('/colaboradores', [ColaboradorController::class, 'index']);
Route::get('/colaboradores/{id}', [ColaboradorController::class, 'show']);

/* Reportes */

Route::get('/reportes', function () {
    return view('reportes.index');
});