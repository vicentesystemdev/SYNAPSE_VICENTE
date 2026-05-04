<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Docentes</title>
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
    <h1>Reporte de Docentes</h1>
    <p>Fecha de Generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($docentes as $index => $docente)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $docente->id }}</td>
                    <td>{{ $docente->name }}</td>
                    <td>{{ $docente->app_usu }}</td>
                    <td>{{ $docente->apm_usu }}</td>
                    <td>{{ $docente->email }}</td>
                    <td>
                        @if ($docente->activo_usu)
                            <span class="badge-success">Activo</span>
                        @else
                            <span class="badge-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No hay docentes para este reporte.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Página <span class="page"></span> de <span class="topage"></span>
    </div>
</body>
</html>