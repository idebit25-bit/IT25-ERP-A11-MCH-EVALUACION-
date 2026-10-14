@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <a class="btn btn-outline-secondary mb-4" href="{{ route('reportes.history', ['user_id' => $evaluation->user_id]) }}">Volver al historial</a>
    <div class="dashboard-header"><h1>Evaluación #{{ $evaluation->id }}</h1><p>Consulta del historial de {{ $evaluation->user?->full_name }}.</p></div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Plantilla</dt><dd class="col-sm-9">{{ $evaluation->template?->name ?? 'No disponible' }}</dd>
            <dt class="col-sm-3">Tipo</dt><dd class="col-sm-9">{{ $evaluation->evaluationType?->name ?? 'No disponible' }}</dd>
            <dt class="col-sm-3">Periodo</dt><dd class="col-sm-9">{{ $evaluation->period?->name ?? 'Sin periodo' }}</dd>
            <dt class="col-sm-3">Evaluador</dt><dd class="col-sm-9">{{ $evaluation->evaluator?->full_name ?? 'Sin evaluador' }}</dd>
            <dt class="col-sm-3">Estado</dt><dd class="col-sm-9">{{ $evaluation->publication_label }}</dd>
        </dl>
    </div></div>
    @if($evaluation->status === 'completed')
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5">Respuestas registradas</h2>
            @unless($evaluation->comparison_snapshot)<p class="text-muted">Registro anterior sin copia de las preguntas y escalas. Los enunciados disponibles corresponden al catálogo actual; no se utiliza para comparar evolución.</p>@endunless
            @foreach($evaluation->answers as $answer)
                <p><strong>{{ collect($evaluation->comparison_snapshot['questions'] ?? [])->firstWhere('id', $answer->question_id)['text'] ?? $answer->question?->question ?? 'Pregunta no disponible' }}</strong><br>{{ $answer->answer }}</p>
            @endforeach
            <p><strong>Promedio registrado:</strong> {{ number_format($evaluation->total_score, 2) }}</p>
            <p><strong>Observaciones del colaborador:</strong> {{ $evaluation->observations ?: 'Sin observaciones' }}</p>
            <p><strong>Revisión del evaluador:</strong> {{ $evaluation->review_notes ?: 'Sin revisión registrada' }}</p>
            <p class="text-muted mb-0">{{ $evaluation->published_at ? 'Resultado publicado.' : 'Resultado aún no publicado al colaborador.' }}</p>
        </div></div>
    @else
        <div class="alert alert-info">Esta evaluación no tiene un resultado completado para consultar.</div>
    @endif
</div>
@endsection
