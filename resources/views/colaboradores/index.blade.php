@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Encabezado -->

<div class="dashboard-header">

    <h1>
        Colaboradores
    </h1>

    <p>
        Administración y consulta de información del personal.
    </p>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Total Colaboradores
                </span>

                <h2>
                    24
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Activos
                </span>

                <h2>
                    20
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Inactivos
                </span>

                <h2>
                    2
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">
                    Nuevos Ingresos
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
                    Gestión de colaboradores
                </strong>

                <p class="text-muted mb-0">
                    Administración de personal registrado en el sistema.
                </p>

            </div>

            <button class="btn btn-primary">

                <i class="bi bi-person-plus"></i>

                Nuevo colaborador

            </button>

        </div>

    </div>

</div>

<!-- Buscador y ordenar -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-8 mb-2">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar colaborador..."
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
                        Área
                    </option>

                    <option>
                        Fecha de ingreso
                    </option>

                    <option>
                        Estado
                    </option>

                </select>

            </div>

        </div>

    </div>

</div>

<!-- Tabla -->

<div class="card border-0 table-card">

    <div class="card-header">

        Colaboradores registrados

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Foto</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Área</th>
                        <th>Fecha Ingreso</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>
                            <i class="bi bi-person-circle fs-3"></i>
                        </td>

                        <td>COL-001</td>

                        <td>Juan Pérez</td>

                        <td>Desarrollador</td>

                        <td>TI</td>

                        <td>01/02/2026</td>

                        <td>

                            <span class="badge bg-success">
                                Activo
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

                        <td>
                            <i class="bi bi-person-circle fs-3"></i>
                        </td>

                        <td>COL-002</td>

                        <td>Ana López</td>

                        <td>Recursos Humanos</td>

                        <td>RH</td>

                        <td>15/03/2026</td>

                        <td>

                            <span class="badge bg-warning text-dark">
                                Vacaciones
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

                        <td>
                            <i class="bi bi-person-circle fs-3"></i>
                        </td>

                        <td>COL-003</td>

                        <td>Carlos Gómez</td>

                        <td>Soporte Técnico</td>

                        <td>TI</td>

                        <td>20/01/2026</td>

                        <td>

                            <span class="badge bg-success">
                                Activo
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
