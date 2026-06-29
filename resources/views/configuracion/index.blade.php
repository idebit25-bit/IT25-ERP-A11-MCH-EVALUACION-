@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            Configuración
        </h1>

        <p>
            Administración de parámetros generales del sistema ERP.
        </p>

    </div>

    <!-- Tarjetas -->

<div class="row mb-4">

    <div class="col-md-3 mb-3">

        <a href="/configuracion/usuarios" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-people text-primary fs-1"></i>

                    <h5 class="mt-3">
                        Usuarios
                    </h5>

                    <p class="card-text">
                        Administración de usuarios del sistema.
                    </p>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-3 mb-3">

        <a href="/configuracion/roles" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-shield-lock text-success fs-1"></i>

                    <h5 class="mt-3">
                        Roles y Permisos
                    </h5>

                    <p class="card-text">
                        Control de accesos y privilegios.
                    </p>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-3 mb-3">

        <a href="/configuracion/perfil" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-person-circle text-warning fs-1"></i>

                    <h5 class="mt-3">
                        Perfil
                    </h5>

                    <p class="card-text">
                        Configuración de información personal.
                    </p>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-3 mb-3">

        <a href="/configuracion/empresa" class="text-decoration-none">

            <div class="card border-0 dashboard-card">

                <div class="card-body text-center">

                    <i class="bi bi-building text-danger fs-1"></i>

                    <h5 class="mt-3">
                        Empresa
                    </h5>

                    <p class="card-text">
                        Datos generales de la organización.
                    </p>

                </div>

            </div>

        </a>

    </div>

</div>

<!-- Indicadores -->

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Usuarios registrados

                </span>

                <h2>

                    {{ $usuarios }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Roles activos

                </span>

                <h2>

                    {{ $roles }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Permisos configurados

                </span>

                <h2>

                    {{ $permisos }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 stats-card">

            <div class="card-body">

                <span class="stats-label">

                    Respaldos realizados

                </span>

                <h2>

                    {{ $respaldos }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- Configuración General -->

<div class="card border-0 table-card mb-4">

    <div class="card-header">

        Configuración General del Sistema

    </div>

    <div class="card-body">

        <div class="row">

            <!-- Sistema -->

            <div class="col-md-6 mb-3">

                <strong>

                    Nombre del sistema:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['sistema'] }}

                </p>

            </div>

            <!-- Versión -->

            <div class="col-md-6 mb-3">

                <strong>

                    Versión:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['version'] }}

                </p>

            </div>

            <!-- Última actualización -->

            <div class="col-md-6">

                <strong>

                    Última actualización:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['ultimaActualizacion'] }}

                </p>

            </div>

            <!-- Administrador -->

            <div class="col-md-6">

                <strong>

                    Administrador:

                </strong>

                <p class="mb-0">

                    {{ $configuracionGeneral['administrador'] }}

                </p>

            </div>

        </div>

    </div>

</div>


 <!-- Bitácora del sistema -->

<div class="card border-0 table-card">

    <div class="card-header">

        Bitácora del Sistema

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Fecha</th>

                        <th>Usuario</th>

                        <th>Acción</th>

                        <th>Módulo</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            31/05/2026

                        </td>

                        <td>

                            César Hernández

                        </td>

                        <td>

                            Creó un usuario administrador.

                        </td>

                        <td>

                            Usuarios

                        </td>

                    </tr>

                    <tr>

                        <td>

                            30/05/2026

                        </td>

                        <td>

                            César Hernández

                        </td>

                        <td>

                            Actualizó el rol Recursos Humanos.

                        </td>

                        <td>

                            Roles y Permisos

                        </td>

                    </tr>

                    <tr>

                        <td>

                            29/05/2026

                        </td>

                        <td>

                            César Hernández

                        </td>

                        <td>

                            Actualizó la información de la empresa.

                        </td>

                        <td>

                            Empresa

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection