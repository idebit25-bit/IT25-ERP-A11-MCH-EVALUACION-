@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>

            {{ $evaluationTemplate->name }}

        </h1>

        <p>

            Administración de preguntas de la plantilla.

        </p>

    </div>

    <div class="card">

        <div class="card-body">

            <a
                href="{{ route('template-questions.create', $evaluationTemplate->id) }}"
                class="btn btn-primary mb-3">

                <i class="bi bi-plus-circle"></i>

                Agregar pregunta

            </a>

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Orden</th>

                        <th>Pregunta</th>

                        <th>Peso</th>

                        <th>Obligatoria</th>

                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

@forelse($templateQuestions as $templateQuestion)

    <tr>

        <td>

            {{ $templateQuestion->order_number }}

        </td>

        <td>

            {{ $templateQuestion->question->question }}

        </td>

        <td>

            {{ $templateQuestion->weight }}

        </td>

        <td>

            {{ $templateQuestion->is_required ? 'Sí' : 'No' }}

        </td>

<td>

    <a
        href="{{ route('template-questions.edit', [$evaluationTemplate->id, $templateQuestion->id]) }}"
        class="btn btn-sm btn-outline-warning">

        <i class="bi bi-pencil-square"></i>

    </a>

    <form
        action="{{ route('template-questions.destroy', [$evaluationTemplate->id, $templateQuestion->id]) }}"
        method="POST"
        class="d-inline">

        @csrf

        @method('DELETE')

        <button
            type="submit"
            class="btn btn-sm btn-outline-danger"
            onclick="return confirm('¿Desea eliminar esta pregunta de la plantilla?')">

            <i class="bi bi-trash"></i>

        </button>

    </form>

</td>

    </tr>

@empty

    <tr>

        <td colspan="5" class="text-center">

            Esta plantilla aún no tiene preguntas.

        </td>

    </tr>

@endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection