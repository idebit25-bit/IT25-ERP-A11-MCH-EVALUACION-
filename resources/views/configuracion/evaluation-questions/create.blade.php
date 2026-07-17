@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nueva pregunta

        </h2>

        <a
            href="{{ route('evaluation-questions.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-questions.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-questions._form')

    </form>

</div>

@endsection