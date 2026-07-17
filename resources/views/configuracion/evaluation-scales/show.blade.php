@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-scales.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            Información de la escala

        </div>

        <div class="card-body">

            <p>

                <strong>Nombre:</strong><br>

                {{ $evaluationScale->name }}

            </p>

            <p>

                <strong>Descripción:</strong><br>

                {{ $evaluationScale->description }}

            </p>

            <p>

                <strong>Estado:</strong><br>

                @if($evaluationScale->is_active)

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