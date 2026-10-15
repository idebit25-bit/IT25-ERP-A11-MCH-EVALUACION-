@php($description = app(\App\Services\ActivityDescriptionFormatter::class)->format($log->description))
@if(mb_strlen($description) > 350)
    <div class="text-break">{{ \Illuminate\Support\Str::limit(strtok($description, "\n") ?: $description, 180) }}</div>
    <details class="mt-2">
        <summary class="text-primary">Ver detalles del movimiento</summary>
        <div class="small text-break mt-2" style="white-space: pre-wrap">{{ $description }}</div>
    </details>
@else
    <div class="text-break" style="white-space: pre-wrap">{{ $description }}</div>
@endif
