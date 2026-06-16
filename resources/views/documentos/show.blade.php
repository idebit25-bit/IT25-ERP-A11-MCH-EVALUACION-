@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            {{ $documento['nombre'] }}
        </h1>

        <p>
            Información detallada del documento.
        </p>

    </div>

    <!-- Información general -->

    <div class="card border-0 table-card mb-4">

        <div class="card-header">

            Información del documento

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>ID</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['id'] }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Documento</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['nombre'] }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Tipo</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['tipo'] }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Versión</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['version'] }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Vigencia</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['vigencia'] }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Fecha</strong>
                </div>

                <div class="col-md-9">
                    {{ $documento['fecha'] }}
                </div>

            </div>

            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Estado</strong>
                </div>

                <div class="col-md-9">

                    @if($documento['estado'] == 'Vigente')

                        <span class="badge bg-success">
                            Vigente
                        </span>

                    @elseif($documento['estado'] == 'Actualizado')

                        <span class="badge bg-primary">
                            Actualizado
                        </span>

                    @elseif($documento['estado'] == 'Vencido')

                        <span class="badge bg-danger">
                            Vencido
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ $documento['estado'] }}
                        </span>

                    @endif

                </div>

            </div>

            <div class="d-flex gap-2">

                @php

    $rutaRegreso = '/documentos';

    if(str_starts_with($documento['id'], 'MAN'))
        $rutaRegreso = '/documentos/manuales';

    elseif(str_starts_with($documento['id'], 'FOR'))
        $rutaRegreso = '/documentos/formatos';

    elseif(str_starts_with($documento['id'], 'POL'))
        $rutaRegreso = '/documentos/politicas';

    elseif(str_starts_with($documento['id'], 'PROC'))
        $rutaRegreso = '/documentos/procedimientos';

@endphp

<a href="{{ $rutaRegreso }}" class="btn btn-outline-secondary">

    <i class="bi bi-arrow-left"></i>

    Regresar

</a>

                <a href="/documentos/{{ $documento['id'] }}/edit"
                class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Editar

                </a>

<a
    href="{{ $documento['pdf'] }}"
    target="_blank"
    class="btn btn-outline-primary">

    <i class="bi bi-file-earmark-pdf"></i>

    Ver PDF

</a>

<a
    href="{{ $documento['pdf'] }}"
    download
    class="btn btn-outline-danger">

    <i class="bi bi-download"></i>

    Descargar PDF

</a>

            </div>

        </div>

    </div>

</div>

@endsection