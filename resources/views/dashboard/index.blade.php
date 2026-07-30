@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Encabezado -->

<div class="dashboard-header">

    <div>

        <h1>

            ¡Bienvenido, {{ auth()->user()->first_name }}!

        </h1>

        <p>

            ERP Capital Humano · Gestión Integral del Personal

        </p>

        <small>

            <i class="bi bi-calendar-event"></i>

            {{ now()->translatedFormat('d \d\e F \d\e Y') }}

        </small>

    </div>

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
                                {{ $colaboradores }}
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
                                {{ $evaluaciones }}
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
                                {{ $documentos }}
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
                                {{ $reportes }}
                            </h2>

                        </div>

                        <i class="bi bi-bar-chart-fill stats-icon"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Últimas evaluaciones -->

    <div class="card border-0 table-card">

<div class="card-header d-flex justify-content-between align-items-center">

    <span>

        Últimas evaluaciones

    </span>

    <a
        href="{{ route('evaluaciones.index') }}"
        class="btn btn-sm btn-outline-primary">

        <i class="bi bi-arrow-right-circle me-1"></i>

        Ver todas

    </a>

</div>

        <div class="card-body">

            <table class="table">

                <thead>

                    <tr>

                        <th>Colaborador</th>

                        <th>Tipo de Evalución</th>

                        <th>Estado</th>

                        <th>Fecha</th>

                    </tr>

                </thead>

<tbody>

    @forelse ($ultimasEvaluaciones as $evaluacion)

        <tr>

            <td>

                {{ $evaluacion->user->full_name }}

            </td>

            <td>

                {{ $evaluacion->evaluationType->name }}

            </td>

            <td>

                @switch($evaluacion->status)

                    @case('completed')

                        <span class="badge bg-success">

                            {{ $evaluacion->status_label }}

                        </span>

                        @break

                    @case('in_progress')

                        <span class="badge bg-primary">

                            {{ $evaluacion->status_label }}

                        </span>

                        @break

                    @case('draft')

                        <span class="badge bg-warning text-dark">

                            {{ $evaluacion->status_label }}

                        </span>

                        @break

                    @case('cancelled')

                        <span class="badge bg-danger">

                            {{ $evaluacion->status_label }}

                        </span>

                        @break

                    @default

                        <span class="badge bg-secondary">

                            {{ $evaluacion->status_label }}

                        </span>

                @endswitch

            </td>

            <td>

                {{ \Carbon\Carbon::parse($evaluacion->evaluation_date)->format('d/m/Y') }}

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="4" class="text-center text-muted">

                No existen evaluaciones registradas.

            </td>

        </tr>

    @endforelse

</tbody>

            </table>

        </div>

    </div>

</div>

@endsection