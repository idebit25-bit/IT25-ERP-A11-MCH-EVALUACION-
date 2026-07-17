@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>

            Configurar pregunta

        </h1>

        <p>

            {{ $evaluationTemplate->name }}

        </p>

    </div>

    <form
        action="{{ route('template-questions.update', [$evaluationTemplate->id, $templateQuestion->id]) }}"
        method="POST">

        @csrf

        @method('PUT')

        <div class="card">

            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">

                        Pregunta

                    </label>

                    <textarea
                        class="form-control"
                        rows="3"
                        disabled>{{ $templateQuestion->question->question }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Orden

                    </label>

                    <input
                        type="number"
                        name="order_number"
                        class="form-control"
                        value="{{ old('order_number', $templateQuestion->order_number) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Peso

                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="weight"
                        class="form-control"
                        value="{{ old('weight', $templateQuestion->weight) }}">

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Obligatoria

                    </label>

                    <select
                        name="is_required"
                        class="form-select">

                        <option
                            value="1"
                            {{ $templateQuestion->is_required ? 'selected' : '' }}>

                            Sí

                        </option>

                        <option
                            value="0"
                            {{ !$templateQuestion->is_required ? 'selected' : '' }}>

                            No

                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Guardar cambios

                </button>

            </div>

        </div>

    </form>

</div>

@endsection