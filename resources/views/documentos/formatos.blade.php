@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Formatos
        </h1>

        <p>
            Administración y consulta de formatos institucionales.
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
                        Total de Formatos
                    </span>

                    <h2>
                        {{ $totalFormatos }}
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
                        {{ $formatosVigentes }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Próximos a actualizar
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
                        Repositorio de Formatos
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de formatos institucionales.
                    </p>

                </div>

<button
    class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo="Formato"
>

                    <i class="bi bi-upload"></i>

                    Subir Formato

                </button>

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
                        placeholder="Buscar formato..."
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

            Formatos registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Formato</th>

                            <th>Versión</th>

                            <th>Vigencia</th>

                            <th>Fecha</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

<tbody>

@forelse ($formatos as $formato)

<tr>

    <td>{{ $formato->code }}</td>

    <td>{{ $formato->name }}</td>

    <td>{{ $formato->version }}</td>

    <td>
        {{ \Carbon\Carbon::parse($formato->expiration_date)->format('d/m/Y') }}
    </td>

    <td>
        {{ $formato->created_at->format('d/m/Y') }}
    </td>

    <td>

        @if ($formato->status == 'Vigente')

            <span class="badge bg-success">
                {{ $formato->status }}
            </span>

        @elseif ($formato->status == 'Vencido')

            <span class="badge bg-danger">
                {{ $formato->status }}
            </span>

        @elseif ($formato->status == 'Actualizado')

            <span class="badge bg-warning text-dark">
                {{ $formato->status }}
            </span>

        @else

            <span class="badge bg-secondary">
                {{ $formato->status }}
            </span>

        @endif

    </td>

    <td>

        <a
            href="{{ url('/documentos/' . $formato->id) }}"
            class="btn btn-sm btn-outline-primary"
        >
            <i class="bi bi-eye"></i>
        </a>

        <a
            href="{{ url('/documentos/' . $formato->id . '/edit') }}"
            class="btn btn-sm btn-outline-warning"
        >
            <i class="bi bi-pencil-square"></i>
        </a>

        <button
            class="btn btn-sm btn-outline-danger"
            data-bs-toggle="modal"
            data-bs-target="#deleteModal"
            data-id="{{ $formato->id }}"
            data-documento="{{ $formato->name }}"
        >
            <i class="bi bi-trash"></i>
        </button>

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="text-center text-muted">
        No hay formatos registrados.
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