@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Encabezado -->

<div class="dashboard-header">

    <h1>
        Documentos
    </h1>

    <p>
        Administración de manuales, formatos y documentación interna.
    </p>

</div>

<!-- Tarjetas -->

<div class="row mb-4">

    <!-- Manuales -->

    <div class="col-md-3 mb-4">

        <a href="/documentos/manuales" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-book text-primary fs-1"></i>

                    <h5 class="mt-3">
                        Manuales
                    </h5>

                    <p class="card-text">
                        Consulta de manuales operativos.
                    </p>

                </div>

            </div>

        </a>

        <div class="card stats-card border-0 mt-2">

            <div class="card-body text-center">

                <span class="stats-label">
                    Total de Manuales
                </span>

                <h2>
                    {{ $totalManuales }}
                </h2>

            </div>

        </div>

    </div>

    <!-- Formatos -->

    <div class="col-md-3 mb-4">

        <a href="/documentos/formatos" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-file-earmark-text text-success fs-1"></i>

                    <h5 class="mt-3">
                        Formatos
                    </h5>

                    <p class="card-text">
                        Gestión de formatos institucionales.
                    </p>

                </div>

            </div>

        </a>

        <div class="card stats-card border-0 mt-2">

            <div class="card-body text-center">

                <span class="stats-label">
                    Total de Formatos
                </span>

                <h2>
                    {{ $totalFormatos }}
                </h2>

            </div>

        </div>

    </div>

    <!-- Políticas -->

    <div class="col-md-3 mb-4">

        <a href="/documentos/politicas" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-shield-check text-warning fs-1"></i>

                    <h5 class="mt-3">
                        Políticas
                    </h5>

                    <p class="card-text">
                        Documentación normativa interna.
                    </p>

                </div>

            </div>

        </a>

        <div class="card stats-card border-0 mt-2">

            <div class="card-body text-center">

                <span class="stats-label">
                    Total de Políticas
                </span>

                <h2>
                    {{ $totalPoliticas }}
                </h2>

            </div>

        </div>

    </div>

    <!-- Procedimientos -->

    <div class="col-md-3 mb-4">

        <a href="/documentos/procedimientos" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-diagram-3 text-danger fs-1"></i>

                    <h5 class="mt-3">
                        Procedimientos
                    </h5>

                    <p class="card-text">
                        Procesos y procedimientos documentados.
                    </p>

                </div>

            </div>

        </a>

        <div class="card stats-card border-0 mt-2">

            <div class="card-body text-center">

                <span class="stats-label">
                    Total de Procedimientos
                </span>

                <h2>
                    {{ $totalProcedimientos }}
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
                    Repositorio documental
                </strong>

                <p class="text-muted mb-0">
                    Administración centralizada de documentos del sistema.
                </p>

            </div>

@if(auth()->user()->hasModulePermission('documentos.gestionar'))
<button
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo=""
>

    <i class="bi bi-upload"></i>

    Subir documento

</button>
@endif

        </div>

    </div>

</div>

<!-- Filtros -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex gap-2 flex-wrap">

            <a href="/documentos"
   class="btn {{ request('tipo') == null ? 'btn-dark' : 'btn-outline-dark' }}">
    Todos
</a>

            <a href="/documentos?tipo=Manual"
   class="btn {{ request('tipo') == 'Manual' ? 'btn-primary' : 'btn-outline-primary' }}">
    Manuales
</a>

<a href="/documentos?tipo=Formato"
   class="btn {{ request('tipo') == 'Formato' ? 'btn-success' : 'btn-outline-success' }}">
    Formatos
</a>

<a href="/documentos?tipo=Política"
   class="btn {{ request('tipo') == 'Política' ? 'btn-warning' : 'btn-outline-warning' }}">
    Políticas
</a>

<a href="/documentos?tipo=Procedimiento"
   class="btn {{ request('tipo') == 'Procedimiento' ? 'btn-danger' : 'btn-outline-danger' }}">
    Procedimientos
</a>

        </div>

    </div>

</div>

<!-- Buscador -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <form method="GET" action="/documentos">

            <div class="row">

                <div class="col-md-8">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Buscar documento..."
                        value="{{ request('search') }}"
                    >

                    <div class="mt-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-search"></i>

                            Buscar

                        </button>

                        <a
                            href="/documentos"
                            class="btn btn-outline-secondary"
                        >

                            Limpiar

                        </a>

                    </div>

                </div>

                <div class="col-md-4">

                    <select
    name="order"
    class="form-select"
    onchange="this.form.submit()"
>

                        <option value="">
    Ordenar por
</option>

<option value="tipo">
    Tipo de documento
</option>

<option value="fecha">
    Fecha
</option>

<option value="vigencia">
    Vigencia
</option>

<option value="version">
    Versión
</option>

<option value="nombre">
    Nombre
</option>

<option value="estado">
    Estado
</option>

                    </select>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Tabla -->

<div class="card border-0 table-card">

    <div class="card-header">

        Documentos registrados

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Documento</th>
                        <th>Tipo</th>
                        <th>Versión</th>
                        <th>Vigencia</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

<tbody>

@forelse($documentos as $documento)

<tr>

    <td>{{ $documento->code }}</td>

    <td>{{ $documento->name }}</td>

    <td>{{ $documento->type }}</td>

    <td>{{ $documento->version }}</td>

    <td>{{ $documento->expiration_label }}</td>

    <td>{{ $documento->created_at?->format('d/m/Y') }}</td>

    <td>

        @if($documento->status == 'Vigente')

            <span class="badge bg-success">
                Vigente
            </span>

        @elseif($documento->status == 'Actualizado')

            <span class="badge bg-primary">
                Actualizado
            </span>

        @elseif($documento->status == 'Vencido')

            <span class="badge bg-danger">
                Vencido
            </span>

        @else

            <span class="badge bg-secondary">
                {{ $documento->status }}
            </span>

        @endif

    </td>

    <td>

        <a
            href="/documentos/{{ $documento->id }}"
            class="btn btn-sm btn-outline-primary"
        >
            <i class="bi bi-eye"></i>
        </a>

        @if(auth()->user()->hasModulePermission('documentos.gestionar'))
<a
            href="/documentos/{{ $documento->id }}/edit"
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
            data-documento="{{ $documento->name }}"
            data-id="{{ $documento->id }}"
        >
            <i class="bi bi-trash"></i>
        </button>
@endif

    </td>

</tr>

@empty

<tr>

    <td colspan="8" class="text-center text-muted py-4">
        No hay documentos registrados.
    </td>

</tr>

@endforelse

</tbody>

            </table>

        </div>

    </div>

</div>

</div>

<!-- Modal eliminar documento -->

 @include('documentos.partials.delete-modal')

@include('documentos.partials.upload-modal')

@endsection
