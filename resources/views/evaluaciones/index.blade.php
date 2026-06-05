@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Encabezado -->

<div class="dashboard-header">

    <h1>
        Evaluaciones de Desempeño
    </h1>

    <p>
        Consulta y seguimiento de evaluaciones realizadas a los colaboradores.
    </p>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Evaluaciones Activas
                </span>

                <h2>
                    5
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Pendientes
                </span>

                <h2>
                    3
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card stats-card border-0">

            <div class="card-body">

                <span class="stats-label">
                    Completadas
                </span>

                <h2>
                    12
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
                    Total de evaluaciones registradas
                </strong>

                <p class="text-muted mb-0">
                    Información simulada para demostración visual.
                </p>

            </div>

            <div class="d-flex gap-2">

                <button class="btn btn-outline-secondary">

                    <i class="bi bi-clock-history"></i>

                    Historial

                </button>

                <a href="/evaluaciones/create" class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Nueva evaluación

                </a>

            </div>

        </div>

    </div>

</div>

<!-- Filtros -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="d-flex gap-2 flex-wrap">

            <button class="btn btn-dark">
                Todas
            </button>

            <button class="btn btn-outline-warning">
                Pendientes
            </button>

            <button class="btn btn-outline-success">
                Completadas
            </button>

            <button class="btn btn-outline-primary">
                En proceso
            </button>

        </div>

    </div>

</div>

<!-- Buscador y Ordenar -->

<div class="card border-0 table-card mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-8 mb-2">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar colaborador, puesto o evaluación..."
                >

            </div>

            <div class="col-md-4">

                <select class="form-select">

                    <option>
                        Ordenar por
                    </option>

                    <option>
                        Fecha
                    </option>

                    <option>
                        Colaborador
                    </option>

                    <option>
                        Estado
                    </option>

                    <option>
                        Calificación
                    </option>

                </select>

            </div>

        </div>

    </div>

</div>

<!-- Tabla principal -->

<div class="card border-0 table-card">

    <div class="card-header">

        Evaluaciones registradas

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Colaborador</th>

                        <th>Puesto</th>

                        <th>Fecha</th>

                        <th>Calificación</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>001</td>

                        <td>Juan Pérez</td>

                        <td>Desarrollador</td>

                        <td>28/05/2026</td>

                        <td>95</td>

                        <td>
                            <span class="badge bg-success">
                                Completada
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>002</td>

                        <td>María López</td>

                        <td>Recursos Humanos</td>

                        <td>29/05/2026</td>

                        <td>--</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                Pendiente
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>003</td>

                        <td>Carlos Gómez</td>

                        <td>Soporte Técnico</td>

                        <td>30/05/2026</td>

                        <td>88</td>

                        <td>
                            <span class="badge bg-primary">
                                En proceso
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>004</td>

                        <td>Laura Hernández</td>

                        <td>Administración</td>

                        <td>31/05/2026</td>

                        <td>91</td>

                        <td>
                            <span class="badge bg-success">
                                Completada
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver
                            </button>

                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>

@endsection
