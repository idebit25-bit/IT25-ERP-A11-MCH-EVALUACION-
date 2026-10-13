@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Procedimientos
        </h1>

        <p>
            Administración y consulta de procedimientos organizacionales.
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
                        Total de Procedimientos
                    </span>

                    <h2>
                        {{ $totalProcedimientos }}
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
                        {{ $procedimientosVigentes }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Proximo a Vencer
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
                        Repositorio de Procedimientos
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de procedimientos operativos.
                    </p>

                </div>

@if(auth()->user()->hasModulePermission('documentos.gestionar'))
<button
    class="btn btn-danger"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo="Procedimiento">

                    <i class="bi bi-upload"></i>

                    Subir Procedimiento

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
                        placeholder="Buscar procedimiento..."
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

            Procedimientos registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Procedimiento</th>

                            <th>Versión</th>

                            <th>Vigencia</th>

                            <th>Fecha</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

<tbody>

@forelse ($procedimientos as $procedimiento)

<tr>

    <td>{{ $procedimiento->code }}</td>

    <td>{{ $procedimiento->name }}</td>

    <td>{{ $procedimiento->version }}</td>

    <td>
        {{ $procedimiento->expiration_label }}
    </td>

    <td>
        {{ $procedimiento->created_at->format('d/m/Y') }}
    </td>

    <td>

        @if ($procedimiento->status == 'Vigente')

            <span class="badge bg-success">
                {{ $procedimiento->status }}
            </span>

        @elseif ($procedimiento->status == 'Vencido')

            <span class="badge bg-danger">
                {{ $procedimiento->status }}
            </span>

        @elseif ($procedimiento->status == 'Actualizado')

            <span class="badge bg-warning text-dark">
                {{ $procedimiento->status }}
            </span>

        @else

            <span class="badge bg-secondary">
                {{ $procedimiento->status }}
            </span>

        @endif

    </td>

    <td>

        <a
            href="{{ url('/documentos/' . $procedimiento->id) }}"
            class="btn btn-sm btn-outline-primary"
        >
            <i class="bi bi-eye"></i>
        </a>

        @if(auth()->user()->hasModulePermission('documentos.gestionar'))
<a
            href="{{ url('/documentos/' . $procedimiento->id . '/edit') }}"
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
            data-id="{{ $procedimiento->id }}"
            data-documento="{{ $procedimiento->name }}"
        >
            <i class="bi bi-trash"></i>
        </button>
@endif

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="text-center text-muted">
        No hay procedimientos registrados.
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