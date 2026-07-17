@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Editar escala

        </h2>

        <a
            href="{{ route('evaluation-scales.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-scales.update', $evaluationScale->id) }}"
        method="POST">

        @csrf

        @method('PUT')

        @include('configuracion.evaluation-scales._form')

    </form>

</div>

@endsection