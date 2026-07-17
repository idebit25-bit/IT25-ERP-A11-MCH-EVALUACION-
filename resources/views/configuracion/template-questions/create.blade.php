@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>

            Agregar preguntas

        </h1>

        <p>

            {{ $evaluationTemplate->name }}

        </p>

    </div>

    <a
        href="{{ route('template-questions.index', $evaluationTemplate->id) }}"
        class="btn btn-secondary mb-3">

        Regresar

    </a>

    <div class="card">

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Pregunta</th>

                        <th>Categoría</th>

                        <th>Competencia</th>

                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($availableQuestions as $question)

                        <tr>

                            <td>

                                {{ $question->question }}

                            </td>

                            <td>

                                {{ $question->category->name }}

                            </td>

                            <td>

                                {{ $question->competency->name }}

                            </td>

                            <td>

                                <form
    action="{{ route('template-questions.store', [$evaluationTemplate->id, $question->id]) }}"
    method="POST">

    @csrf

    <button
        type="submit"
        class="btn btn-success btn-sm">

        <i class="bi bi-plus-circle"></i>

    </button>

</form>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center">

                                No existen preguntas disponibles.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection