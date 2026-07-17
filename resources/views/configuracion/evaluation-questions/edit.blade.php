@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Editar pregunta

        </h2>

        <a
            href="{{ route('evaluation-questions.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-questions.update', $evaluationQuestion->id) }}"
        method="POST">

        @csrf

        @method('PUT')

        @include('configuracion.evaluation-questions._form')

    </form>

</div>

@endsection