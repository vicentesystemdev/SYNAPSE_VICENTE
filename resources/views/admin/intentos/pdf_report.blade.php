<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Auditoría de Intentos</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background-color: #f2f2f2; }
        .badge-success { background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 9px; }
        .badge-danger { background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 9px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <h1>Reporte de Auditoría de Intentos - SYNAPSE</h1>
    <p>Fecha de Generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID Intento</th>
                <th>Estudiante</th>
                <th>Evaluación</th>
                <th>Nro Intento</th>
                <th>Respuesta</th>
                <th>Correcto</th>
                <th>Fecha Envío</th>
                <th>Latencia (seg)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($intentos as $intento)
                <tr>
                    <td>{{ $intento->id_int }}</td>
                    <td>{{ $intento->user->name }} {{ $intento->user->app_usu }}</td>
                    <td>{{ $intento->evaluacion->titulo_eval }}</td>
                    <td>{{ $intento->nro_intento_int }}</td>
                    <td>{{ $intento->respuesta_flag_int }}</td>
                    <td>
                        @if ($intento->es_correcto_int)
                            <span class="badge-success">Sí</span>
                        @else
                            <span class="badge-danger">No</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::createFromTimestamp($intento->tiempo_envio_int)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $intento->latencia_seg_int ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No hay intentos para este reporte.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Página <span class="page"></span> de <span class="topage"></span>
    </div>
</body>
</html>