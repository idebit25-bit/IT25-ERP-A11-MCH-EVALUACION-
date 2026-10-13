@isset($documento)
    <div class="mb-3"><label class="form-label" for="document-code">Código</label><input id="document-code" class="form-control" value="{{ $documento->code }}" readonly></div>
@endisset
<div class="mb-3">
    <label class="form-label" for="document-name">Nombre del documento</label>
    <input id="document-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $documento->name ?? '') }}" maxlength="255" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="tipoDocumento">Tipo</label>
        <select id="tipoDocumento" name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach(\App\Models\Document::TYPES as $type)
                <option value="{{ $type }}" @selected(old('type', $documento->type ?? '') === $type)>{{ $type }}</option>
            @endforeach
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="document-version">Versión</label>
        <input id="document-version" name="version" class="form-control @error('version') is-invalid @enderror" value="{{ old('version', $documento->version ?? '1.0') }}" maxlength="20" required>
        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="document-expiration">Vigencia (opcional)</label>
        <input id="document-expiration" type="date" name="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', $documento->expiration_date ?? '') }}">
        <div class="form-text">Deja la fecha vacía si el documento no tiene vencimiento.</div>
        @error('expiration_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="document-status">Estado</label>
        <select id="document-status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(\App\Models\Document::STATUSES as $status)
                <option value="{{ $status }}" @selected(old('status', $documento->status ?? 'Vigente') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-4">
    <label class="form-label" for="document-file">{{ isset($documento) ? 'Reemplazar PDF (opcional)' : 'Archivo PDF' }}</label>
    <input id="document-file" type="file" name="document" class="form-control @error('document') is-invalid @enderror" accept=".pdf,application/pdf" @required(!isset($documento))>
    <div class="form-text">PDF de hasta 5 MB. {{ isset($documento) ? 'Si no seleccionas un archivo, se conserva el actual.' : '' }}</div>
    @error('document')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @if($errors->any())<div class="form-text">Si habías elegido un PDF, vuelve a seleccionarlo antes de guardar.</div>@endif
</div>
@isset($documento)
    @include('documentos.partials.file-actions')
@endisset
<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ isset($documento) ? 'Guardar cambios' : 'Guardar documento' }}</button>
    <a href="{{ url('/documentos') }}" class="btn btn-secondary">Cancelar</a>
</div>
