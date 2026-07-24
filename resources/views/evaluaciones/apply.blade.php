@extends('layouts.app')

@section('title', 'Aplicar Evaluación')

@section('content')

<div class="container">

    <h2 class="mb-4">Aplicar Evaluación</h2>


    <div class="card">
        <div class="card-body">

            <h5>Información General</h5>

            <hr>

            <p>
                <strong>Colaborador:</strong>
                {{ $evaluation->user->first_name }}
                {{ $evaluation->user->paternal_surname }}
                {{ $evaluation->user->maternal_surname }}
            </p>

            <p>
                <strong>Evaluador:</strong>
                {{ $evaluation->evaluator->first_name }}
                {{ $evaluation->evaluator->paternal_surname }}
                {{ $evaluation->evaluator->maternal_surname }}               
            </p>

            <p>
                <strong>Periodo:</strong>
                {{ $evaluation->period->name }}
            </p>

            
            <p>
    <strong>Tipo de evaluación:</strong>
    {{ $evaluation->evaluationType->name }}
</p>

<hr>

<form
    action="{{ route('evaluaciones.submit', $evaluation->id) }}"
    method="POST">

    @csrf

<h4 class="mt-4 mb-3">
    Preguntas de la Evaluación
</h4>

@foreach ($evaluation->template->questions as $question)

    <div class="card mb-3">

<div class="card-body">

    <h5>
        {{ $question->pivot->order_number }}.
        {{ $question->question }}
    </h5>

    <p class="mb-1">
        <strong>Categoría:</strong>
        {{ $question->category->name }}
    </p>

    <p class="mb-0">
        <strong>Competencia:</strong>
        {{ $question->competency->name }}
    </p>

    @if ($question->question_type === 'radio')
        @include('evaluaciones.questions.radio')
    @endif

 </div>

</div>

@endforeach

<div class="mb-4">

    <label
        for="observations"
        class="form-label">

        Observaciones finales

    </label>

    <textarea
        name="observations"
        id="observations"
        class="form-control"
        rows="5"
        placeholder="Escriba las observaciones generales de la evaluación..."></textarea>

</div>

<div class="mt-4">

    <button
        type="submit"
        class="btn btn-primary">

        Guardar evaluación

    </button>

</div>

</form>

        </div>
    </div>

</div>

@endsection