<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Intento #{{ $intento->id_int }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; font-size: 12px; }
        h1, h2 { text-align: center; margin-bottom: 10px; }
        .section-title { font-weight: bold; background-color: #f2f2f2; padding: 5px; margin-top: 20px; margin-bottom: 10px; border-left: 5px solid #007bff; }
        .data-row { display: flex; margin-bottom: 5px; }
        .data-label { font-weight: bold; width: 180px; flex-shrink: 0; }
        .data-value { flex-grow: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 10px; color: white; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-info { background-color: #17a2b8; }
        .card { border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
        .card-header { font-size: 14px; font-weight: bold; margin-bottom: 10px; }
        .col-md-6 { width: 48%; display: inline-block; vertical-align: top; }
        .float-left { float: left; }
        .float-right { float: right; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <h1>Detalles del Intento #{{ $intento->id_int }}</h1>
    <p style="text-align: center;">Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>

    <div class="clearfix">
        <div class="col-md-6 float-left">
            <div class="card">
                <div class="card-header">
                    Datos Generales del Intento
                </div>
                <div class="card-body">
                    <div class="data-row"><span class="data-label">ID de Intento:</span> <span class="data-value">{{ $intento->id_int }}</span></div>
                    <div class="data-row"><span class="data-label">Estudiante:</span> <span class="data-value">{{ $intento->user->name }} {{ $intento->user->app_usu }} {{ $intento->user->apm_usu }}</span></div>
                    <div class="data-row"><span class="data-label">Correo Estudiante:</span> <span class="data-value">{{ $intento->user->email }}</span></div>
                    <div class="data-row"><span class="data-label">Evaluación:</span> <span class="data-value">{{ $intento->evaluacion->titulo_eval }}</span></div>
                    <div class="data-row"><span class="data-label">Categoría:</span> <span class="data-value">{{ $intento->evaluacion->categoria->nombre_cat }}</span></div>
                    <div class="data-row"><span class="data-label">Nro. de Intento:</span> <span class="data-value">{{ $intento->nro_intento_int }}</span></div>
                    <div class="data-row"><span class="data-label">Respuesta Enviada:</span> <span class="data-value">{{ $intento->respuesta_int }}</span></div>
                    <div class="data-row"><span class="data-label">Resultado:</span> <span class="data-value">
                        @if ($intento->resultado_int === 1)
                            <span class="badge badge-success">Correcto</span>
                        @else
                            <span class="badge badge-danger">Incorrecto</span>
                        @endif
                    </span></div>
                    <div class="data-row"><span class="data-label">Fecha de Envío:</span> <span class="data-value">{{ \Carbon\Carbon::parse($intento->fecha_envio_int)->format('d/m/Y H:i:s') }}</span></div>
                    <div class="data-row"><span class="data-label">Latencia (segundos):</span> <span class="data-value">{{ $intento->latencia_int }}</span></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 float-right">
            <div class="card">
                <div class="card-header">
                    Métricas de Scoring e IRT
                </div>
                <div class="card-body">
                    @if ($score)
                        <div class="data-row"><span class="data-label">Puntaje Obtenido:</span> <span class="data-value">{{ $score->puntaje_obtenido_sco ?? 'N/A' }}</span></div>
                        <div class="data-row"><span class="data-label">Porcentaje:</span> <span class="data-value">{{ number_format($score->puntaje_obtenido_sco ?? 0, 2) }}%</span></div>
                        <div class="data-row"><span class="data-label">Penalización:</span> <span class="data-value">{{ $score->penalizacion_sco ?? 'N/A' }}</span></div>
                        <div class="data-row"><span class="data-label">Bono por Tiempo:</span> <span class="data-value">{{ $score->bono_tiempo_sco ?? 'N/A' }}</span></div>
                        <div class="data-row"><span class="data-label">Factor Resultado:</span> <span class="data-value">{{ $score->factor_resultado_sco ?? 'N/A' }}</span></div>
                        <div class="data-row"><span class="data-label">EMA (Rendimiento Histórico):</span> <span class="data-value">{{ number_format($score->ema_sco ?? 0, 2) }}</span></div>
                        <div class="data-row"><span class="data-label">Muestras EMA:</span> <span class="data-value">{{ $score->muestras_ema_sco ?? 'N/A' }}</span></div>
                        <div class="data-row"><span class="data-label">Theta (Habilidad IRT):</span> <span class="data-value">{{ number_format($score->theta_irt_sco ?? 0, 4) }}</span></div>
                        <div class="data-row"><span class="data-label">Nivel Determinado:</span> <span class="data-value">
                            @if (isset($score->calculo_meta['nivel_determinado']))
                                <span class="badge badge-info">{{ ucfirst($score->calculo_meta['nivel_determinado']) }}</span>
                            @else
                                N/A
                            @endif
                        </span></div>
                        <div class="data-row"><span class="data-label">Estado Markov (Anterior):</span> <span class="data-value">
                            @if (isset($score->calculo_meta['estado_markov_anterior']))
                                <span class="badge badge-info">{{ ucfirst($score->calculo_meta['estado_markov_anterior']) }}</span>
                            @else
                                N/A
                            @endif
                        </span></div>
                    @else
                        <p>No hay datos de Scoring e IRT disponibles para este intento.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div style="clear: both;"></div> {{-- Clear floats --}}
</body>
</html>
