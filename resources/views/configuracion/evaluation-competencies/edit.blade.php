@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Editar competencia

        </h2>

        <a
            href="{{ route('evaluation-competencies.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-competencies.update', $evaluationCompetency->id) }}"
        method="POST">

        @csrf

        @method('PUT')

        @include('configuracion.evaluation-competencies._form')

    </form>

</div>

@endsection