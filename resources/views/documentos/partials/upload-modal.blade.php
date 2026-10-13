@if(auth()->user()->hasModulePermission('documentos.gestionar'))
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadTitle" aria-hidden="true" data-reopen="{{ old('_document_upload') ? '1' : '0' }}">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="uploadTitle">Subir documento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/documentos') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_document_upload" value="1">
                @include('documentos._form', ['documento' => null])
            </form>
        </div>
    </div></div>
</div>
@endif
