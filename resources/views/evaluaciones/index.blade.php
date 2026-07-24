@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Encabezado -->

<div class="dashboard-header">

    <h1>
        Evaluaciones de Desempeño
    </h1>

    <p>
        Consulta y seguimiento de evaluaciones realizadas a los colaboradores.
    </p>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Evaluaciones Activas
                </span>

                <h2>
                    5
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Pendientes
                </span>

                <h2>
                    3
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Completadas
                </span>

                <h2>
                    12
                </h2>

            </div>

        </div>

    </div>

</div>

<!-- Barra superior -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>

                <strong>
                    Total de evaluaciones registradas
                </strong>

                <p class="text-muted mb-0">
                    Información simulada para demostración visual.
                </p>

            </div>

            <div class="d-flex gap-2">

                <button class="btn btn-outline-secondary">

                    <i class="bi bi-clock-history"></i>

                    Historial

                </button>

                <a href="/evaluaciones/create" class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Nueva evaluación

                </a>

            </div>

        </div>

    </div>

</div>

<!-- Filtros -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex gap-2 flex-wrap">

            <button class="btn btn-dark">
                Todas
            </button>

            <button class="btn btn-outline-warning">
                Pendientes
            </button>

            <button class="btn btn-outline-success">
                Completadas
            </button>

            <button class="btn btn-outline-primary">
                En proceso
            </button>

        </div>

    </div>

</div>

<!-- Buscador y Ordenar -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-8 mb-2">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar colaborador, puesto o evaluación..."
                >

            </div>

            <div class="col-md-4">

                <select class="form-select">

                    <option>
                        Ordenar por
                    </option>

                    <option>
                        Fecha
                    </option>

                    <option>
                        Colaborador
                    </option>

                    <option>
                        Estado
                    </option>

                    <option>
                        Calificación
                    </option>

                </select>

            </div>

        </div>

    </div>

</div>

{{-- Mensaje de éxito --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Cerrar">
        </button>

    </div>

@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">

    {{ session('error') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>
@endif

<!-- Tabla principal -->

<div class="card border-0 table-card">

    <div class="card-header">

        Evaluaciones registradas

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        
                        <th>ID</th>
                        <th>Colaborador</th>
                        <th>Tipo</th>
                        <th>Período</th>
                        <th>Plantilla</th>
                        <th>Evaluador</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Calificación</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>

@foreach($evaluations as $evaluation)

<tr>

    <td>{{ $evaluation->id }}</td>

    <td>
        {{ $evaluation->user->first_name }}
        {{ $evaluation->user->paternal_surname }}
    </td>

    <td>
        {{ $evaluation->evaluationType->name }}
    </td>

    <td>
        {{ $evaluation->period->name }}
    </td>

    <td>
        {{ $evaluation->template->name }}
    </td>

    <td>
        {{ $evaluation->evaluator->first_name }}
        {{ $evaluation->evaluator->paternal_surname }}
    </td>

    <td>
        {{ $evaluation->evaluation_date }}
    </td>

    <td>

        @switch($evaluation->status)

            @case('draft')
                <span class="badge bg-secondary">
                    Borrador
                </span>
                @break

            @case('completed')
                <span class="badge bg-success">
                    Completada
                </span>
                @break

            @case('cancelled')
                <span class="badge bg-danger">
                    Cancelada
                </span>
                @break

        @endswitch

    </td>

    <td>

        {{ number_format($evaluation->total_score, 2) }} / 5.00

    </td>

<td class="d-flex gap-1">

    <a
        href="{{ route('evaluaciones.show', $evaluation->id) }}"
        class="btn btn-sm btn-outline-primary"
        title="Ver">

        <i class="bi bi-eye"></i>

    </a>

    <a
        href="{{ route('evaluaciones.edit', $evaluation->id) }}"
        class="btn btn-sm btn-outline-warning"
        title="Editar">

        <i class="bi bi-pencil-square"></i>

    </a>

    <a
    href="{{ route('evaluaciones.apply', $evaluation->id) }}"
    class="btn btn-sm btn-outline-success"
    title="Aplicar evaluación">

    <i class="bi bi-clipboard-check"></i>

</a>

    <form
        action="{{ route('evaluaciones.destroy', $evaluation->id) }}"
        method="POST"
        onsubmit="return confirm('¿Está seguro de eliminar esta evaluación?');">

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="btn btn-sm btn-outline-danger"
            title="Eliminar">

            <i class="bi bi-trash"></i>

        </button>

    </form>

</td>

</tr>

@endforeach

                   

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
