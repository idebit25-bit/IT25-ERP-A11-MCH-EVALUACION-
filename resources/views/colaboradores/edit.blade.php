@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Editar colaborador</h2>

        <a href="{{ route('colaboradores.index') }}"
           class="btn btn-secondary">

            Regresar

        </a>

    </div>

    <form
        action="{{ route('colaboradores.update', $user->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('colaboradores._form')

    </form>

</div>

@endsection