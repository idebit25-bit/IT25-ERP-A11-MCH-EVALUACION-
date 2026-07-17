@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nueva escala

        </h2>

        <a
            href="{{ route('evaluation-scales.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-scales.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-scales._form')

    </form>

</div>

@endsection