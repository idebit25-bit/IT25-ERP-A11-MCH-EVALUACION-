@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nueva competencia

        </h2>

        <a
            href="{{ route('evaluation-competencies.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-competencies.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-competencies._form')

    </form>

</div>

@endsection