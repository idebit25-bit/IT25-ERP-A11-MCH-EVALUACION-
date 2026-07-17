@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nueva categoría

        </h2>

        <a
            href="{{ route('evaluation-categories.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-categories.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-categories._form')

    </form>

</div>

@endsection