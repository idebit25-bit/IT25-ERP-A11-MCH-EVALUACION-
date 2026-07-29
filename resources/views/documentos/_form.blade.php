<div class="mb-3">

    <label class="form-label">
        Nombre del documento
    </label>

    <input
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name', $documento->name ?? '') }}"
        required
    >

</div>

<div class="mb-3">

    <label class="form-label">
        Tipo
    </label>

    <select
        name="type"
        class="form-select"
        required
    >

        <option value="">Seleccione...</option>

        <option value="Manual" @selected(old('type', $documento->type ?? '') == 'Manual')>Manual</option>

        <option value="Formato" @selected(old('type', $documento->type ?? '') == 'Formato')>Formato</option>

        <option value="Política" @selected(old('type', $documento->type ?? '') == 'Política')>Política</option>

        <option value="Procedimiento" @selected(old('type', $documento->type ?? '') == 'Procedimiento')>Procedimiento</option>

    </select>

</div>

<div class="row">

    <div class="col-md-6">

        <label class="form-label">
            Versión
        </label>

        <input
            type="text"
            name="version"
            class="form-control"
            value="{{ old('version', $documento->version ?? '1.0') }}"
            required
        >

    </div>

    <div class="col-md-6">

        <label class="form-label">
            Vigencia
        </label>

        <input
            type="date"
            name="expiration_date"
            class="form-control"
            value="{{ old('expiration_date', isset($documento) && $documento->expiration_date ? \Carbon\Carbon::parse($documento->expiration_date)->format('Y-m-d') : '') }}"
        >

    </div>

</div>

<div class="mt-3 mb-4">

    <label class="form-label">
        Estado
    </label>

    <select
        name="status"
        class="form-select"
        required
    >

        <option value="Vigente" @selected(old('status', $documento->status ?? '') == 'Vigente')>Vigente</option>

        <option value="Actualizado" @selected(old('status', $documento->status ?? '') == 'Actualizado')>Actualizado</option>

        <option value="Vencido" @selected(old('status', $documento->status ?? '') == 'Vencido')>Vencido</option>

    </select>

</div>

<button
    type="submit"
    class="btn btn-primary"
>
    <i class="bi bi-save"></i>

    Guardar
</button>

<a
    href="{{ url('/documentos') }}"
    class="btn btn-secondary"
>
    Cancelar
</a>