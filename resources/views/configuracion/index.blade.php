@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Configuración
        </h1>

        <p>
            Administración de parámetros generales del sistema ERP.
        </p>

    </div>

    <!-- Tarjetas -->

<!-- Administración -->

<div class="mb-4">

    <h4 class="mb-3">

        <i class="bi bi-gear-fill text-primary"></i>

        Administración

    </h4>

    <div class="row">

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('configuracion.usuarios') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-people text-primary fs-1"></i>

                        <h5 class="mt-3">

                            Usuarios

                        </h5>

                        <p class="card-text">

                            Administración de usuarios del sistema.

                        </p>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('configuracion.roles') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-shield-lock text-success fs-1"></i>

                        <h5 class="mt-3">

                            Roles y permisos

                        </h5>

                        <p class="card-text">

                            Administración de accesos del sistema.

                        </p>

                    </div>

                </div>

            </a>

        </div>

    </div>

</div>

<!-- Configuración de Evaluaciones -->

<div class="mb-4">

    <h4 class="mb-3">

        <i class="bi bi-clipboard2-check-fill text-success"></i>

        Configuración de Evaluaciones

    </h4>

    <div class="row">

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-types.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-ui-checks-grid text-primary fs-1"></i>

                        <h5 class="mt-3">

                            Tipos de evaluación

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-periods.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-calendar-event text-danger fs-1"></i>

                        <h5 class="mt-3">

                            Períodos

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-categories.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-folder2-open text-warning fs-1"></i>

                        <h5 class="mt-3">

                            Categorías

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-competencies.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-bullseye text-success fs-1"></i>

                        <h5 class="mt-3">

                            Competencias

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-scales.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-sliders text-info fs-1"></i>

                        <h5 class="mt-3">

                            Escalas

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-questions.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-patch-question text-primary fs-1"></i>

                        <h5 class="mt-3">

                            Banco de preguntas

                        </h5>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-3">

            <a
                href="{{ route('evaluation-templates.index') }}"
                class="text-decoration-none">

                <div class="card border-0 dashboard-card">

                    <div class="card-body text-center">

                        <i class="bi bi-file-earmark-text text-secondary fs-1"></i>

                        <h5 class="mt-3">

                            Plantillas

                        </h5>

                    </div>

                </div>

            </a>

        </div>

    </div>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Usuarios registrados

                </span>

                <h2>

                    {{ $usuarios }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Roles activos

                </span>

                <h2>

                    {{ $roles }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Permisos configurados

                </span>

                <h2>

                    {{ $permisos }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Respaldos realizados

                </span>

                <h2>

                    {{ $respaldos }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- Configuración General -->

<div class="card border-0 table-card mb-4">

    <div class="card-header">

        Información General del Sistema

    </div>

    <div class="card-body">

        <div class="row">

            <!-- Sistema -->

            <div class="col-md-6 mb-3">

                <strong>

                    Nombre del sistema:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['sistema'] }}

                </p>

            </div>

            <!-- Versión -->

            <div class="col-md-6 mb-3">

                <strong>

                    Versión:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['version'] }}

                </p>

            </div>

            <!-- Última actualización -->

            <div class="col-md-6">

                <strong>

                    Última actualización:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['ultimaActualizacion'] }}

                </p>

            </div>

            <!-- Administrador -->

            <div class="col-md-6">

                <strong>

                    Administrador:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['administrador'] }}

                </p>

            </div>

        </div>

    </div>

</div>


 <!-- Bitácora del sistema -->

<div class="card border-0 table-card">

    <div class="card-header">

        Bitácora del Sistema

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Fecha</th>

                        <th>Usuario</th>

                        <th>Acción</th>

                        <th>Módulo</th>

                    </tr>

                </thead>

                <tbody>

@forelse($activityLogs as $log)

<tr>

    <td>

        {{ $log->created_at->format('d/m/Y H:i') }}

    </td>

    <td>

        {{ trim(
            ($log->user?->first_name ?? '') . ' ' .
            ($log->user?->paternal_surname ?? '')
        ) }}

    </td>

    <td>

        {{ $log->description }}

    </td>

    <td>

        {{ $log->module }}

    </td>

</tr>

@empty

<tr>

    <td colspan="4" class="text-center">

        No existen registros.

    </td>

</tr>

@endforelse

                </tbody>

            </table>

        </div>
<div class="text-end mt-3">

    <a
        href="{{ route('activity-logs.index') }}"
        class="btn btn-outline-dark btn-sm">

        <i class="bi bi-clock-history"></i>

        Ver bitácora completa

    </a>

</div>

    </div>

</div>

</div>

@endsection