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

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card stats-card border-0">

                <div class="card-body">

                    <span class="stats-label">
                        Total de Formatos
                    </span>

                    <h2>
                        22
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
                        20
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
                        Repositorio de Formatos
                    </strong>

                    <p class="text-muted mb-0">
                        Gestión centralizada de formatos institucionales.
                    </p>

                </div>

                <button class="btn btn-success">

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

                        <tr>

                            <td>FOR-001</td>

                            <td>Formato de Evaluación de Desempeño</td>

                            <td>2.1</td>

                            <td>31/12/2026</td>

                            <td>29/05/2026</td>

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

                            <td>FOR-002</td>

                            <td>Formato Solicitud de Vacaciones</td>

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