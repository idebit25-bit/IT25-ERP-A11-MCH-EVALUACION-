<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\EvaluationTypeController;
use App\Http\Controllers\EvaluationPeriodController;
use App\Http\Controllers\EvaluationCategoryController;
use App\Http\Controllers\EvaluationCompetencyController;
use App\Http\Controllers\EvaluationScaleController;
use App\Http\Controllers\EvaluationQuestionController;
use App\Http\Controllers\EvaluationTemplateController;
use App\Http\Controllers\EvaluationTemplateQuestionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ActivityLogController;


/* Login */

Route::get(
    '/login',
    [LoginController::class, 'create']
)->name('login');

Route::post(
    '/login',
    [LoginController::class, 'store']
)->name('login.store');


Route::middleware('auth')->group(function () {

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->name('logout');

    Route::get(
    '/configuracion/bitacora',
    [ActivityLogController::class, 'index']
)->name('activity-logs.index');

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

Route::get('/configuracion', [ConfiguracionController::class, 'index'])
    ->name('configuracion.index');

Route::get(
    '/configuracion/usuarios',
    [ConfiguracionController::class, 'usuarios']
)->name('configuracion.usuarios');

Route::get(
    '/configuracion/roles',
    [ConfiguracionController::class, 'roles']
)->name('configuracion.roles');


/* Tipos de evaluación */

Route::get(
    '/configuracion/tipos-evaluacion',
    [EvaluationTypeController::class, 'index']
)->name('evaluation-types.index');

Route::get(
    '/configuracion/tipos-evaluacion/create',
    [EvaluationTypeController::class, 'create']
)->name('evaluation-types.create');

Route::post(
    '/configuracion/tipos-evaluacion',
    [EvaluationTypeController::class, 'store']
)->name('evaluation-types.store');

Route::get(
    '/configuracion/tipos-evaluacion/{id}',
    [EvaluationTypeController::class, 'show']
)->name('evaluation-types.show');

Route::get(
    '/configuracion/tipos-evaluacion/{id}/edit',
    [EvaluationTypeController::class, 'edit']
)->name('evaluation-types.edit');

Route::put(
    '/configuracion/tipos-evaluacion/{id}',
    [EvaluationTypeController::class, 'update']
)->name('evaluation-types.update');

Route::delete(
    '/configuracion/tipos-evaluacion/{id}',
    [EvaluationTypeController::class, 'destroy']
)->name('evaluation-types.destroy');

/* Períodos de evaluación */

Route::get(
    '/configuracion/periodos',
    [EvaluationPeriodController::class, 'index']
)->name('evaluation-periods.index');

Route::get(
    '/configuracion/periodos/create',
    [EvaluationPeriodController::class, 'create']
)->name('evaluation-periods.create');

Route::post(
    '/configuracion/periodos',
    [EvaluationPeriodController::class, 'store']
)->name('evaluation-periods.store');

Route::get(
    '/configuracion/periodos/{id}',
    [EvaluationPeriodController::class, 'show']
)->name('evaluation-periods.show');

Route::get(
    '/configuracion/periodos/{id}/edit',
    [EvaluationPeriodController::class, 'edit'
])->name('evaluation-periods.edit');

Route::put(
    '/configuracion/periodos/{id}',
    [EvaluationPeriodController::class, 'update']
)->name('evaluation-periods.update');

Route::delete(
    '/configuracion/periodos/{id}',
    [EvaluationPeriodController::class, 'destroy']
)->name('evaluation-periods.destroy');

/* Categorías de evaluación */

Route::get(
    '/configuracion/categorias',
    [EvaluationCategoryController::class, 'index']
)->name('evaluation-categories.index');

Route::get(
    '/configuracion/categorias/create',
    [EvaluationCategoryController::class, 'create']
)->name('evaluation-categories.create');

Route::post(
    '/configuracion/categorias',
    [EvaluationCategoryController::class, 'store']
)->name('evaluation-categories.store');

Route::get(
    '/configuracion/categorias/{id}',
    [EvaluationCategoryController::class, 'show']
)->name('evaluation-categories.show');

Route::get(
    '/configuracion/categorias/{id}/edit',
    [EvaluationCategoryController::class, 'edit']
)->name('evaluation-categories.edit');

Route::put(
    '/configuracion/categorias/{id}',
    [EvaluationCategoryController::class, 'update']
)->name('evaluation-categories.update');

Route::delete(
    '/configuracion/categorias/{id}',
    [EvaluationCategoryController::class, 'destroy']
)->name('evaluation-categories.destroy');

/* Competencias de evaluación */

Route::get(
    '/configuracion/competencias',
    [EvaluationCompetencyController::class, 'index']
)->name('evaluation-competencies.index');

Route::get(
    '/configuracion/competencias/create',
    [EvaluationCompetencyController::class, 'create']
)->name('evaluation-competencies.create');

Route::post(
    '/configuracion/competencias',
    [EvaluationCompetencyController::class, 'store']
)->name('evaluation-competencies.store');

Route::get(
    '/configuracion/competencias/{id}',
    [EvaluationCompetencyController::class, 'show']
)->name('evaluation-competencies.show');

Route::get(
    '/configuracion/competencias/{id}/edit',
    [EvaluationCompetencyController::class, 'edit']
)->name('evaluation-competencies.edit');

Route::put(
    '/configuracion/competencias/{id}',
    [EvaluationCompetencyController::class, 'update']
)->name('evaluation-competencies.update');

Route::delete(
    '/configuracion/competencias/{id}',
    [EvaluationCompetencyController::class, 'destroy']
)->name('evaluation-competencies.destroy');

/* Escalas de evaluación */

Route::get(
    '/configuracion/escalas',
    [EvaluationScaleController::class, 'index']
)->name('evaluation-scales.index');

Route::get(
    '/configuracion/escalas/create',
    [EvaluationScaleController::class, 'create']
)->name('evaluation-scales.create');

Route::post(
    '/configuracion/escalas',
    [EvaluationScaleController::class, 'store']
)->name('evaluation-scales.store');

Route::get(
    '/configuracion/escalas/{id}',
    [EvaluationScaleController::class, 'show']
)->name('evaluation-scales.show');

Route::get(
    '/configuracion/escalas/{id}/edit',
    [EvaluationScaleController::class, 'edit']
)->name('evaluation-scales.edit');

Route::put(
    '/configuracion/escalas/{id}',
    [EvaluationScaleController::class, 'update']
)->name('evaluation-scales.update');

Route::delete(
    '/configuracion/escalas/{id}',
    [EvaluationScaleController::class, 'destroy']
)->name('evaluation-scales.destroy');

/* Banco de preguntas */

Route::get(
    '/configuracion/preguntas',
    [EvaluationQuestionController::class, 'index']
)->name('evaluation-questions.index');

Route::get(
    '/configuracion/preguntas/create',
    [EvaluationQuestionController::class, 'create']
)->name('evaluation-questions.create');

Route::post(
    '/configuracion/preguntas',
    [EvaluationQuestionController::class, 'store']
)->name('evaluation-questions.store');

Route::get(
    '/configuracion/preguntas/{id}',
    [EvaluationQuestionController::class, 'show']
)->name('evaluation-questions.show');

Route::get(
    '/configuracion/preguntas/{id}/edit',
    [EvaluationQuestionController::class, 'edit']
)->name('evaluation-questions.edit');

Route::put(
    '/configuracion/preguntas/{id}',
    [EvaluationQuestionController::class, 'update']
)->name('evaluation-questions.update');

Route::delete(
    '/configuracion/preguntas/{id}',
    [EvaluationQuestionController::class, 'destroy']
)->name('evaluation-questions.destroy');

/* Plantillas */

Route::get(
    '/configuracion/plantillas',
    [EvaluationTemplateController::class, 'index']
)->name('evaluation-templates.index');

Route::get(
    '/configuracion/plantillas/create',
    [EvaluationTemplateController::class, 'create']
)->name('evaluation-templates.create');

Route::post(
    '/configuracion/plantillas',
    [EvaluationTemplateController::class, 'store']
)->name('evaluation-templates.store');

Route::get(
    '/configuracion/plantillas/{id}',
    [EvaluationTemplateController::class, 'show']
)->name('evaluation-templates.show');

Route::get(
    '/configuracion/plantillas/{id}/edit',
    [EvaluationTemplateController::class, 'edit']
)->name('evaluation-templates.edit');

Route::put(
    '/configuracion/plantillas/{id}',
    [EvaluationTemplateController::class, 'update'
])->name('evaluation-templates.update');

Route::delete(
    '/configuracion/plantillas/{id}',
    [EvaluationTemplateController::class, 'destroy'
])->name('evaluation-templates.destroy');

/* Preguntas de plantilla */

Route::get(
    '/configuracion/plantillas/{template}/preguntas',
    [EvaluationTemplateQuestionController::class, 'index']
)->name('template-questions.index');

Route::get(
    '/configuracion/plantillas/{template}/preguntas/create',
    [EvaluationTemplateQuestionController::class, 'create']
)->name('template-questions.create');

Route::post(
    '/configuracion/plantillas/{template}/preguntas/{question}',
    [EvaluationTemplateQuestionController::class, 'store']
)->name('template-questions.store');

Route::get(
    '/configuracion/plantillas/{template}/preguntas/{id}/edit',
    [EvaluationTemplateQuestionController::class, 'edit'
])->name('template-questions.edit');

Route::put(
    '/configuracion/plantillas/{template}/preguntas/{id}',
    [EvaluationTemplateQuestionController::class, 'update'
])->name('template-questions.update');

Route::delete(
    '/configuracion/plantillas/{template}/preguntas/{id}',
    [EvaluationTemplateQuestionController::class, 'destroy'
])->name('template-questions.destroy');


/* Colaboradores */

Route::get('/colaboradores', [ColaboradorController::class, 'index'])
    ->name('colaboradores.index');

Route::get('/colaboradores/create', [ColaboradorController::class, 'create'])
    ->name('colaboradores.create');

Route::post('/colaboradores', [ColaboradorController::class, 'store'])
    ->name('colaboradores.store');

Route::get('/colaboradores/{id}/edit', [ColaboradorController::class, 'edit'])
    ->name('colaboradores.edit');

Route::put('/colaboradores/{id}', [ColaboradorController::class, 'update'])
    ->name('colaboradores.update');

Route::delete('/colaboradores/{id}', [ColaboradorController::class, 'destroy'])
    ->name('colaboradores.destroy');

Route::get('/colaboradores/{id}', [ColaboradorController::class, 'show'])
    ->name('colaboradores.show');

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



});