@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>

            Roles y Permisos

        </h1>

        <p>

            Administración de roles y privilegios del sistema.

        </p>

    </div>

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Roles

                    </span>

                    <h2>

                        {{ count($roles) }}

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

                        2

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

                        1

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Usuarios Asignados

                    </span>

                    <h2>

                        10

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Barra de acciones -->

    <div class="card border-0 table-card mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <!-- Nuevo Rol -->

                <div class="col-md-3">

                    <button
                        id="btnNuevoRol"
                        class="btn btn-primary">

                        <i class="bi bi-plus-circle"></i>

                        Nuevo Rol

                    </button>

                </div>

                <!-- Buscar -->

                <div class="col-md-5">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar rol...">

                </div>

                <!-- Estado -->

                <div class="col-md-4">

                    <select class="form-select">

                        <option>

                            Todos

                        </option>

                        <option>

                            Activos

                        </option>

                        <option>

                            Inactivos

                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <!-- Tabla -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Roles registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nombre</th>

                            <th>Descripción</th>

                            <th>Usuarios</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <!-- Lista de roles -->

                        @foreach ($roles as $rol)

                        <tr>

                            <!-- Nombre -->

                            <td>

                                {{ $rol['nombre'] }}

                            </td>

                            <!-- Descripción -->

                            <td>

                                {{ $rol['descripcion'] }}

                            </td>

                            <!-- Usuarios -->

                            <td>

                                {{ $rol['usuarios'] }}

                            </td>

                            <!-- Estado -->

                            <td>

                                @if ($rol['estado'] == 'Activo')

                                    <span class="badge bg-success">

                                        {{ $rol['estado'] }}

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $rol['estado'] }}

                                    </span>

                                @endif

                            </td>

                            <!-- Acciones -->

                            <td>

                                <!-- Ver -->

                                <button
                                    class="btn btn-sm btn-outline-primary btnVerRol"

                                    data-id="{{ $rol['id'] }}"
                                    data-nombre="{{ $rol['nombre'] }}"
                                    data-descripcion="{{ $rol['descripcion'] }}"
                                    data-usuarios="{{ $rol['usuarios'] }}"
                                    data-estado="{{ $rol['estado'] }}">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <!-- Editar -->

                                <button
                                    class="btn btn-sm btn-outline-warning btnEditarRol"

                                    data-id="{{ $rol['id'] }}"
                                    data-nombre="{{ $rol['nombre'] }}"
                                    data-descripcion="{{ $rol['descripcion'] }}"
                                    data-estado="{{ $rol['estado'] }}">

                                    <i class="bi bi-pencil-square"></i>

                                </button>

                                <!-- Activar / Desactivar -->

                                <button
                                    class="btn btn-sm btn-outline-secondary btnEstadoRol"

                                    data-id="{{ $rol['id'] }}"
                                    data-nombre="{{ $rol['nombre'] }}"
                                    data-estado="{{ $rol['estado'] }}">

                                    @if ($rol['estado'] == 'Activo')

                                        <i class="bi bi-lock"></i>

                                    @else

                                        <i class="bi bi-unlock"></i>

                                    @endif

                                </button>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- Modal Nuevo Rol -->

<div
    class="modal fade"
    id="modalNuevoRol"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Nuevo Rol

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- Formulario -->

            <div class="modal-body">

                <div class="row">

                    <!-- Nombre -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nombre del rol

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingrese el nombre del rol">

                    </div>

                    <!-- Estado -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Estado

                        </label>

                        <select class="form-select">

                            <option>

                                Activo

                            </option>

                            <option>

                                Inactivo

                            </option>

                        </select>

                    </div>

                    <!-- Descripción -->

                    <div class="col-12">

                        <label class="form-label">

                            Descripción

                        </label>

                        <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Descripción del rol"></textarea>

                    </div>

                </div>

            </div>

            <!-- Botones -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="btnGuardarRol">

                    Guardar Rol

                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal Ver Rol -->

<div
    class="modal fade"
    id="modalVerRol"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Información del Rol

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- Información -->

            <div
                class="modal-body"
                id="contenidoVerRol">

            </div>

            <!-- Botones -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cerrar

                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal Editar Rol -->

<div
    class="modal fade"
    id="modalEditarRol"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Editar Rol

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- Formulario -->

            <div class="modal-body">

                <div class="row">

                    <!-- Nombre -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nombre del rol

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editarNombreRol">

                    </div>

                    <!-- Estado -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Estado

                        </label>

                        <select
                            class="form-select"
                            id="editarEstadoRol">

                            <option>

                                Activo

                            </option>

                            <option>

                                Inactivo

                            </option>

                        </select>

                    </div>

                    <!-- Descripción -->

                    <div class="col-12">

                        <label class="form-label">

                            Descripción

                        </label>

                        <textarea
                            class="form-control"
                            rows="3"
                            id="editarDescripcionRol">

                        </textarea>

                    </div>

                </div>

            </div>

            <!-- Botones -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button
                    type="button"
                    class="btn btn-warning"
                    id="btnActualizarRol">

                    Actualizar Rol

                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal Activar / Desactivar Rol -->

<div
    class="modal fade"
    id="modalEstadoRol"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Cambiar Estado

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- Información -->

            <div class="modal-body">

                <p id="mensajeEstadoRol">

                    ¿Deseas cambiar el estado del rol?

                </p>

                <p class="text-danger mb-0">

                    Los usuarios con este rol conservarán sus cuentas, pero el rol cambiará de estado.

                </p>

            </div>

            <!-- Botones -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button
                    type="button"
                    class="btn btn-warning"
                    id="btnConfirmarEstadoRol">

                    Cambiar Estado

                </button>

            </div>

        </div>

    </div>

</div>

@endsection