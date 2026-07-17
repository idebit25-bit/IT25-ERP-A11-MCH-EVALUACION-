<div class="card border-0 shadow-sm">

    <div class="card-body">

        <h5 class="mb-4">

            Información general

        </h5>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Tipo de evaluación

                </label>

                <select
                    name="evaluation_type_id"
                    class="form-select">

                    <option value="">

                        Seleccione...

                    </option>

                    @foreach($evaluationTypes as $type)

                        <option
                            value="{{ $type->id }}"
                            {{ old('evaluation_type_id', $evaluationQuestion->evaluation_type_id ?? '') == $type->id ? 'selected' : '' }}>

                            {{ $type->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Categoría

                </label>

                <select
                    name="category_id"
                    class="form-select">

                    <option value="">

                        Seleccione...

                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $evaluationQuestion->category_id ?? '') == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Competencia

                </label>

                <select
                    name="competency_id"
                    class="form-select">

                    <option value="">

                        Seleccione...

                    </option>

                    @foreach($competencies as $competency)

                        <option
                            value="{{ $competency->id }}"
                            {{ old('competency_id', $evaluationQuestion->competency_id ?? '') == $competency->id ? 'selected' : '' }}>

                            {{ $competency->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label">

                    Escala

                </label>

                <select
                    name="scale_id"
                    class="form-select">

                    <option value="">

                        Seleccione...

                    </option>

                    @foreach($scales as $scale)

                        <option
                            value="{{ $scale->id }}"
                            {{ old('scale_id', $evaluationQuestion->scale_id ?? '') == $scale->id ? 'selected' : '' }}>

                            {{ $scale->name }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <hr>

        <h5 class="mb-4">

            Información de la pregunta

        </h5>

        <div class="mb-3">

            <label class="form-label">

                Tipo de pregunta

            </label>

<select
    name="question_type"
    class="form-select">

    <option
        value="radio"
        {{ old('question_type', $evaluationQuestion->question_type ?? 'radio') == 'radio' ? 'selected' : '' }}>

        Selección única (Radio)

    </option>

    <option
        value="checkbox"
        {{ old('question_type', $evaluationQuestion->question_type ?? '') == 'checkbox' ? 'selected' : '' }}>

        Selección múltiple (Checkbox)

    </option>

    <option
        value="select"
        {{ old('question_type', $evaluationQuestion->question_type ?? '') == 'select' ? 'selected' : '' }}>

        Lista desplegable

    </option>

    <option
        value="textarea"
        {{ old('question_type', $evaluationQuestion->question_type ?? '') == 'textarea' ? 'selected' : '' }}>

        Respuesta abierta

    </option>

    <option
        value="number"
        {{ old('question_type', $evaluationQuestion->question_type ?? '') == 'number' ? 'selected' : '' }}>

        Respuesta numérica

    </option>

</select>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Pregunta

            </label>

            <textarea
                name="question"
                rows="3"
                class="form-control">{{ old('question', $evaluationQuestion->question ?? '') }}</textarea>

        </div>

        <div class="mb-4">

            <label class="form-label">

                Texto de ayuda

            </label>

            <textarea
                name="help_text"
                rows="2"
                class="form-control">{{ old('help_text', $evaluationQuestion->help_text ?? '') }}</textarea>

        </div>

        <hr>

        <h5 class="mb-4">

            Configuración

        </h5>

        <div class="row">

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Peso

                </label>

                <input
                    type="number"
                    step="0.01"
                    name="weight"
                    class="form-control"
                    value="{{ old('weight', $evaluationQuestion->weight ?? 1) }}">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Orden

                </label>

                <input
                    type="number"
                    name="order_number"
                    class="form-control"
                    value="{{ old('order_number', $evaluationQuestion->order_number ?? 1) }}">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Obligatoria

                </label>

                <select
                    name="is_required"
                    class="form-select">

                    <option value="1">

                        Sí

                    </option>

                    <option value="0">

                        No

                    </option>

                </select>

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select
                    name="is_active"
                    class="form-select">

                    <option value="1">

                        Activo

                    </option>

                    <option value="0">

                        Inactivo

                    </option>

                </select>

            </div>

        </div>

        <div class="d-flex justify-content-end mt-4">

            <a
                href="{{ route('evaluation-questions.index') }}"
                class="btn btn-secondary me-2">

                Cancelar

            </a>

            <button
                type="submit"
                class="btn btn-primary">

                Guardar pregunta

            </button>

        </div>

    </div>

</div>