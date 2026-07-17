<div class="card border-0">

    <div class="card-body">

        <div class="mb-3">

            <label class="form-label">

                Categoría

            </label>

            <select
                name="category_id"
                class="form-select">

                <option value="">

                    Seleccione una categoría

                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $evaluationCompetency->category_id ?? '') == $category->id ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Competencia

            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $evaluationCompetency->name ?? '') }}">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="description"
                rows="3"
                class="form-control">{{ old('description', $evaluationCompetency->description ?? '') }}</textarea>

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
                    {{ old('is_active', $evaluationCompetency->is_active ?? 1) == 1 ? 'selected' : '' }}>

                    Activo

                </option>

                <option
                    value="0"
                    {{ old('is_active', $evaluationCompetency->is_active ?? 1) == 0 ? 'selected' : '' }}>

                    Inactivo

                </option>

            </select>

        </div>

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('evaluation-competencies.index') }}"
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