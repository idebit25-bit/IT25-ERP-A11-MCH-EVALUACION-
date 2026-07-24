@extends('layouts.app')

@section('title', 'Editar Evaluación')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Editar evaluación</h2>

        <a
            href="{{ route('evaluaciones.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluaciones.update', $evaluation->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        @include('evaluaciones._form')

    </form>

</div>

@endsection