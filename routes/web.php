<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesController;

/* Ruta principal */

Route::get('/', function () {
    return redirect('/dashboard');
});

/* Dashboard */

Route::get('/dashboard',
    [DashboardController::class, 'index']
);

/* Evaluaciones */

Route::get('/evaluaciones', [EvaluationController::class, 'index']);

Route::get('/evaluaciones/create', function () {
    return view('evaluaciones.create');
});

/* Documentos */

Route::get('/documentos', [DocumentoController::class, 'index']);

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

Route::get('/documentos/{id}/edit' ,
[DocumentoController::class, 'edit']);

Route::get('/documentos/{id}', [DocumentoController::class, 'show']);


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

Route::get('/reportes', [ReportesController::class, 'index'])
->name('reportes.index');


Route::get('/reportes/evaluaciones/pdf', function () {
    return 'PDF de Evaluaciones';
});

Route::get('/reportes/evaluaciones/excel', function () {
    return 'Excel de Evaluaciones';
});

Route::get('/reportes/colaboradores/pdf', function () {
    return 'PDF de Colaboradores';
});

Route::get('/reportes/colaboradores/excel', function () {
    return 'Excel de Colaboradores';
});

Route::get('/reportes/documentos/pdf', function () {
    return 'PDF de Documentos';
});

Route::get('/reportes/documentos/excel', function () {
    return 'Excel de Documentos';
});

Route::get('/reportes/general/pdf', function () {
    return 'PDF General RH';
});

Route::get('/reportes/general/excel', function () {
    return 'Excel General RH';
});