@extends('layouts.dashboard')

@section('title', 'Auditoría del Sistema')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Auditoría y Registros de Sesión
@endsection

@section('content')
    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Logins</h5>
                    <h2 class="mb-0">{{ number_format($stats['total_logins']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Logouts</h5>
                    <h2 class="mb-0">{{ number_format($stats['total_logouts']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Logins Hoy</h5>
                    <h2 class="mb-0">{{ number_format($stats['logins_hoy']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Activos Hoy</h5>
                    <h2 class="mb-0">{{ number_format($stats['usuarios_activos']) }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.auditoria.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="accion">Acción</label>
                        <select name="accion" id="accion" class="form-control">
                            <option value="">Todas</option>
                            <option value="login" {{ request('accion') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('accion') == 'logout' ? 'selected' : '' }}>Logout</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ip">IP Address</label>
                        <input type="text" name="ip" id="ip" class="form-control" value="{{ request('ip') }}" placeholder="192.168.1.1">
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_desde">Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_hasta">Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('admin.auditoria.index') }}" class="btn btn-secondary">Limpiar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de Logs --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Historial de Sesiones</h5>
        </div>
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Fecha/Hora</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->id_audit }}</td>
                                    <td>
                                        @if($log->user)
                                            <strong>{{ $log->user->nombre_usu }}</strong><br>
                                            <small class="text-muted">{{ $log->user->email }}</small><br>
                                            <span class="badge badge-secondary">
                                                {{ $log->payload_audit['rol'] ?? 'N/A' }}
                                            </span>
                                        @else
                                            <span class="text-muted">Usuario eliminado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->accion_audit == 'login')
                                            <span class="badge badge-success">
                                                <i class="fas fa-sign-in-alt"></i> Login
                                            </span>
                                        @elseif($log->accion_audit == 'logout')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </span>
                                        @else
                                            <span class="badge badge-info">{{ $log->accion_audit }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $log->ip_address ?? 'N/A' }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted" title="{{ $log->user_agent }}">
                                            {{ Str::limit($log->user_agent ?? 'N/A', 40) }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}<br>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if($log->accion_audit == 'logout' && isset($log->payload_audit['duracion_sesion_minutos']))
                                            <small class="text-muted">
                                                Duración: {{ $log->payload_audit['duracion_sesion_minutos'] }} min
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No se encontraron registros de auditoría con los filtros seleccionados.
                </div>
            @endif
        </div>
    </div>
@endsection
