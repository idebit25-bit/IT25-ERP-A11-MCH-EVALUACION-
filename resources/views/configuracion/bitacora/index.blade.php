@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">

                Bitácora del Sistema

            </h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Fecha</th>

                            <th>Usuario</th>

                            <th>Módulo</th>

                            <th>Acción</th>

                            <th>Descripción</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($logs as $log)

                            <tr>

                                <td>

                                    {{ $log->created_at->format('d/m/Y H:i') }}

                                </td>

                                
                                <td>
                                
                                    {{
                                        trim(
                                            ($log->user?->first_name ?? '') . ' ' .
                                            ($log->user?->paternal_surname ?? '')
                                        ) ?: 'Sistema'
                                    }}
                                
                                </td>
                                <td>

                                    {{ $log->module }}

                                </td>

                                
                                <td>
                                
                                    @switch($log->action)
                                
                                        @case('Crear')
                                
                                            <span class="badge bg-success">
                                
                                                Crear
                                
                                            </span>
                                
                                            @break
                                
                                        @case('Actualizar')
                                
                                            <span class="badge bg-primary">
                                
                                                Actualizar
                                
                                            </span>
                                
                                            @break
                                
                                        @case('Desactivar')
                                
                                            <span class="badge bg-danger">
                                
                                                Desactivar
                                
                                            </span>
                                
                                            @break
                                
                                        @case('Activar')
                                
                                            <span class="badge bg-success">
                                
                                                Activar
                                
                                            </span>
                                
                                            @break
                                
                                        @case('Iniciar sesión')
                                
                                            <span class="badge bg-info text-dark">
                                
                                                Iniciar sesión
                                
                                            </span>
                                
                                            @break
                                
                                        @case('Cerrar sesión')
                                
                                            <span class="badge bg-secondary">
                                
                                                Cerrar sesión
                                
                                            </span>
                                
                                            @break
                                
                                        @default
                                
                                            <span class="badge bg-dark">
                                
                                                {{ $log->action }}
                                
                                            </span>
                                
                                    @endswitch
                                
                                </td>
                                <td>

                                    @include('configuracion.bitacora.description', ['log' => $log])

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    No existen registros.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $logs->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
