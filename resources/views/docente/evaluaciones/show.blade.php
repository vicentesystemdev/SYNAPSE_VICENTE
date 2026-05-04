@extends('layouts.dashboard')

@section('title', 'Detalle de Evaluación')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    {{ $evaluacion->titulo_eval }}
                </h1>
                @php
                    $estado = $evaluacion->estado_eval;
                    $claseEstado = match ($estado) {
                        2 => 'bg-emerald-100 text-emerald-700 border-emerald-300',
                        1 => 'bg-amber-100 text-amber-700 border-amber-300',
                        0 => 'bg-gray-100 text-gray-700 border-gray-300',
                        default => 'bg-gray-100 text-gray-700 border-gray-300',
                    };
                    $textoEstado = match ($estado) {
                        2 => 'Publicada',
                        1 => 'Borrador',
                        0 => 'Archivada',
                        default => 'Desconocido',
                    };
                @endphp
                <span class="rounded-md border px-2.5 py-0.5 text-xs font-medium {{ $claseEstado }}">
                    {{ $textoEstado }}
                </span>
            </div>
            <p class="text-sm text-gray-600 font-mono">
                ID: #{{ str_pad($evaluacion->id_eval, 3, '0', STR_PAD_LEFT) }} · 
                Área: {{ $evaluacion->categoria->nombre_cat ?? 'Sin Área' }} · 
                Nivel de dificultad: {{ $evaluacion->dificultad->nombre_dif ?? 'Sin Nivel de dificultad' }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('docente.evaluaciones.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Volver
            </a>
            <a href="{{ route('docente.evaluaciones.edit', $evaluacion) }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition">
                Editar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        
        <!-- COLUMNA IZQUIERDA: Detalles -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Descripción -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                    Descripción del Reto
                </h3>
                <div class="prose prose-sm max-w-none text-gray-600">
                    {{ $evaluacion->descripcion_eval }}
                </div>
            </div>

            <!-- Intentos Recientes -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-800">Últimos Intentos</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Respuesta Enviada</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Resultado</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($intentosRecientes as $intento)
                                <tr>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-900 font-medium">
                                        {{ $intento->user->name ?? 'Usuario Eliminado' }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap font-mono text-gray-600">
                                        {{ Str::limit($intento->flag_ingresada_int, 20) }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        @if($intento->es_correcto_int)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Correcto
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Incorrecto
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-500">
                                        {{ $intento->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No hay intentos registrados aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- COLUMNA DERECHA: Estadísticas -->
        <div class="space-y-6">
            
            <!-- Info Técnica -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                    Información Técnica
                </h3>
                
                <dl class="space-y-3 text-xs">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Respuesta Correcta:</dt>
                        <dd class="font-mono font-medium text-gray-900">{{ $evaluacion->flag_hash_eval }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Puntaje Base:</dt>
                        <dd class="font-medium text-gray-900">{{ $evaluacion->puntaje_base_eval }} pts</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Creado por:</dt>
                        <dd class="font-medium text-gray-900">{{ $evaluacion->docente->name ?? 'N/D' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Fecha Inicio:</dt>
                        <dd class="text-gray-900">{{ $evaluacion->fecha_inicio_eval ? $evaluacion->fecha_inicio_eval->format('d/m/Y H:i') : 'No definida' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Fecha Fin:</dt>
                        <dd class="text-gray-900">{{ $evaluacion->fecha_fin_eval ? $evaluacion->fecha_fin_eval->format('d/m/Y H:i') : 'No definida' }}</dd>
                    </div>
                    @if($evaluacion->archivo_adjunto)
                    <div class="flex justify-between border-t border-gray-100 pt-2 mt-2">
                        <dt class="text-gray-500">Recurso:</dt>
                        <dd>
                            <a href="{{ asset('storage/' . $evaluacion->archivo_adjunto) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">
                                <i class="fas fa-download mr-1"></i> Descargar Archivo
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Resumen de Actividad -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                    Resumen de Actividad
                </h3>
                
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase">Total Intentos</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $evaluacion->intentos()->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase">Correctos</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $evaluacion->intentos()->where('es_correcto_int', 1)->count() }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
