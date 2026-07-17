@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Nuevo período de evaluación

        </h2>

        <a
            href="{{ route('evaluation-periods.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-periods.store') }}"
        method="POST">

        @csrf

        @include('configuracion.evaluation-periods._form')

    </form>

</div>

@endsection