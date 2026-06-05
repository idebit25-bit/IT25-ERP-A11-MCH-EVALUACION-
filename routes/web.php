<?php

use Illuminate\Support\Facades\Route;

/* Ruta principal */

Route::get('/', function () {
    return redirect('/dashboard');
});

/* Dashboard */

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

/* Evaluaciones */

Route::get('/evaluaciones', function () {
    return view('evaluaciones.index');
});

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

Route::get('/colaboradores', function () {
    return view('colaboradores.index');
});

/* Reportes */

Route::get('/reportes', function () {
    return view('reportes.index');
});