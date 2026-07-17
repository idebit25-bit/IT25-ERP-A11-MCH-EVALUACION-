<div class="card border-0">

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Código

                </label>

                <input
                    type="text"
                    name="code"
                    class="form-control"
                    value="{{ old('code', $evaluationType->code ?? '') }}"
                >

            </div>

            <div class="col-md-9 mb-3">

                <label class="form-label">

                    Nombre

                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $evaluationType->name ?? '') }}"
                >

            </div>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="description"
                rows="3"
                class="form-control">{{ old('description', $evaluationType->description ?? '') }}</textarea>

        </div>

        <div class="mb-4">

            <label class="form-label">

                Estado

            </label>

            <select
                name="is_active"
                class="form-select">

                <option value="1"
                    {{ old('is_active', $evaluationType->is_active ?? 1) == 1 ? 'selected' : '' }}>

                    Activo

                </option>

                <option value="0"
                    {{ old('is_active', $evaluationType->is_active ?? 1) == 0 ? 'selected' : '' }}>

                    Inactivo

                </option>

            </select>

        </div>

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('evaluation-types.index') }}"
                class="btn btn-secondary">

                Cancelar

            </a>

            <button
                type="submit"
                class="btn btn-primary">

                Guardar

            </button>

        </div>

    </div>

</div>