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
                    15
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
                    22
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
                    8
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
                    11
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

            <button class="btn btn-primary">

                <i class="bi bi-upload"></i>

                Subir documento

            </button>

        </div>

    </div>

</div>

<!-- Filtros -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex gap-2 flex-wrap">

            <button class="btn btn-dark">
                Todos
            </button>

            <button class="btn btn-outline-primary">
                Manuales
            </button>

            <button class="btn btn-outline-success">
                Formatos
            </button>

            <button class="btn btn-outline-warning">
                Políticas
            </button>

            <button class="btn btn-outline-danger">
                Procedimientos
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
                    placeholder="Buscar documento..."
                >

            </div>

            <div class="col-md-4">

                <select class="form-select">

                    <option>
                        Ordenar por
                    </option>

                    <option>
                        Tipo de documento
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

                    <tr>

                        <td>DOC-001</td>
                        <td>Manual ERP</td>
                        <td>Manual</td>
                        <td>1.0</td>
                        <td>31/12/2026</td>
                        <td>28/05/2026</td>

                        <td>

                            <span class="badge bg-success">
                                Vigente
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>DOC-002</td>
                        <td>Formato Evaluación</td>
                        <td>Formato</td>
                        <td>2.1</td>
                        <td>31/12/2026</td>
                        <td>29/05/2026</td>

                        <td>

                            <span class="badge bg-primary">
                                Actualizado
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>DOC-003</td>
                        <td>Política RH</td>
                        <td>Política</td>
                        <td>1.3</td>
                        <td>31/12/2026</td>
                        <td>30/05/2026</td>

                        <td>

                            <span class="badge bg-success">
                                Vigente
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
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

@endsection
