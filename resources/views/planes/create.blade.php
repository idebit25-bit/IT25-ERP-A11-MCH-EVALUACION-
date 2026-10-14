@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="dashboard-header"><h1>Nuevo plan de mejora</h1><p>Convierte un resultado publicado en acciones con responsables y fechas compromiso.</p></div>
    <a class="btn btn-outline-secondary mb-4" href="{{ route('planes.index') }}">Volver a planes</a>
    @if($evaluations->isEmpty())
        <div class="alert alert-info">No hay evaluaciones publicadas sin plan. Publica un resultado o consulta los planes existentes. Cada evaluación admite un plan con varias acciones.</div>
    @else
        <form class="card border-0 shadow-sm" method="POST" action="{{ route('planes.store') }}"><div class="card-body">
            @csrf
            <label class="form-label" for="evaluation-id">Evaluación de origen</label>
            <select class="form-select mb-3" id="evaluation-id" name="evaluation_id" required><option value="">Selecciona una evaluación publicada</option>@foreach($evaluations as $evaluation)<option value="{{ $evaluation->id }}" @selected(old('evaluation_id', request('evaluation_id')) == $evaluation->id)>#{{ $evaluation->id }} · {{ $evaluation->user?->full_name }} · {{ $evaluation->template?->name }} · {{ $evaluation->period?->name }}</option>@endforeach</select>
            <label class="form-label" for="plan-title">Nombre del plan</label><input class="form-control mb-3" id="plan-title" name="title" required maxlength="180" value="{{ old('title') }}" placeholder="Ej. Fortalecer el cumplimiento de procedimientos">
            <label class="form-label" for="plan-objective">Objetivo de mejora</label><textarea class="form-control mb-4" id="plan-objective" name="objective" rows="3" maxlength="3000" required>{{ old('objective') }}</textarea>
            <h2 class="h5">Primera acción</h2>
            @include('planes._action-fields', ['action' => null, 'formKey' => 'create'])
            <p class="text-muted small">Después puedes agregar más acciones. El colaborador y los responsables podrán consultar el plan; cada responsable registrará avances en sus acciones.</p>
            <button class="btn btn-primary" type="submit">Crear plan de mejora</button>
        </div></form>
    @endif
</div>
@endsection
