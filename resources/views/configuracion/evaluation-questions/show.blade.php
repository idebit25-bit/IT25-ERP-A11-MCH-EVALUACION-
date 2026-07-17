@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-questions.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            Información de la pregunta

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Tipo de evaluación</strong>

                    <p>

                        {{ $evaluationQuestion->evaluationType->name }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Categoría</strong>

                    <p>

                        {{ $evaluationQuestion->category->name }}

                    </p>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Competencia</strong>

                    <p>

                        {{ $evaluationQuestion->competency->name }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Escala</strong>

                    <p>

                        {{ $evaluationQuestion->scale->name }}

                    </p>

                </div>

            </div>

            <hr>

            <div class="mb-3">

                <strong>Tipo de pregunta</strong>

                <p>

                    {{ $evaluationQuestion->question_type }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Pregunta</strong>

                <p>

                    {{ $evaluationQuestion->question }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Texto de ayuda</strong>

                <p>

                    {{ $evaluationQuestion->help_text ?: 'Sin información.' }}

                </p>

            </div>

            <div class="row">

                <div class="col-md-3">

                    <strong>Peso</strong>

                    <p>

                        {{ $evaluationQuestion->weight }}

                    </p>

                </div>

                <div class="col-md-3">

                    <strong>Orden</strong>

                    <p>

                        {{ $evaluationQuestion->order_number }}

                    </p>

                </div>

                <div class="col-md-3">

                    <strong>Obligatoria</strong>

                    <p>

                        {{ $evaluationQuestion->is_required ? 'Sí' : 'No' }}

                    </p>

                </div>

                <div class="col-md-3">

                    <strong>Estado</strong>

                    <p>

                        @if($evaluationQuestion->is_active)

                            <span class="badge bg-success">

                                Activa

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactiva

                            </span>

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection