@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>
            Editar Documento
        </h1>

        <p>
            Modificación de información del documento.
        </p>

    </div>

    <div class="card border-0 table-card">

        <div class="card-body">

            <form>

                <div class="mb-3">

                    <label class="form-label">
                        ID
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $documento['id'] }}"
                        readonly
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nombre del documento
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $documento['nombre'] }}"
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tipo
                    </label>

                    <select class="form-select">

                        <option {{ $documento['tipo'] == 'Manual' ? 'selected' : '' }}>
                            Manual
                        </option>

                        <option {{ $documento['tipo'] == 'Formato' ? 'selected' : '' }}>
                            Formato
                        </option>

                        <option {{ $documento['tipo'] == 'Política' ? 'selected' : '' }}>
                            Política
                        </option>

                        <option {{ $documento['tipo'] == 'Procedimiento' ? 'selected' : '' }}>
                            Procedimiento
                        </option>

                    </select>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Versión
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $documento['version'] }}"
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Vigencia
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $documento['vigencia'] }}"
                        >

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Estado
                    </label>

                    <select class="form-select">

                        <option {{ $documento['estado'] == 'Vigente' ? 'selected' : '' }}>
                            Vigente
                        </option>

                        <option {{ $documento['estado'] == 'Actualizado' ? 'selected' : '' }}>
                            Actualizado
                        </option>

                        <option {{ $documento['estado'] == 'Vencido' ? 'selected' : '' }}>
                            Vencido
                        </option>

                    </select>

                </div>

                <div class="d-flex gap-2">

                               

                    <button
                        type="button"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-save"></i>

                        Guardar cambios

                    </button>

                    <a
    href="{{ $documento['pdf'] }}"
    target="_blank"
    class="btn btn-outline-primary"
>

    <i class="bi bi-file-earmark-pdf"></i>

    Ver PDF

</a>

<a
    href="{{ $documento['pdf'] }}"
    download
    class="btn btn-outline-danger"
>

    <i class="bi bi-download"></i>

    Descargar PDF

</a>

<a
                        href="{{ url()->previous() }}"
                        class="btn btn-secondary"
                    >

                        <i class="bi bi-arrow-left"></i>

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection