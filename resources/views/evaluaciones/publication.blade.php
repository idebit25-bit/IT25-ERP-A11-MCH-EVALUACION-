@if($evaluation->status === 'completed')
    <div class="card mt-4"><div class="card-body">
        <h2 class="h5">Revisión y publicación</h2>
        <p class="mb-3">{{ $evaluation->publication_label }}</p>
        @if($canReview)
            <ol class="mb-3">
                <li>Revisión: {{ $evaluation->reviewed_at ? $evaluation->reviewer?->full_name.' · '.\Carbon\Carbon::parse($evaluation->reviewed_at)->format('d/m/Y H:i') : 'Pendiente del evaluador asignado' }}</li>
                <li>Validación: {{ $evaluation->validated_at ? $evaluation->validator?->full_name.' · '.\Carbon\Carbon::parse($evaluation->validated_at)->format('d/m/Y H:i') : 'Pendiente' }}</li>
                <li>Publicación: {{ $evaluation->published_at ? $evaluation->publisher?->full_name.' · '.\Carbon\Carbon::parse($evaluation->published_at)->format('d/m/Y H:i') : 'Pendiente' }}</li>
            </ol>
        @endif
        @if($canSeeResults && $evaluation->reviewed_at)
            <h3 class="h6">Observaciones del evaluador</h3>
            <p class="text-break" style="white-space: pre-wrap">{{ $evaluation->review_notes }}</p>
        @endif
        @if(!$canReview && !$evaluation->published_at)
            <p class="text-muted mb-0">Recibirás una notificación cuando tu resultado esté publicado. Por ahora no necesitas realizar ninguna acción.</p>
        @endif

        @if(auth()->id() == $evaluation->evaluator_id && !$evaluation->reviewed_at)
            <form action="{{ route('mis-evaluaciones.review', $evaluation->id) }}" method="POST" onsubmit="return confirm('¿Confirmar la revisión y enviarla a validación?');">
                @csrf
                <label for="review-notes" class="form-label">Observaciones de la revisión</label>
                <textarea id="review-notes" name="review_notes" class="form-control mb-2" required maxlength="2000" rows="4" aria-describedby="review-help">{{ old('review_notes') }}</textarea>
                <p id="review-help" class="form-text">Estas observaciones serán visibles para el colaborador cuando se publique el resultado.</p>
                @error('review_notes')<p class="text-danger" role="alert">{{ $message }}</p>@enderror
                <button class="btn btn-primary" type="submit">Confirmar revisión</button>
            </form>
        @endif
        @if(auth()->user()->hasModulePermission('evaluaciones.gestionar'))
            @if($evaluation->reviewed_at && !$evaluation->validated_at)
                <form action="{{ route('mis-evaluaciones.validate', $evaluation->id) }}" method="POST" onsubmit="return confirm('¿Validar las respuestas y observaciones revisadas?');">
                    @csrf
                    <button class="btn btn-primary" type="submit">Validar resultado</button>
                </form>
            @elseif($evaluation->validated_at && !$evaluation->published_at)
                <form action="{{ route('mis-evaluaciones.publish', $evaluation->id) }}" method="POST" onsubmit="return confirm('¿Publicar el resultado? El colaborador podrá consultar su calificación y las observaciones.');">
                    @csrf
                    <button class="btn btn-success" type="submit">Publicar resultado</button>
                </form>
            @endif
        @endif
    </div></div>
@endif
