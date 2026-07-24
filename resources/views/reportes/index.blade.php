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

            <div
        class="card border-0 dashboard-card reporte-card"
        data-tipo="evaluaciones"
        style="cursor:pointer;">
            
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

            
            <div
        class="card border-0 dashboard-card reporte-card"
        data-tipo="colaboradores"
        style="cursor:pointer;">
            
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

            
            <div
        class="card border-0 dashboard-card reporte-card"
        data-tipo="documentos"
        style="cursor:pointer;">
            
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

            
            <div
        class="card border-0 dashboard-card reporte-card"
        data-tipo="general"
        style="cursor:pointer;">
            
                <div class="card-body text-center">

                    <i class="bi bi-bar-chart-line text-danger fs-1"></i>

                    <h5 class="mt-3">
                        General RH
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
                        {{ $evaluacionesRealizadas }}
                    </h2>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Colaboradores activos
                    </span>

                    
                    <h2>
                        {{ $colaboradores }}
                    </h2>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Documentos vigentes
                    </span>

                    <h2>
                        {{ $documentosActivos }}
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
                    {{ number_format($promedioGeneral, 2) }} / 5.00
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

                <button 
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalGenerarReporte">


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

                    Desempeño por Departamento

                </div>

                <div class="card-body">

                    @foreach($desempeñoDepartamentos as $departamento)

                    @php
                    $color = '#dc3545'; // Rojo
                    if ($departamento['porcentaje'] >= 90) {
                        $color = '#198754'; // Verde
                    } elseif ($departamento['porcentaje'] >= 80) {
                        $color = '#0d6efd'; // Azul
                    } elseif ($departamento['porcentaje'] >= 70) {
                        $color = '#ffc107'; // Amarillo
                    }
                    @endphp
                    <div class="report-bar">
                        <span>
                            {{ $departamento['nombre'] }}
                            ({{ $departamento['porcentaje'] }}%)
                        </span>
                        <div
                        class="bar-fill"
                        style="
                        width: {{ $departamento['porcentaje'] }}%;
                        background-color: {{ $color }};
                        ">
                        </div>
                    </div>
                    @endforeach

                    

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card border-0 table-card">

                <div class="card-header">

                    Evaluaciones Realizadas Por Mes

                </div>

                <div class="card-body">

                @foreach($resumenMensual as $registro)

    <div class="mb-3">

        <div class="d-flex justify-content-between align-items-center mb-1">

            <span>

                {{ $registro['mes'] }}

            </span>

            <strong>

                {{ $registro['evaluaciones'] }}

            </strong>

        </div>

        <div class="progress">

            <div
                class="progress-bar resumen-mesual-bar"
                role="progressbar"
                style="width: {{ $registro['evaluaciones'] * 1.8 }}%;">

            </div>

        </div>

    </div>

    @endforeach

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

    @foreach($evaluaciones->take(5) as $evaluacion)

    <div class="py-3 border-bottom">

        <div class="d-flex align-items-center mb-1">

            <i class="bi bi-file-earmark-text me-2"></i>

    <strong>
        {{ $evaluacion->evaluationType?->name }}
        -
        {{ $evaluacion->user?->name }}
    </strong>

        </div>

        <small class="text-muted">

            {{ $evaluacion->period?->name ?? 'Sin período' }} • Reciente

        </small>

    </div>

    @endforeach

        </div>

    </div>

    <!-- Reporte General -->

    <div class="card border-0 table-card mb-4">

        <div class="card-body">

            <h5 class="mb-1">

                Reporte General

            </h5>

            <p class="text-muted mb-0">

                Consulta el historial de evaluaciones utilizando los filtros disponibles.

            </p>

        </div>

    </div>

    <!-- Filtros del reporte -->

    <div class="card border-0 table-card mb-4">

        <div class="card-header">

            Filtros del Reporte

        </div>
        
        <div class="card-body">

            <form method="GET" action="{{ route('reportes.index') }}">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Colaborador
                        </label>

    <select class="form-select" name="user_id">

    <option value="">Todos</option>

    @foreach($usuarios as $usuario)

    <option
        value="{{ $usuario->id }}"
        {{ request('user_id') == $usuario->id ? 'selected' : '' }}>
        {{ $usuario->full_name }}
    </option>

    @endforeach

    </select>


                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Departamento
                        </label>

    <select class="form-select" name="department_id">

        <option value="">Todos</option>

        @foreach($departamentos as $departamento)

    <option
        value="{{ $departamento->id }}"
        {{ request('department_id') == $departamento->id ? 'selected' : '' }}>
        {{ $departamento->name }}
    </option>

        @endforeach

    </select>

                    </div>

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Tipo
                        </label>

    <select class="form-select" name="evaluation_type_id">

        <option value="">Todos</option>

        @foreach($tiposEvaluacion as $tipo)

    <option
        value="{{ $tipo->id }}"
        {{ request('evaluation_type_id') == $tipo->id ? 'selected' : '' }}>
        {{ $tipo->name }}
    </option>

        @endforeach

    </select>

                    </div>

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Período
                        </label>

    <select class="form-select" name="period_id">

        <option value="">Todos</option>

        @foreach($periodos as $periodo)

    <option
        value="{{ $periodo->id }}"
        {{ request('period_id') == $periodo->id ? 'selected' : '' }}>
        {{ $periodo->name }}
    </option>

        @endforeach

    </select>

                    </div>

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select class="form-select" name="status">

    <option value="">Todos</option>

    <option
        value="pending"
        {{ request('status') == 'pending' ? 'selected' : '' }}>
        Pendiente
    </option>

    <option
        value="completed"
        {{ request('status') == 'completed' ? 'selected' : '' }}>
        Completada
    </option>

                        </select>

                    </div>

                </div>

    <div class="text-end">

        <a href="{{ route('reportes.index') }}"
        class="btn btn-outline-secondary">

            <i class="bi bi-x-circle"></i>

            Limpiar filtros

        </a>

        <button type="submit" class="btn btn-primary">

            <i class="bi bi-funnel"></i>

            Aplicar filtros

        </button>

    </div>

            </form>

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

        @foreach($evaluaciones as $evaluacion)

        <tr>

            <td>

                {{ $evaluacion->id }}

            </td>

            <td>

                {{ $evaluacion->user?->name }}

            </td>

            <td>

                {{ $evaluacion->evaluationType?->name }}

            </td>

            <td>

                {{ $evaluacion->evaluation_date }}

            </td>

            <td>

                {{ $evaluacion->evaluator?->name ?? 'Sin asignar' }}

            </td>

            <td>

                <span class="badge bg-success">

                    {{ ucfirst($evaluacion->status) }}

                </span>

            </td>

            <td>

    <button
        class="btn btn-sm btn-outline-primary btnVerReporte"

        data-id="{{ $evaluacion->id }}"
        data-nombre="{{ $evaluacion->user?->name }}"
        data-tipo="{{ $evaluacion->evaluationType?->name }}"
        data-fecha="{{ $evaluacion->evaluation_date }}"
        data-usuario="{{ $evaluacion->evaluator?->name ?? 'Sin asignar' }}"
        data-estado="{{ ucfirst($evaluacion->status) }}">

        <i class="bi bi-eye"></i>

    </button>


    <button
        class="btn btn-sm btn-outline-danger btnEliminarReporte"

        data-id="{{ $evaluacion->id }}"
        data-nombre="{{ $evaluacion->user?->name }}">

        <i class="bi bi-trash"></i>

    </button>

            </td>

        </tr>

        @endforeach

    </tbody>
                </table>

            </div>

        </div>

    </div>

    </div>

    <!-- Modal Generar Reporte -->

    <div
        class="modal fade"
        id="modalGenerarReporte"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Generar Reporte

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <form id="formGenerarReporte">

                        <!-- Tipo -->

                        <div class="mb-3">

                            <label class="form-label">

                                Tipo de reporte

                            </label>

                            <select
                                class="form-select"
                                id="tipoReporte">

                                <option value="evaluaciones">
                                    Evaluaciones
                                </option>

                                <option value="colaboradores">
                                    Colaboradores
                                </option>

                                <option value="documentos">
                                    Documentos
                                </option>

                                <option value="general">
                                    General RH
                                </option>

                            </select>

                        </div>

                        <!-- Periodo -->

                        <div class="mb-3">

                            <label class="form-label">

                                Periodo

                            </label>

                            <input
                                type="month"
                                class="form-control"
                                id="periodo">

                        </div>

                        <!-- Formato -->

                        <div class="mb-3">

                            <label class="form-label">

                                Formato

                            </label>

                            <select
                                class="form-select"
                                id="formatoReporte">

                                <option value="pdf">
                                    PDF
                                </option>

                                <option value="excel">
                                    Excel
                                </option>

                            </select>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="btnGenerarReporte">

                        Generar

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Tarjetas Superiores -->

    <div
        class="modal fade"
        id="modalDetalleReporte"
        tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="tituloReporte">

                        Reporte

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div
                    class="modal-body"
                    id="contenidoReporte">

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Ver Reporte -->

    <div
        class="modal fade"
        id="modalVerReporte"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Detalle del Reporte

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div
                    class="modal-body"
                    id="contenidoVerReporte">

                </div>

                <div class="modal-footer">

        <button
            type="button"
            class="btn btn-danger"
            id="btnPdfReporte">

            <i class="bi bi-file-earmark-pdf"></i>

            PDF

        </button>

        <button
            type="button"
            class="btn btn-success"
            id="btnExcelReporte">

            <i class="bi bi-file-earmark-excel"></i>

            Excel

        </button>

        <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">

            Cerrar

        </button>

    </div>

            </div>

        </div>

    </div>

    <!-- Modal Eliminar Reporte -->
    <div
        class="modal fade"
        id="modalEliminarReporte"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Confirmar eliminación

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p id="mensajeEliminarReporte">

                    </p>

                    <p class="text-danger mb-0">

                        Esta acción no se puede deshacer.

                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="btnConfirmarEliminar">

                        Eliminar

                    </button>

                </div>

            </div>

        </div>

    </div>
    @endsection
