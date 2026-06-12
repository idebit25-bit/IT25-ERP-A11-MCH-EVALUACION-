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
                    {{ $totalUsers }}
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
                    {{ $activeUsers }}
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
                    {{ $inactiveUsers }}
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
                    {{ $newUsers }}
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

        <form method="GET" action="/colaboradores">

            <div class="row">

                <div class="col-md-8 mb-2">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Buscar colaborador..."
                        value="{{ request('search') }}"
                    >

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

                        <option
                            value="nombre"
                            {{ request('order') == 'nombre' ? 'selected' : '' }}
                        >
                            Nombre
                        </option>

                        <option
                            value="fecha"
                            {{ request('order') == 'fecha' ? 'selected' : '' }}
                        >
                            Fecha de ingreso
                        </option>

                        <option
                            value="estado"
                            {{ request('order') == 'estado' ? 'selected' : '' }}
                        >
                            Estado
                        </option>

                        <option
    value="id"
    {{ request('order') == 'id' ? 'selected' : '' }}
>
    ID empleado
</option>

<option
    value="departamento"
    {{ request('order') == 'departamento' ? 'selected' : '' }}
>
    Departamento
</option>

<option
    value="puesto"
    {{ request('order') == 'puesto' ? 'selected' : '' }}
>
    Puesto
</option>
                         
                        

                    </select>

                </div>

            </div>

            <div class="mt-2">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-search"></i>

                    Buscar

                </button>

                <a
                    href="/colaboradores"
                    class="btn btn-outline-secondary"
                >

                    Limpiar

                </a>

            </div>

        </form>

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
                        <th>Departamento</th>
                        <th>Fecha Ingreso</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

@foreach($users as $user)

<tr>

    <td>
        <i class="bi bi-person-circle fs-3"></i>
    </td>

    <td>
        {{ $user->employee_code }}
    </td>

    <td>
        {{ $user->first_name }}
        {{ $user->paternal_surname }}
    </td>

    <td>
        {{ $user->position->name ?? 'Sin puesto' }}
    </td>

    <td>
        {{ $user->department->name ?? 'Sin departamento' }}
    </td>

    <td>
        {{ $user->entry_date }}
    </td>

    <td>

        @if($user->status == 'active')

            <span class="badge bg-success">
                Activo
            </span>

        @elseif($user->status == 'inactive')

            <span class="badge bg-danger">
                Inactivo
            </span>

        @else

            <span class="badge bg-secondary">
                {{ $user->status }}
            </span>

        @endif

    </td>

    <td>

        <a
            href="/colaboradores/{{ $user->id }}"
            class="btn btn-sm btn-outline-primary">
            <i class="bi bi-eye"></i>
        </a>

        <button class="btn btn-sm btn-outline-warning">
            <i class="bi bi-pencil-square"></i>
        </button>

        <button class="btn btn-sm btn-outline-danger">
            <i class="bi bi-trash"></i>
        </button>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-4">

    {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}

</div>

</div>

</div>

</div>

@endsection
