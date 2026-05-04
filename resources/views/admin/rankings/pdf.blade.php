<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f3f4f6; text-transform: uppercase; font-size: 11px; }
    </style>
</head>
<body>
    <h2>Ranking {{ $periodo?->nombre_per }} {{ $skill?->nombre_cat ? '(' . $skill->nombre_cat . ')' : '' }}</h2>
    <p>Generado: {{ now()->timezone('America/La_Paz')->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Estudiante</th>
                <th>Puntaje total</th>
                <th># Evaluaciones</th>
                <th>Última actualización</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataset as $item)
                @php($ranking = $item->get('ranking'))
                <tr>
                    <td>{{ $ranking->posicion }}</td>
                    <td>{{ $ranking->user?->name ?? 'N/D' }}</td>
                    <td>{{ number_format($ranking->puntaje_total, 2) }}</td>
                    <td>{{ $item->get('evaluaciones') }}</td>
                    <td>{{ optional($item->get('ultima_actualizacion'))->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sin datos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
