@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <a href="{{ route('mis-evaluaciones.index') }}" class="btn btn-outline-secondary mb-3">Volver a mis evaluaciones</a>
    <div class="dashboard-header">
        <h1>Evaluación #{{ $evaluation->id }}</h1>
        <p>{{ $evaluation->evaluationType?->name }} · {{ $evaluation->publication_label }}</p>
    </div>
    <div class="card mb-4"><div class="card-body">
        <p><strong>Colaborador:</strong> {{ $evaluation->user?->full_name }}</p>
        <p><strong>Evaluador:</strong> {{ $evaluation->evaluator?->full_name }}</p>
        <p class="mb-0"><strong>Periodo:</strong> {{ $evaluation->period?->name }}</p>
    </div></div>

    @if($canRespond && $ready)
        <div class="alert alert-info">Responde las preguntas y revisa tus selecciones antes de enviar. Las preguntas con * son obligatorias. Después del envío, necesitarás una reapertura para corregirlas.</div>
        <form method="POST" action="{{ route('mis-evaluaciones.submit', $evaluation->id) }}" onsubmit="return confirm('¿Confirmas que deseas enviar tus respuestas? Después no podrás modificarlas sin una reapertura.');">
            @csrf
            @foreach($questions as $question)
                @php
                    $previous = $evaluation->answers->firstWhere('question_id', $question->id);
                    $previousValue = $previous ? $question->scale->values->first(fn ($v) => $v->label === $previous->answer && (float) $v->numeric_value === (float) $previous->numeric_value)?->id : null;
                @endphp
                <fieldset class="card mb-3 p-3">
                    <legend class="fs-5">{{ $loop->iteration }}. {{ $question->question }} {{ $question->pivot->is_required ? '*' : '(opcional)' }}</legend>
                    @if($question->help_text)<p class="text-muted">{{ $question->help_text }}</p>@endif
                    @foreach($question->scale->values->where('is_active', true)->sortBy('display_order') as $value)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}v{{ $value->id }}" value="{{ $value->id }}" @checked(old('answers.'.$question->id, $previousValue) == $value->id) @required($question->pivot->is_required)>
                            <label class="form-check-label" for="q{{ $question->id }}v{{ $value->id }}">{{ $value->label }}</label>
                        </div>
                    @endforeach
                    @error('answers.'.$question->id)<p class="text-danger mt-2 mb-0" role="alert">{{ $message }}</p>@enderror
                </fieldset>
            @endforeach
            <label class="form-label" for="observations">Observaciones (opcional)</label>
            <textarea class="form-control mb-3" name="observations" id="observations" maxlength="1000" rows="3">{{ old('observations', $evaluation->observations) }}</textarea>
            <button class="btn btn-primary" type="submit">Enviar respuestas</button>
        </form>
    @elseif($canRespond)
        <div class="alert alert-warning">La plantilla aún no está lista para responder. Contacta al evaluador para que revise las preguntas y sus opciones.</div>
    @else
        <div class="alert alert-info">{{ $evaluation->status === 'completed' ? 'Las respuestas fueron enviadas. La evaluación está cerrada para cambios.' : ($evaluation->status === 'cancelled' ? 'Esta evaluación está cancelada.' : 'El colaborador evaluado es quien debe responder. Puedes consultar aquí su estado y revisar sus respuestas cuando las envíe.') }}</div>
        @if($canSeeResults && $evaluation->status === 'completed')
            <div class="card"><div class="card-body">
                <h2 class="h5">Respuestas del colaborador</h2>
                @foreach($evaluation->answers as $answer)
                    <p><strong>{{ collect($evaluation->comparison_snapshot['questions'] ?? [])->firstWhere('id', $answer->question_id)['text'] ?? $answer->question?->question ?? 'Pregunta registrada' }}</strong><br>{{ $answer->answer }}</p>
                @endforeach
                <p><strong>Promedio registrado:</strong> {{ number_format($evaluation->total_score, 2) }}</p>
                <p><strong>Observaciones:</strong> {{ $evaluation->observations ?: 'Sin observaciones' }}</p>
            </div></div>
        @endif
    @endif

    @include('evaluaciones.publication')

    @if($evaluation->status === 'completed' && $evaluation->published_at && auth()->user()->hasModulePermission('evaluaciones.gestionar'))
        <a class="btn btn-outline-primary mt-4" href="{{ route('planes.create', ['evaluation_id' => $evaluation->id]) }}"><i class="bi bi-list-check"></i> Crear plan de mejora</a>
    @endif
    <a class="btn btn-outline-secondary mt-4" href="{{ route('planes.index', ['evaluation_id' => $evaluation->id]) }}">Consultar planes de esta evaluación</a>

    @if(auth()->user()->hasAccessRole('Super Admin') && $evaluation->status === 'completed')
        <form class="card p-3 mt-4" method="POST" action="{{ route('mis-evaluaciones.reopen', $evaluation->id) }}" onsubmit="return confirm('¿Reabrir esta evaluación para que el colaborador corrija sus respuestas?');">
            @csrf
            <h2 class="h5">Reabrir evaluación</h2>
            <p>Se conservará en la bitácora una copia de las respuestas y la calificación anteriores, junto con el responsable y el motivo.</p>
            <label class="form-label" for="reason">Motivo de la reapertura</label>
            <textarea class="form-control mb-3" id="reason" name="reason" required minlength="10" maxlength="1000">{{ old('reason') }}</textarea>
            @error('reason')<p class="text-danger">{{ $message }}</p>@enderror
            <button class="btn btn-outline-warning align-self-start" type="submit">Reabrir para corrección</button>
        </form>
    @endif
</div>
@endsection
