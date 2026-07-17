@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-templates.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card border-0 shadow-sm">

        <div class="card-header">

            Información de la plantilla

        </div>

        <div class="card-body">

            <div class="mb-3">

                <strong>Tipo de evaluación</strong>

                <p>

                    {{ $evaluationTemplate->evaluationType->name }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Nombre</strong>

                <p>

                    {{ $evaluationTemplate->name }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Descripción</strong>

                <p>

                    {{ $evaluationTemplate->description ?: 'Sin descripción.' }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Preguntas asignadas</strong>

                <p>

                    {{ $evaluationTemplate->templateQuestions()->count() }}

                </p>

            </div>

            <div class="mb-3">

                <strong>Estado</strong>

                <p>

                    @if($evaluationTemplate->is_active)

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

@endsection