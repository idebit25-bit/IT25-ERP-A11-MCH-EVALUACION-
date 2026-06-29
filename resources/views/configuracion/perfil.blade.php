@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>

            Perfil

        </h1>

        <p>

            Administración de la información personal del usuario.

        </p>

    </div>

    <!-- Información -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Rol

                    </span>

                    <h5>

                        {{ $perfil['rol'] }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Usuario

                    </span>

                    <h5>

                        {{ $perfil['usuario'] }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Último acceso

                    </span>

                    <h5>

                        {{ $perfil['ultimoAcceso'] }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- Formulario -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Información del Perfil

        </div>

        <div class="card-body">

            <div class="row">

                <!-- Nombre -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Nombre completo

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $perfil['nombre'] }}">

                </div>

                <!-- Usuario -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Usuario

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $perfil['usuario'] }}">

                </div>

                <!-- Correo -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Correo electrónico

                    </label>

                    <input
                        type="email"
                        class="form-control"
                        value="{{ $perfil['correo'] }}">

                </div>

                <!-- Teléfono -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Teléfono

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $perfil['telefono'] }}">

                </div>

                <!-- Contraseña -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Nueva contraseña

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

        <div class="card-footer text-end">

            <button
                type="button"
                class="btn btn-primary"
                id="btnActualizarPerfil">

                Actualizar Perfil

            </button>

        </div>

    </div>

</div>

@endsection