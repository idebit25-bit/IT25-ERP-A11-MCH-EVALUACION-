@php
    $manages = auth()->user()->hasModulePermission('evaluaciones.gestionar');
    $stage = 0;
    $blocked = false;
    $target = null;
    $button = null;
    $owner = $evaluation->user?->full_name ?? 'Colaborador sin asignar';
    $heading = 'Pendiente de respuesta';
    $help = 'El colaborador evaluado debe responder y enviar la evaluación. Después podrá revisarla el evaluador.';
    if (in_array($evaluation->status, ['draft', 'in_progress'])) {
        if (! $ready) {
            $blocked = true;
            $heading = 'La plantilla necesita ajustes';
            $owner = 'Administrador con permiso de catálogos';
            $help = 'Faltan preguntas compatibles u opciones activas. Solicita revisar la plantilla antes de responder.';
        } elseif ($evaluation->user?->status !== 'active') {
            $blocked = true;
            $heading = 'El colaborador tiene la cuenta inactiva';
            $owner = 'Administrador autorizado';
            $help = 'Revisa la situación del colaborador antes de continuar. Una cuenta inactiva no puede enviar respuestas.';
        } elseif ($canRespond) {
            $help = 'Es tu turno. Responde las preguntas y revisa tus selecciones antes de enviarlas.';
            $target = '#evaluation-response'; $button = 'Ir a responder';
        }
    } elseif ($evaluation->status === 'completed') {
        if (! $evaluation->reviewed_at && $evaluation->answers->isEmpty()) {
            $stage = 1; $blocked = true;
            $heading = 'Faltan las respuestas de esta evaluación';
            $owner = 'Super Admin';
            $help = 'El registro figura como completado, pero no tiene respuestas guardadas. Debe reabrirse con un motivo para que el colaborador pueda responder.';
            if (auth()->user()->hasAccessRole('Super Admin')) { $target = '#evaluation-reopen'; $button = 'Ir a reabrir'; }
        } elseif (! $evaluation->reviewed_at) {
            $stage = 1;
            $heading = 'Pendiente de revisión';
            $owner = $evaluation->evaluator?->full_name ?? 'Evaluador sin asignar';
            $help = 'El evaluador asignado debe consultar las respuestas y registrar sus observaciones. El colaborador ya terminó su parte.';
            if ($evaluation->evaluator?->status !== 'active') {
                $blocked = true;
                $help = 'El evaluador no tiene una cuenta activa. Solicita al administrador revisar su acceso para continuar.';
            } elseif (auth()->id() == $evaluation->evaluator_id) { $target = '#evaluation-review'; $button = 'Ir a revisar'; }
        } elseif (! $evaluation->validated_at) {
            $stage = 2;
            $heading = 'Pendiente de validación';
            $owner = 'Administrador con permiso de evaluaciones';
            $help = 'La revisión está lista. Un administrador debe comprobar las respuestas y observaciones antes de autorizar la publicación.';
            if ($manages) { $target = '#evaluation-validate'; $button = 'Ir a validar'; }
        } elseif (! $evaluation->published_at) {
            $stage = 3;
            $heading = 'Lista para publicar';
            $owner = 'Administrador con permiso de evaluaciones';
            $help = 'El resultado fue validado. Falta publicarlo para que el colaborador pueda consultar su calificación y las observaciones.';
            if ($manages) { $target = '#evaluation-publish'; $button = 'Ir a publicar'; }
        } else {
            $stage = 4;
            $heading = 'Resultado publicado';
            $owner = null;
            $help = 'El proceso de evaluación terminó. El colaborador ya puede consultar su resultado; el seguimiento mediante un plan de mejora es opcional.';
            if ($canSeeResults) { $target = '#evaluation-results'; $button = 'Ver resultado'; }
        }
    } else {
        $stage = -1; $blocked = true;
        $heading = $evaluation->status === 'cancelled' ? 'Evaluación cancelada' : 'Estado pendiente de comprobar';
        $owner = null;
        $help = 'No hay una acción disponible en este estado. Consulta al administrador si necesitas continuar el proceso.';
    }
@endphp
<section class="card border-0 shadow-sm mb-4" aria-labelledby="evaluation-next-title">
    <div class="card-body">
        @if($stage >= 0)
            <ol class="list-unstyled d-flex flex-wrap gap-2 mb-3" aria-label="Etapas de la evaluación">
                @foreach(['Responder', 'Revisar', 'Validar', 'Publicar'] as $index => $label)
                    <li class="badge rounded-pill px-3 py-2 {{ $index < $stage ? 'bg-success-subtle text-success-emphasis' : ($index === $stage ? ($blocked ? 'text-bg-warning' : 'text-bg-primary') : 'text-bg-light border') }}" @if($index === $stage) aria-current="step" @endif>
                        {{ $index + 1 }}. {{ $label }} @if($index < $stage)<i class="bi bi-check2" aria-hidden="true"></i><span class="visually-hidden">Completada</span>@endif
                    </li>
                @endforeach
            </ol>
        @endif
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <div>
                <h2 class="h5" id="evaluation-next-title">{{ $heading }}</h2>
                @if($owner)<p class="mb-2"><strong>Siguiente responsable:</strong> {{ $owner }}</p>@endif
                <p class="text-muted mb-0">{{ $help }}</p>
            </div>
            @if($target)<a class="btn btn-primary flex-shrink-0" href="{{ $target }}">{{ $button }} <i class="bi bi-arrow-down" aria-hidden="true"></i></a>@endif
        </div>
    </div>
</section>
