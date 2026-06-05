@extends('layouts.app')

@section('content')

<div class="content-wrapper">


<!-- Encabezado -->

<div class="dashboard-header">

    <h1>
        Reportes
    </h1>

    <p>
        Estadísticas e indicadores generales del módulo de Capital Humano.
    </p>

</div>

<!-- Tipos de reportes -->

<div class="row mb-4">

    <div class="col-md-3 mb-3">

        <div class="card border-0 dashboard-card">

            <div class="card-body text-center">

                <i class="bi bi-clipboard-data text-primary fs-1"></i>

                <h5 class="mt-3">
                    Evaluaciones
                </h5>

                <p class="card-text">
                    Reportes de desempeño.
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card border-0 dashboard-card">

            <div class="card-body text-center">

                <i class="bi bi-people text-success fs-1"></i>

                <h5 class="mt-3">
                    Colaboradores
                </h5>

                <p class="card-text">
                    Información de personal.
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card border-0 dashboard-card">

            <div class="card-body text-center">

                <i class="bi bi-folder2-open text-warning fs-1"></i>

                <h5 class="mt-3">
                    Documentos
                </h5>

                <p class="card-text">
                    Reportes documentales.
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card border-0 dashboard-card">

            <div class="card-body text-center">

                <i class="bi bi-bar-chart-line text-danger fs-1"></i>

                <h5 class="mt-3">
                    General ERP
                </h5>

                <p class="card-text">
                    Resumen ejecutivo.
                </p>

            </div>

        </div>

    </div>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Evaluaciones realizadas
                </span>

                <h2>
                    156
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Promedio general
                </span>

                <h2>
                    89%
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Documentos activos
                </span>

                <h2>
                    35
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Colaboradores
                </span>

                <h2>
                    24
                </h2>

            </div>

        </div>

    </div>

</div>



<!-- Barra superior -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <strong>
                    Centro de Reportes
                </strong>

                <p class="text-muted mb-0">
                    Generación y consulta de reportes del sistema.
                </p>

            </div>

            <button class="btn btn-primary">

                <i class="bi bi-file-earmark-arrow-down"></i>

                Generar Reporte

            </button>

        </div>

    </div>

</div>

<!-- Gráficas -->

<div class="row">

    <div class="col-md-6 mb-4">

        <div class="card border-0 table-card">

            <div class="card-header">

                Desempeño por área

            </div>

            <div class="card-body">

                <div class="report-bar">

                    <span>Desarrollo</span>

                    <div class="bar-fill" style="width:90%"></div>

                </div>

                <div class="report-bar">

                    <span>Recursos Humanos</span>

                    <div class="bar-fill" style="width:75%"></div>

                </div>

                <div class="report-bar">

                    <span>Soporte</span>

                    <div class="bar-fill" style="width:85%"></div>

                </div>

                <div class="report-bar">

                    <span>Administración</span>

                    <div class="bar-fill" style="width:70%"></div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 mb-4">

        <div class="card border-0 table-card">

            <div class="card-header">

                Resumen mensual

            </div>

            <div class="card-body">

                <table class="table">

                    <thead>

                        <tr>

                            <th>Mes</th>

                            <th>Evaluaciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>Enero</td>

                            <td>15</td>

                        </tr>

                        <tr>

                            <td>Febrero</td>

                            <td>22</td>

                        </tr>

                        <tr>

                            <td>Marzo</td>

                            <td>18</td>

                        </tr>

                        <tr>

                            <td>Abril</td>

                            <td>27</td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- Últimos reportes -->

<div class="card border-0 table-card mb-4">

    <div class="card-header">

        Últimos reportes generados

    </div>

    <div class="card-body">

        <ul class="mb-0">

            <li>Evaluaciones Mayo 2026</li>

            <li>Resumen Recursos Humanos</li>

            <li>Documentos Vigentes</li>

            <li>Reporte General ERP</li>

        </ul>

    </div>

</div>

<!-- Tabla -->

<div class="card border-0 table-card">

    <div class="card-header">

        Historial de reportes

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Reporte</th>

                        <th>Tipo</th>

                        <th>Fecha</th>

                        <th>Generado por</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>REP-001</td>

                        <td>Evaluaciones Mayo</td>

                        <td>Evaluaciones</td>

                        <td>31/05/2026</td>

                        <td>César Hernández</td>

                        <td>

                            <span class="badge bg-success">
                                Disponible
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>REP-002</td>

                        <td>Resumen RH</td>

                        <td>Colaboradores</td>

                        <td>30/05/2026</td>

                        <td>César Hernández</td>

                        <td>

                            <span class="badge bg-success">
                                Disponible
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
