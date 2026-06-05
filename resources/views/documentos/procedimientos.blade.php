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

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Total de Procedimientos
                    </span>

                    <h2>
                        11
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
                        10
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        En revisión
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
                        Repositorio de Procedimientos
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de procedimientos operativos.
                    </p>

                </div>

                <button class="btn btn-danger">

                    <i class="bi bi-upload"></i>

                    Subir Procedimiento

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

                        <tr>

                            <td>PRO-001</td>

                            <td>Procedimiento de Reclutamiento</td>

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

                            <td>PRO-002</td>

                            <td>Procedimiento de Evaluación de Desempeño</td>

                            <td>1.4</td>

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