@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nueva plantilla

        </h2>

        <a
            href="{{ route('evaluation-templates.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-templates.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-templates._form')

    </form>

</div>

@endsection