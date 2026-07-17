<div class="card border-0">

    <div class="card-body">

        <div class="mb-3">

            <label class="form-label">

                Nombre

            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $evaluationCategory->name ?? '') }}">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="description"
                rows="3"
                class="form-control">{{ old('description', $evaluationCategory->description ?? '') }}</textarea>

        </div>

        <div class="mb-4">

            <label class="form-label">

                Estado

            </label>

            <select
                name="is_active"
                class="form-select">

                <option
                    value="1"
                    {{ old('is_active', $evaluationCategory->is_active ?? 1) == 1 ? 'selected' : '' }}>

                    Activo

                </option>

                <option
                    value="0"
                    {{ old('is_active', $evaluationCategory->is_active ?? 1) == 0 ? 'selected' : '' }}>

                    Inactivo

                </option>

            </select>

        </div>

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('evaluation-categories.index') }}"
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