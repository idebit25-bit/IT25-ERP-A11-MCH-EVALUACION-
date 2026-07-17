@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>

            Banco de preguntas

        </h1>

        <p>

            Administración del banco de preguntas para las evaluaciones.

        </p>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card border-0 table-card mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <strong>

                    Banco de preguntas

                </strong>

                <p class="text-muted mb-0">

                    Preguntas registradas en el sistema.

                </p>

            </div>

            <a
                href="{{ route('evaluation-questions.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nueva pregunta

            </a>

        </div>

    </div>

    <div class="card border-0 table-card">

        <div class="card-header">

            Preguntas registradas

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Tipo</th>

                            <th>Categoría</th>

                            <th>Competencia</th>

                            <th>Pregunta</th>

                            <th>Escala</th>

                            <th>Peso</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($evaluationQuestions as $evaluationQuestion)

                            <tr>

                                <td>

                                    {{ $evaluationQuestion->evaluationType->name }}

                                </td>

                                <td>

                                    {{ $evaluationQuestion->category->name }}

                                </td>

                                <td>

                                    {{ $evaluationQuestion->competency->name }}

                                </td>

                                <td style="min-width:350px;">

                                    {{ $evaluationQuestion->question }}

                                </td>

                                <td>

                                    {{ $evaluationQuestion->scale->name }}

                                </td>

                                <td>

                                    {{ $evaluationQuestion->weight }}

                                </td>

                                <td>

                                    @if($evaluationQuestion->is_active)

                                        <span class="badge bg-success">

                                            Activo

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactivo

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route('evaluation-questions.show',$evaluationQuestion->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a
                                        href="{{ route('evaluation-questions.edit',$evaluationQuestion->id) }}"
                                        class="btn btn-sm btn-outline-warning">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('evaluation-questions.destroy',$evaluationQuestion->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        @if($evaluationQuestion->is_active)

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Desea desactivar esta pregunta?')">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('¿Desea reactivar esta pregunta?')">

                                                <i class="bi bi-check-circle"></i>

                                            </button>

                                        @endif

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center">

                                    No existen preguntas registradas.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection