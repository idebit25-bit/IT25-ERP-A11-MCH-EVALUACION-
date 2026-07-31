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
                    Gestión de evaluaciones
                </strong>

                <p class="text-muted mb-0">
                    Consulta, administra y aplica evaluaciones de desempeño.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="/evaluaciones/create" class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Nueva evaluación

                </a>

            </div>

        </div>

    </div>

</div>

<!-- Filtros -->

<form
    method="GET"
    action="{{ url('/evaluaciones') }}">

    <div class="card border-0 table-card mb-4">

        <div class="card-body">

            <div class="row g-2">

                <div class="col-md-5">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Buscar colaborador, tipo o evaluador..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-3">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            Todos los estados
                        </option>

                        <option
                            value="draft"
                            {{ request('status') == 'draft' ? 'selected' : '' }}>
                            Borrador
                        </option>

                        <option
                            value="in_progress"
                            {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                            En proceso
                        </option>

                        <option
                            value="completed"
                            {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completada
                        </option>

                        <option
                            value="cancelled"
                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelada
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        name="order"
                        class="form-select">

                        <option value="">
                            Ordenar por
                        </option>

                        <option
                            value="evaluation_date"
                            {{ request('order') == 'evaluation_date' ? 'selected' : '' }}>
                            Fecha
                        </option>

                        <option
                            value="status"
                            {{ request('order') == 'status' ? 'selected' : '' }}>
                            Estado
                        </option>

                        <option
                            value="total_score"
                            {{ request('order') == 'total_score' ? 'selected' : '' }}>
                            Calificación
                        </option>

                    </select>

                </div>

                <div class="col-md-2 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        Buscar

                    </button>

                    <a
                        href="{{ url('/evaluaciones') }}"
                        class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-clockwise"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>

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
        {{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d/m/Y') }}
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

            @case('in_progress')
                <span class="badge bg-primary">
                    En proceso
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
