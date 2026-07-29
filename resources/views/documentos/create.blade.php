@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>Nuevo Documento</h1>

        <p>Registro de un nuevo documento.</p>

    </div>

    <div class="card border-0 table-card">

        <div class="card-body">

            <form
                action="{{ url('/documentos') }}"
                method="POST"
            >

                @csrf

                @include('documentos._form')

            </form>

        </div>

    </div>

</div>

@endsection