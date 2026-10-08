@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Políticas
        </h1>

        <p>
            Administración y consulta de políticas institucionales.
        </p>

    </div>

    <a
    href="/documentos"
    class="btn btn-outline-secondary mb-3"
>

    <i class="bi bi-arrow-left"></i>

    Regresar

</a>

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Total de Políticas
                    </span>

                    <h2>
                        {{ $totalPoliticas }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Vigentes
                    </span>

                    <h2>
                        {{ $politicasVigentes }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Próximas a revisión
                    </span>

                    <h2>
                        {{ $proximosVencer }}
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
                        Repositorio de Políticas
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de políticas organizacionales.
                    </p>

                </div>

@if(auth()->user()->hasModulePermission('documentos.gestionar'))
<button
    class="btn btn-warning"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo="Política">

                    <i class="bi bi-upload"></i>

                    Subir Política

                </button>
@endif

            </div>

        </div>

    </div>

    <!-- Buscador -->

    <div class="card border-0 table-card mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-8 mb-2">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar política..."
                    >

                </div>

                <div class="col-md-4">

                    <select class="form-select">

                        <option>
                            Ordenar por
                        </option>

                        <option>
                            Nombre
                        </option>

                        <option>
                            Fecha
                        </option>

                        <option>
                            Vigencia
                        </option>

                        <option>
                            Versión
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <!-- Tabla -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Políticas registradas

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Política</th>

                            <th>Versión</th>

                            <th>Vigencia</th>

                            <th>Fecha</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

<tbody>

@forelse ($politicas as $politica)

<tr>

    <td>{{ $politica->code }}</td>

    <td>{{ $politica->name }}</td>

    <td>{{ $politica->version }}</td>

    <td>
        {{ \Carbon\Carbon::parse($politica->expiration_date)->format('d/m/Y') }}
    </td>

    <td>
        {{ $politica->created_at->format('d/m/Y') }}
    </td>

    <td>

        @if ($politica->status == 'Vigente')

            <span class="badge bg-success">
                {{ $politica->status }}
            </span>

        @elseif ($politica->status == 'Vencido')

            <span class="badge bg-danger">
                {{ $politica->status }}
            </span>

        @elseif ($politica->status == 'Actualizado')

            <span class="badge bg-warning text-dark">
                {{ $politica->status }}
            </span>

        @else

            <span class="badge bg-secondary">
                {{ $politica->status }}
            </span>

        @endif

    </td>

    <td>

        <a
            href="{{ url('/documentos/' . $politica->id) }}"
            class="btn btn-sm btn-outline-primary"
        >
            <i class="bi bi-eye"></i>
        </a>

        @if(auth()->user()->hasModulePermission('documentos.gestionar'))
<a
            href="{{ url('/documentos/' . $politica->id . '/edit') }}"
            class="btn btn-sm btn-outline-warning"
        >
            <i class="bi bi-pencil-square"></i>
        </a>
@endif

        @if(auth()->user()->hasModulePermission('documentos.gestionar'))
<button
            class="btn btn-sm btn-outline-danger"
            data-bs-toggle="modal"
            data-bs-target="#deleteModal"
            data-id="{{ $politica->id }}"
            data-documento="{{ $politica->name }}"
        >
            <i class="bi bi-trash"></i>
        </button>
@endif

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="text-center text-muted">
        No hay políticas registradas.
    </td>

</tr>

@endforelse

</tbody>
                </table>

            </div>

        </div>

    </div>

</div>

<!-- Modal eliminar -->

@include('documentos.partials.delete-modal')

@include('documentos.partials.upload-modal')


@endsection