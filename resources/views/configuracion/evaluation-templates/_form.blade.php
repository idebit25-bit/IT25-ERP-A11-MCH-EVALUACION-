<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="mb-3">

            <label class="form-label">

                Tipo de evaluación

            </label>

            <select
                name="evaluation_type_id"
                class="form-select">

                <option value="">

                    Seleccione...

                </option>

                @foreach($evaluationTypes as $evaluationType)

                    <option
                        value="{{ $evaluationType->id }}"
                        {{ old('evaluation_type_id', $evaluationTemplate->evaluation_type_id ?? '') == $evaluationType->id ? 'selected' : '' }}>

                        {{ $evaluationType->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Nombre

            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $evaluationTemplate->name ?? '') }}">

        </div>

        <div class="mb-4">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="description"
                rows="3"
                class="form-control">{{ old('description', $evaluationTemplate->description ?? '') }}</textarea>

        </div>

        <div class="row">

            <div class="col-md-6">

                <label class="form-label">

                    Estado

                </label>

                <select
                    name="is_active"
                    class="form-select">

                    <option
                        value="1"
                        {{ old('is_active', $evaluationTemplate->is_active ?? 1) == 1 ? 'selected' : '' }}>

                        Activa

                    </option>

                    <option
                        value="0"
                        {{ old('is_active', $evaluationTemplate->is_active ?? 1) == 0 ? 'selected' : '' }}>

                        Inactiva

                    </option>

                </select>

            </div>

        </div>

        <div class="d-flex justify-content-end mt-4">

            <a
                href="{{ route('evaluation-templates.index') }}"
                class="btn btn-secondary me-2">

                Cancelar

            </a>

            <button
                type="submit"
                class="btn btn-primary">

                Guardar plantilla

            </button>

        </div>

    </div>

</div>