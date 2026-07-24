@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Encabezado -->

    <div class="mb-4">

        <h1 class="fw-bold">
            Nueva Evaluación
        </h1>

        <p class="text-muted">
            Registro de una nueva evaluación dentro del sistema.
        </p>

    </div>

    <!-- Formulario -->

    <div class="card shadow-sm border-0">

        <div class="card-body">

            
            
            <form
                action="{{ route('evaluaciones.store') }}"
                method="POST"
            >
            
                @csrf
            
                @include('evaluaciones._form')
            
            </form>
        </div>

    </div>

</div>

@endsection