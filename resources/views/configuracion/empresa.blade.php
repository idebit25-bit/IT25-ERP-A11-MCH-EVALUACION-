@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>

            Empresa

        </h1>

        <p>

            Administración de la información general de la empresa.

        </p>

    </div>

    <!-- Información -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Moneda

                    </span>

                    <h5>

                        {{ $empresa['moneda'] }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        Zona horaria

                    </span>

                    <h5>

                        {{ $empresa['zonaHoraria'] }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 stats-card">

                <div class="card-body">

                    <span class="stats-label">

                        RFC

                    </span>

                    <h5>

                        {{ $empresa['rfc'] }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- Formulario -->

    <div class="card border-0 table-card">

        <div class="card-header">

            Información de la Empresa

        </div>

        <div class="card-body">

            <div class="row">

                <!-- Nombre -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Nombre de la empresa

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $empresa['nombre'] }}">

                </div>

                <!-- Razón social -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Razón social

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $empresa['razonSocial'] }}">

                </div>

                <!-- RFC -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        RFC

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $empresa['rfc'] }}">

                </div>

                <!-- Teléfono -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Teléfono

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $empresa['telefono'] }}">

                </div>

                <!-- Correo -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Correo electrónico

                    </label>

                    <input
                        type="email"
                        class="form-control"
                        value="{{ $empresa['correo'] }}">

                </div>

                <!-- Sitio web -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Sitio web

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $empresa['sitioWeb'] }}">

                </div>

                <!-- Dirección -->

                <div class="col-12 mb-3">

                    <label class="form-label">

                        Dirección

                    </label>

                    <textarea
                        class="form-control"
                        rows="3">{{ $empresa['direccion'] }}</textarea>

                </div>

            </div>

        </div>

        <!-- Botones -->

        <div class="card-footer text-end">

            <button
                type="button"
                class="btn btn-primary"
                id="btnActualizarEmpresa">

                Actualizar Empresa

            </button>

        </div>

    </div>

</div>

@endsection