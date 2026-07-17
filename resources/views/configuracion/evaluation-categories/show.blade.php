@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-categories.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            Información de la categoría

        </div>

        <div class="card-body">

            <p>

                <strong>Nombre:</strong><br>

                {{ $evaluationCategory->name }}

            </p>

            <p>

                <strong>Descripción:</strong><br>

                {{ $evaluationCategory->description }}

            </p>

            <p>

                <strong>Estado:</strong><br>

                @if($evaluationCategory->is_active)

                    <span class="badge bg-success">

                        Activo

                    </span>

                @else

                    <span class="badge bg-danger">

                        Inactivo

                    </span>

                @endif

            </p>

        </div>

    </div>

</div>

@endsection