<div class="card border-0">

    <div class="card-body">

        <div class="row">

            <div class="col-md-8 mb-3">

                <label class="form-label">

                    Nombre

                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $evaluationPeriod->name ?? '') }}">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Año

                </label>

                <input
                    type="number"
                    name="year"
                    class="form-control"
                    value="{{ old('year', $evaluationPeriod->year ?? date('Y')) }}">

            </div>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="description"
                rows="3"
                class="form-control">{{ old('description', $evaluationPeriod->description ?? '') }}</textarea>

        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Fecha de inicio

                </label>

                <input
                    type="date"
                    name="start_date"
                    class="form-control"
                    value="{{ old('start_date', $evaluationPeriod->start_date ?? '') }}">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Fecha de fin

                </label>

                <input
                    type="date"
                    name="end_date"
                    class="form-control"
                    value="{{ old('end_date', $evaluationPeriod->end_date ?? '') }}">

            </div>

        </div>

        <div class="mb-4">

            <label class="form-label">

                Estado

            </label>

            <select
                name="is_active"
                class="form-select">

                <option value="1"
                    {{ old('is_active', $evaluationPeriod->is_active ?? 1) == 1 ? 'selected' : '' }}>

                    Activo

                </option>

                <option value="0"
                    {{ old('is_active', $evaluationPeriod->is_active ?? 1) == 0 ? 'selected' : '' }}>

                    Inactivo

                </option>

            </select>

        </div>

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('evaluation-periods.index') }}"
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