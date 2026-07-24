<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="row">

            <!-- Colaborador -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Colaborador
                </label>

                <select
                    name="user_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Seleccione un colaborador
                    </option>

                    @foreach($users as $user)

                    
                    <option
                        value="{{ $user->id }}"
                        @selected(old('user_id', $evaluation->user_id ?? '') == $user->id)
                    >
                    
                        {{ $user->employee_code }}
                        -
                        {{ $user->first_name }}
                        {{ $user->paternal_surname }}
                    
                    </option>

                    @endforeach

                </select>

            </div>

            <!-- Tipo -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Tipo de evaluación
                </label>

                <select
                    name="evaluation_type_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Seleccione un tipo
                    </option>

                    @foreach($evaluationTypes as $type)

                    
                    <option
value="{{ $type->id }}"
@selected(old('evaluation_type_id', $evaluation->evaluation_type_id ?? '') == $type->id)
>
                            {{ $type->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Período -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Período
                </label>

                <select
                    name="period_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Seleccione un período
                    </option>

                    @foreach($periods as $period)

                        <option
    value="{{ $period->id }}"
    @selected(old('period_id', $evaluation->period_id ?? '') == $period->id)
>

                            {{ $period->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Plantilla -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Plantilla
                </label>

                <select
                    name="template_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Seleccione una plantilla
                    </option>

                    @foreach($templates as $template)

                        <option
    value="{{ $template->id }}"
    @selected(old('template_id', $evaluation->template_id ?? '') == $template->id)
>

                            {{ $template->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Evaluador -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Evaluador
                </label>

                <select
                    name="evaluator_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Seleccione un evaluador
                    </option>

                    @foreach($evaluators as $evaluator)

                        <option
    value="{{ $evaluator->id }}"
    @selected(old('evaluator_id', $evaluation->evaluator_id ?? '') == $evaluator->id)
>

                            {{ $evaluator->first_name }}
                            {{ $evaluator->paternal_surname }}

                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Fecha -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Fecha de evaluación
                </label>

<input
    type="date"
    name="evaluation_date"
    class="form-control"
    value="{{ old('evaluation_date', $evaluation->evaluation_date ?? '') }}"
    required
>

            </div>

            <!-- Observaciones -->

            <div class="col-12 mb-4">

                <label class="form-label">
                    Observaciones
                </label>

<textarea
    name="observations"
    rows="4"
    class="form-control"
>{{ old('observations', $evaluation->observations ?? '') }}</textarea>

            </div>

        </div>

<button
    type="submit"
    class="btn btn-primary"
>
    {{ isset($evaluation) ? 'Actualizar evaluación' : 'Guardar evaluación' }}
</button>

    </div>

</div>