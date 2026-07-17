@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Editar plantilla

        </h2>

        <a
            href="{{ route('evaluation-templates.index') }}"
            class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('evaluation-templates.update',$evaluationTemplate->id) }}"
        method="POST">

        @csrf

        @method('PUT')

        @include('configuracion.evaluation-templates._form')

    </form>

</div>

@endsection