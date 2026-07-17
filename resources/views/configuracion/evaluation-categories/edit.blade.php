@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Editar categoría

        </h2>

        <a
            href="{{ route('evaluation-categories.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-categories.update', $evaluationCategory->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        @include('configuracion.evaluation-categories._form')

    </form>

</div>

@endsection