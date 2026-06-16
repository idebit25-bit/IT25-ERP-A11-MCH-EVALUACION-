@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Manuales
        </h1>

        <p>
            Administración y consulta de manuales operativos del sistema.
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
                        Total de Manuales
                    </span>

                    <h2>
                        15
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
                        13
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Próximos a vencer
                    </span>

                    <h2>
                        2
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
                        Repositorio de Manuales
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de manuales operativos.
                    </p>

                </div>

                <button
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#uploadModal"
    data-tipo="Manual">

                    <i class="bi bi-upload"></i>

                    Subir Manual

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
                        placeholder="Buscar manual..."
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

            Manuales registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Manual</th>

                            <th>Versión</th>

                            <th>Vigencia</th>

                            <th>Fecha</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>MAN-001</td>

                            <td>Manual ERP Capital Humano</td>

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
        href="/documentos/MAN-001"
        class="btn btn-sm btn-outline-primary"
    >
        <i class="bi bi-eye"></i>
    </a>

    <a
        href="/documentos/MAN-001/edit"
        class="btn btn-sm btn-outline-warning"
    >
        <i class="bi bi-pencil-square"></i>
    </a>

    <button
        class="btn btn-sm btn-outline-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-documento="Manual ERP Capital Humano"
    >
        <i class="bi bi-trash"></i>
    </button>

</td>
                        </tr>

                        <tr>

                            <td>MAN-002</td>

                            <td>Manual de Evaluaciones</td>

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
        href="/documentos/MAN-002"
        class="btn btn-sm btn-outline-primary"
    >
        <i class="bi bi-eye"></i>
    </a>

    <a
        href="/documentos/MAN-002/edit"
        class="btn btn-sm btn-outline-warning"
    >
        <i class="bi bi-pencil-square"></i>
    </a>

    <button
        class="btn btn-sm btn-outline-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-documento="Manual de Evaluaciones"
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