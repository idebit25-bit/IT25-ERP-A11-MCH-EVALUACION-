@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Bienvenido César Hernández
        </h1>

        <p>
            Módulo Capital Humano | Evaluación de Desempeño
        </p>

        <small>
            Última actualización: {{ now()->format('d/m/Y') }}
        </small>

    </div>

    <!-- Indicadores -->

    <div class="row mb-4">

        <!-- Colaboradores -->

        <div class="col-md-3">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="stats-title">
                                Colaboradores
                            </p>

                            <h2 class="stats-number">
                                {{24}}
                            </h2>

                        </div>

                        <i class="bi bi-people-fill stats-icon"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Evaluaciones -->

        <div class="col-md-3">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="stats-title">
                                Evaluaciones
                            </p>

                            <h2 class="stats-number">
                                12
                            </h2>

                        </div>

                        <i class="bi bi-clipboard-check-fill stats-icon"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Documentos -->

        <div class="col-md-3">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="stats-title">
                                Documentos
                            </p>

                            <h2 class="stats-number">
                                35
                            </h2>

                        </div>

                        <i class="bi bi-folder-fill stats-icon"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Reportes -->

        <div class="col-md-3">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="stats-title">
                                Reportes
                            </p>

                            <h2 class="stats-number">
                                8
                            </h2>

                        </div>

                        <i class="bi bi-bar-chart-fill stats-icon"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Actividad reciente -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Actividad reciente

        </div>

        <div class="card-body">

            <table class="table">

                <thead>

                    <tr>

                        <th>Colaborador</th>

                        <th>Área</th>

                        <th>Evaluación</th>

                        <th>Estado</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>Juan Pérez</td>

                        <td>Desarrollo</td>

                        <td>Desempeño Trimestral</td>

                        <td>
                            <span class="badge bg-success">
                                Completada
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Ana López</td>

                        <td>Recursos Humanos</td>

                        <td>Evaluación KPIs</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                Pendiente
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Carlos Gómez</td>

                        <td>Soporte</td>

                        <td>Evaluación Mensual</td>

                        <td>
                            <span class="badge bg-primary">
                                En proceso
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection