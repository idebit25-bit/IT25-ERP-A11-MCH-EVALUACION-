@extends('layouts.app')

@section('title', 'Detalle de Evaluación')

@section('content')
@if(auth()->user()->hasModulePermission('evaluaciones.gestionar') || $evaluation->user_id == auth()->id() || $evaluation->evaluator_id == auth()->id())
<a class="btn btn-outline-primary mb-3" href="{{ route('mis-evaluaciones.show', $evaluation->id) }}">Abrir seguimiento de la prueba</a>
@endif

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-0">
                Detalle de Evaluación
            </h2>

            <small class="text-muted">
                Evaluación #{{ $evaluation->id }}
            </small>
        </div>

        <div>

@if($evaluation->status === 'draft')

    <a
        href="{{ route('evaluaciones.edit', $evaluation->id) }}"
        class="btn btn-warning">

        <i class="bi bi-pencil-square"></i>
        Editar

    </a>

@endif

            <a
                href="{{ route('evaluaciones.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Regresar

            </a>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Colaborador
                    </h6>

                    <p>
                        {{ $evaluation->user->employee_code }}
                        -
                        {{ $evaluation->user->first_name }}
                        {{ $evaluation->user->paternal_surname }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Evaluador
                    </h6>

                    <p>
                        {{ $evaluation->evaluator->first_name }}
                        {{ $evaluation->evaluator->paternal_surname }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Tipo de evaluación
                    </h6>

                    <p>
                        {{ $evaluation->evaluationType->name }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Período
                    </h6>

                    <p>
                        {{ $evaluation->period->name }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Plantilla
                    </h6>

                    <p>
                        {{ $evaluation->template->name }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Fecha
                    </h6>

                    <p>
                        {{ $evaluation->evaluation_date }}
                    </p>

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Estado
                    </h6>

                        @switch($evaluation->status)

                            @case('draft')

                                <span class="badge bg-secondary">
                                    Borrador
                                </span>

                                @break

                            @case('completed')

                                <span class="badge bg-success">
                                    Completada
                                </span>

                                @break

                            @case('cancelled')

                                <span class="badge bg-danger">
                                    Cancelada
                                </span>

                                @break

                        @endswitch

                </div>

                <div class="col-md-6 mb-4">

                    <h6 class="text-muted">
                        Calificación
                    </h6>

                    <p class="fw-bold fs-5">
                        {{ number_format($evaluation->total_score, 2) }} / 5.00
                    </p>

                </div>

                <div class="col-12">

                    <h6 class="text-muted">
                        Observaciones
                    </h6>

                    <div class="border rounded p-3 bg-light">

                        {{ $evaluation->observations ?: 'Sin observaciones.' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm border-0 mt-4">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Respuestas de la evaluación
        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Categoría</th>

                        <th>Competencia</th>

                        <th>Pregunta</th>

                        <th>Respuesta</th>

                        <th class="text-center">
                            Valor
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($evaluation->answers as $answer)

                        <tr>

                            <td>

                                {{ $answer->question->category->name ?? '-' }}

                            </td>

                            <td>

                                {{ $answer->question->competency->name ?? '-' }}

                            </td>

                            <td>

                                {{ $answer->question->question }}

                            </td>

                            <td>

                                {{ $answer->answer }}

                            </td>

                            <td class="text-center">

                                {{ number_format($answer->numeric_value, 2) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No existen respuestas registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

