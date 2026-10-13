@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="dashboard-header"><h1>Editar Documento</h1><p>Actualiza los datos o reemplaza el archivo PDF.</p></div>
    <div class="card border-0 table-card"><div class="card-body">
        <form action="{{ url('/documentos/'.$documento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('documentos._form')
        </form>
    </div></div>
</div>
@endsection
