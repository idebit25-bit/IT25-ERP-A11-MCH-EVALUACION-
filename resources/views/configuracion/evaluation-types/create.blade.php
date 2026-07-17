@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nuevo tipo de evaluación

        </h2>

        <a
            href="{{ route('evaluation-types.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-types.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-types._form')

    </form>

</div>

@endsection