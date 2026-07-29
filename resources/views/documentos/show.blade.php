@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Encabezado -->

    <div class="dashboard-header">

        <h1>
            {{ $documento->name }}
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
            {{ $documento->code }}
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Documento</strong>
        </div>

        <div class="col-md-9">
            {{ $documento->name }}
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Tipo</strong>
        </div>

        <div class="col-md-9">
            {{ $documento->type }}
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Versión</strong>
        </div>

        <div class="col-md-9">
            {{ $documento->version }}
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Vigencia</strong>
        </div>

        <div class="col-md-9">
            {{ \Carbon\Carbon::parse($documento->expiration_date)->format('d/m/Y') }}
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-3">
            <strong>Fecha</strong>
        </div>

        <div class="col-md-9">
            {{ $documento->created_at->format('d/m/Y') }}
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">
            <strong>Estado</strong>
        </div>

        <div class="col-md-9">

            @if($documento->status == 'Vigente')

                <span class="badge bg-success">
                    Vigente
                </span>

            @elseif($documento->status == 'Actualizado')

                <span class="badge bg-primary">
                    Actualizado
                </span>

            @elseif($documento->status == 'Vencido')

                <span class="badge bg-danger">
                    Vencido
                </span>

            @else

                <span class="badge bg-secondary">
                    {{ $documento->status }}
                </span>

            @endif

        </div>

    </div>

            <div class="d-flex gap-2">

 @php

$rutaRegreso = '/documentos';

switch ($documento->type) {

    case 'Manual':
        $rutaRegreso = '/documentos/manuales';
        break;

    case 'Formato':
        $rutaRegreso = '/documentos/formatos';
        break;

    case 'Política':
        $rutaRegreso = '/documentos/politicas';
        break;

    case 'Procedimiento':
        $rutaRegreso = '/documentos/procedimientos';
        break;
}

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
    href="{{ asset('storage/' . $documento->file_path) }}"
    target="_blank"
    class="btn btn-outline-primary">

    <i class="bi bi-file-earmark-pdf"></i>

    Ver PDF

</a>

<a
    href="{{ asset('storage/' . $documento->file_path) }}"
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