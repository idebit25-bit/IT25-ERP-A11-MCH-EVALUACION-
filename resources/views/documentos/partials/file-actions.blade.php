@if($fileAvailable)
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('documentos.file', $documento->id) }}" target="_blank" rel="noopener" class="btn btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i> Ver PDF</a>
        <a href="{{ route('documentos.file', ['id' => $documento->id, 'download' => 1]) }}" class="btn btn-outline-danger"><i class="bi bi-download"></i> Descargar PDF</a>
    </div>
@else
    <div class="alert alert-warning mb-0" role="alert">
        El archivo PDF no está disponible.
        {{ auth()->user()->hasModulePermission('documentos.gestionar') ? 'Adjunta nuevamente el PDF desde Editar para recuperarlo.' : 'Solicita al administrador que lo adjunte nuevamente.' }}
    </div>
@endif
