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
                        8
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
                        7
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
                        1
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

<button
    class="btn btn-warning"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo="Política">

                    <i class="bi bi-upload"></i>

                    Subir Política

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

                        <tr>

                            <td>POL-001</td>

                            <td>Política de Asistencia</td>

                            <td>1.0</td>

                            <td>31/12/2026</td>

                            <td>28/05/2026</td>

                            <td>

                                <span class="badge bg-success">
                                    Vigente
                                </span>

                            </td>

                            <td>

    <a
        href="/documentos/POL-001"
        class="btn btn-sm btn-outline-primary"
    >
        <i class="bi bi-eye"></i>
    </a>

    <a
        href="/documentos/POL-001/edit"
        class="btn btn-sm btn-outline-warning"
    >
        <i class="bi bi-pencil-square"></i>
    </a>

    <button
        class="btn btn-sm btn-outline-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-documento="Política de Asistencia"
    >
        <i class="bi bi-trash"></i>
    </button>

</td>

                        </tr>

                        <tr>

                            <td>POL-002</td>

                            <td>Política de Vacaciones</td>

                            <td>1.2</td>

                            <td>31/12/2026</td>

                            <td>30/05/2026</td>

                            <td>

                                <span class="badge bg-success">
                                    Vigente
                                </span>

                            </td>

                           <td>

    <a
        href="/documentos/POL-002"
        class="btn btn-sm btn-outline-primary"
    >
        <i class="bi bi-eye"></i>
    </a>

    <a
        href="/documentos/POL-002/edit"
        class="btn btn-sm btn-outline-warning"
    >
        <i class="bi bi-pencil-square"></i>
    </a>

    <button
        class="btn btn-sm btn-outline-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-documento="Política de Vacaciones"
    >
        <i class="bi bi-trash"></i>
    </button>

</td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- Modal eliminar -->

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Confirmar eliminación
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body">

                ¿Desea eliminar el documento:

                <strong id="documentoNombre"></strong>?

                <br><br>

                Esta acción no se puede deshacer.

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancelar
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                >
                    Eliminar
                </button>

            </div>

        </div>

    </div>

</div>

@include('documentos.partials.upload-modal')

@endsection