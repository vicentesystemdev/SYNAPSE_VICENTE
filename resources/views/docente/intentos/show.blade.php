@extends('layouts.dashboard')

@section('title', 'Detalles del Intento #' . $intento->id_int)

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detalles del Intento #{{ $intento->id_int }}</h1>
        <a href="{{ route('docente.intentos.exportPdfShow', $intento->id_int) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información Completa del Intento</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="fas fa-info-circle mr-1"></i> Datos Generales del Intento</h4>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>ID de Intento:</b> <span class="float-right">{{ $intento->id_int }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Estudiante:</b> <span class="float-right">{{ $intento->user->name }} {{ $intento->user->app_usu }} {{ $intento->user->apm_usu ?? '' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Correo Estudiante:</b> <span class="float-right">{{ $intento->user->email }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Evaluación:</b> <span class="float-right">{{ $intento->evaluacion->titulo_eval }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Categoría:</b> <span class="float-right">{{ $intento->evaluacion->categoria->nombre_cat ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Nro. de Intento:</b> <span class="float-right">{{ $intento->nro_intento_int }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Respuesta Enviada:</b> <span class="float-right font-italic">{{ $intento->respuesta_flag_int }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Resultado:</b> <span class="float-right">
                                    @if ($intento->es_correcto_int)
                                        <span class="badge badge-success">Correcto <i class="fas fa-check"></i></span>
                                    @else
                                        <span class="badge badge-danger">Incorrecto <i class="fas fa-times"></i></span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Fecha de Envío:</b> <span class="float-right">{{ \Carbon\Carbon::createFromTimestamp($intento->tiempo_envio_int)->format('d/m/Y H:i:s') }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Latencia (segundos):</b> <span class="float-right">{{ $intento->latencia_seg_int ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>

                    @php
                        $calculoMeta = $score->calculo_meta ?? [];
                    @endphp

                    @if ($score)
                        <div class="col-md-6">
                            <h4><i class="fas fa-chart-line mr-1"></i> Métricas de Scoring y IRT</h4>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Puntaje Obtenido:</b> <span class="float-right">{{ number_format($score->puntaje, 2) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Porcentaje:</b> <span class="float-right">{{ number_format($score->porcentaje, 2) }}%</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Penalización:</b> <span class="float-right">{{ number_format($calculoMeta['penalizacion'] ?? 1.0, 2) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Bono por Tiempo:</b> <span class="float-right">{{ number_format($calculoMeta['bono_tiempo'] ?? 1.0, 2) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Factor Resultado:</b> <span class="float-right">{{ number_format($calculoMeta['factor_resultado'] ?? 0.0, 2) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>EMA (Rendimiento Histórico):</b> <span class="float-right">{{ number_format($calculoMeta['ema'] ?? 0.0, 2) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Muestras EMA:</b> <span class="float-right">{{ $calculoMeta['muestras'] ?? 0 }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Theta (Habilidad IRT):</b> <span class="float-right">{{ number_format($calculoMeta['irt']['theta'] ?? 0.0, 4) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Nivel Determinado:</b> <span class="float-right badge badge-{{ ($calculoMeta['irt']['nivel'] ?? '') == 'alto' ? 'success' : (($calculoMeta['irt']['nivel'] ?? '') == 'medio' ? 'warning' : 'danger') }}">{{ $calculoMeta['irt']['nivel'] ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Estado Markov (Anterior):</b> <span class="float-right">{{ $calculoMeta['irt']['estado_anterior'] ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Estado Markov (Nuevo):</b> <span class="float-right">{{ $calculoMeta['irt']['estado_nuevo'] ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>IRT Convergencia:</b> <span class="float-right">
                                        @if (($calculoMeta['irt']['convergio'] ?? false))
                                            <span class="badge badge-success">Sí</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>IRT Iteraciones:</b> <span class="float-right">{{ $calculoMeta['irt']['iter'] ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="col-md-6">
                            <p class="text-muted">No se encontraron datos de scoring o IRT para este intento.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('docente.intentos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver a la Lista</a>
            </div>
        </div>
    </div>
@endsection
