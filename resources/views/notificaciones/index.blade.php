@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h2>Notificaciones</h2>
    <form method="POST" action="{{ route('notificaciones.readAll') }}">
        @csrf @method('PATCH')
        <button class="btn btn-outline-secondary" type="submit">Marcar todas como leídas</button>
    </form>
</div>
<div class="card">
    <div class="list-group list-group-flush">
        @forelse($notifications as $notification)
            <div class="list-group-item p-3">
                <p class="mb-1 {{ $notification->read_at ? '' : 'fw-bold' }}">{{ $notification->data['message'] ?? 'Aviso del sistema' }}</p>
                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                @if(isset($notification->data['plan_id']))
                    <a class="d-block mt-2" href="{{ route('planes.show', $notification->data['plan_id']) }}">Consultar plan de mejora</a>
                @elseif(isset($notification->data['evaluation_id']))
                    <a class="d-block mt-2" href="{{ route('mis-evaluaciones.show', $notification->data['evaluation_id']) }}">Consultar evaluación</a>
                @endif
                @unless($notification->read_at)
                    <form class="mt-2" method="POST" action="{{ route('notificaciones.read', $notification->id) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-secondary btn-sm" type="submit">Marcar como leída</button>
                    </form>
                @endunless
            </div>
        @empty
            <p class="p-3 mb-0 text-muted">No tienes notificaciones.</p>
        @endforelse
    </div>
</div>
<div class="mt-3">{{ $notifications->links() }}</div>
@endsection
