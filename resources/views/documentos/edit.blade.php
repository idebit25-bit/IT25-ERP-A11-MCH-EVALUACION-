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

<form
    action="{{ url('/documentos/' . $documento->id) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        ID
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $documento->code }}"
                        readonly
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nombre del documento
                    </label>

                    <input
    type="text"
    name="name"
    class="form-control"
    value="{{ $documento->name }}"
>
                    
                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tipo
                    </label>

                    <select
                    
                    name="type"
                    class="form-select"
                >
<option value="Manual" {{ $documento->type == 'Manual' ? 'selected' : '' }}>
    Manual
</option>

<option value="Formato" {{ $documento->type == 'Formato' ? 'selected' : '' }}>
    Formato
</option>

<option value="Política" {{ $documento->type == 'Política' ? 'selected' : '' }}>
    Política
</option>

<option value="Procedimiento" {{ $documento->type == 'Procedimiento' ? 'selected' : '' }}>
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
    name="version"
    class="form-control"
    value="{{ $documento->version }}"
>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Vigencia
                        </label>

                       <input
    type="date"
    name="expiration_date"
    class="form-control"
    value="{{ \Carbon\Carbon::parse($documento->expiration_date)->format('Y-m-d') }}"
>

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Estado
                    </label>

                    <select
    name="status"
    class="form-select"
>


<option value="Vigente" {{ $documento->status == 'Vigente' ? 'selected' : '' }}>
    Vigente
</option>

<option value="Actualizado" {{ $documento->status == 'Actualizado' ? 'selected' : '' }}>
    Actualizado
</option>

<option value="Vencido" {{ $documento->status == 'Vencido' ? 'selected' : '' }}>
    Vencido
</option>

                    </select>

                </div>

                <div class="mb-4">

    <label class="form-label">
        Archivo PDF
    </label>

    <input
        type="file"
        name="document"
        class="form-control"
        accept="application/pdf"
    >

    <small class="text-muted">
        Si no selecciona un archivo, se conservará el PDF actual.
    </small>

</div>

                <div class="d-flex gap-2">

                               

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-save"></i>

                        Guardar cambios

                    </button>

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