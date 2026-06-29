@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Usuarios
        </h1>

        <p>
            Administración de cuentas de acceso al sistema.
        </p>

    </div>

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Usuarios
                    </span>

                    <h2>12</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Administradores
                    </span>

                    <h2>2</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Activos
                    </span>

                    <h2>10</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">
                        Bloqueados
                    </span>

                    <h2>2</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Barra de acciones -->

    <div class="card border-0 table-card mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <!-- Botón Nuevo Usuario -->

                <div class="col-md-3">

                    <button
                        id="btnNuevoUsuario"
                        class="btn btn-primary">

                        <i class="bi bi-person-plus"></i>

                        Nuevo Usuario

                    </button>

                </div>

                <!-- Buscar -->

                <div class="col-md-5">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar usuario...">

                </div>

                <!-- Rol -->

                <div class="col-md-2">

                    <select class="form-select">

                        <option>Todos los roles</option>

                        <option>Administrador</option>

                        <option>Recursos Humanos</option>

                        <option>Supervisor</option>

                    </select>

                </div>

                <!-- Estado -->

                <div class="col-md-2">

                    <select class="form-select">

                        <option>Todos</option>

                        <option>Activos</option>

                        <option>Bloqueados</option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <!-- Tabla de Usuarios -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Usuarios registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nombre</th>

                            <th>Usuario</th>

                            <th>Correo</th>

                            <th>Rol</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        
                      <!-- Lista de usuarios -->

@foreach ($usuarios as $usuario)

<tr>

    <!-- Nombre -->

    <td>

        {{ $usuario['nombre'] }}

    </td>

    <!-- Usuario -->

    <td>

        {{ $usuario['usuario'] }}

    </td>

    <!-- Correo -->

    <td>

        {{ $usuario['correo'] }}

    </td>

    <!-- Rol -->

    <td>

        @switch($usuario['rol'])

            @case('Administrador')

                <span class="badge bg-primary">

                    {{ $usuario['rol'] }}

                </span>

                @break

            @case('Recursos Humanos')

                <span class="badge bg-success">

                    {{ $usuario['rol'] }}

                </span>

                @break

            @default

                <span class="badge bg-info">

                    {{ $usuario['rol'] }}

                </span>

        @endswitch

    </td>

    <!-- Estado -->

    <td>

        @if ($usuario['estado'] == 'Activo')

            <span class="badge bg-success">

                {{ $usuario['estado'] }}

            </span>

        @else

            <span class="badge bg-secondary">

                {{ $usuario['estado'] }}

            </span>

        @endif

    </td>

    <!-- Acciones -->

    <td>

        <!-- Botón Ver -->

        <button
            class="btn btn-sm btn-outline-primary btnVerUsuario"

            data-id="{{ $usuario['id'] }}"
            data-nombre="{{ $usuario['nombre'] }}"
            data-usuario="{{ $usuario['usuario'] }}"
            data-correo="{{ $usuario['correo'] }}"
            data-rol="{{ $usuario['rol'] }}"
            data-estado="{{ $usuario['estado'] }}"
            data-acceso="{{ $usuario['ultimoAcceso'] }}">

            <i class="bi bi-eye"></i>

        </button>

        <!-- Botón Editar -->

        <button
            class="btn btn-sm btn-outline-warning btnEditarUsuario"

            data-id="{{ $usuario['id'] }}"
            data-nombre="{{ $usuario['nombre'] }}"
            data-usuario="{{ $usuario['usuario'] }}"
            data-correo="{{ $usuario['correo'] }}"
            data-rol="{{ $usuario['rol'] }}"
            data-estado="{{ $usuario['estado'] }}">

            <i class="bi bi-pencil-square"></i>

        </button>

<!-- Botón Bloquear / Desbloquear -->

<button
    class="btn btn-sm btn-outline-secondary btnBloquearUsuario"

    data-id="{{ $usuario['id'] }}"
    data-nombre="{{ $usuario['nombre'] }}"
    data-estado="{{ $usuario['estado'] }}">

    @if ($usuario['estado'] == 'Activo')

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

<!-- Modal Nuevo Usuario -->

<div
    class="modal fade"
    id="modalNuevoUsuario"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Nuevo Usuario

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

                            Nombre completo

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingrese el nombre">

                    </div>

                    <!-- Usuario -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Usuario

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre de usuario">

                    </div>

                    <!-- Correo -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Correo electrónico

                        </label>

                        <input
                            type="email"
                            class="form-control"
                            placeholder="correo@empresa.com">

                    </div>

                    <!-- Rol -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Rol

                        </label>

                        <select class="form-select">

                            <option>
                                Seleccione...
                            </option>

                            <option>
                                Administrador
                            </option>

                            <option>
                                Recursos Humanos
                            </option>

                            <option>
                                Supervisor
                            </option>

                        </select>

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
                                Bloqueado
                            </option>

                        </select>

                    </div>

                    <!-- Contraseña -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Contraseña

                        </label>

                        <input
                            type="password"
                            class="form-control"
                            placeholder="****">

                    </div>

                    <!-- Confirmar contraseña -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Confirmar contraseña

                        </label>

                        <input
                            type="password"
                            class="form-control"
                            placeholder="****">

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
                    id="btnGuardarUsuario">

                    Guardar Usuario

                </button>

            </div>

        </div>

    </div>

</div>



<!-- Modal Ver Usuario -->

<div
    class="modal fade"
    id="modalVerUsuario"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Información del Usuario

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
                id="contenidoVerUsuario">

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

<!-- Modal Editar Usuario -->

<div
    class="modal fade"
    id="modalEditarUsuario"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Editar Usuario

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

                            Nombre completo

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editarNombre">

                    </div>

                    <!-- Usuario -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Usuario

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editarUsuario">

                    </div>

                    <!-- Correo -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Correo electrónico

                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="editarCorreo">

                    </div>

                    <!-- Rol -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Rol

                        </label>

                        <select 
                        class="form-select" 
                        id="editarRol">

                            <option>
                                Administrador
                            </option>

                            <option>
                                Recursos Humanos
                            </option>

                            <option>
                                Supervisor
                            </option>

                        </select>

                    </div>

                    <!-- Estado -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Estado

                        </label>

                        <select 
                            class="form-select" 
                            id="editarEstado">

                            <option>
                                Activo
                            </option>

                            <option>
                                Bloqueado
                            </option>

                        </select>

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
                    id="btnActualizarUsuario">

                    Actualizar Usuario

                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal Bloquear Usuario -->

<div
    class="modal fade"
    id="modalBloquearUsuario"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Encabezado -->

            <div class="modal-header">

                <h5 class="modal-title">

                    Bloquear Usuario

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

<!-- Cuerpo del modal -->

<div class="modal-body">

    <!-- Mensaje dinámico -->

    <p id="mensajeBloquearUsuario">

        ¿Deseas bloquear este usuario?

    </p>

    <!-- Advertencia -->

    <p class="text-danger mb-0">

        El usuario no podrá iniciar sesión hasta que vuelva a ser activado.

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
                    id="btnConfirmarBloqueo">

                    Bloquear Usuario

                </button>

            </div>

        </div>

    </div>

</div>

@endsection