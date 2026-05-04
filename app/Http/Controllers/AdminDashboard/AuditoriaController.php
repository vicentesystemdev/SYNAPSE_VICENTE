<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * Muestra el listado de logs de auditoría
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('accion')) {
            $query->where('accion_audit', $request->accion);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Solo sesiones (login/logout) por defecto
        if (!$request->filled('mostrar_todo')) {
            $query->sessions();
        }

        $logs = $query->paginate(20);

        // Estadísticas
        $stats = [
            'total_logins' => AuditLog::logins()->count(),
            'total_logouts' => AuditLog::logouts()->count(),
            'logins_hoy' => AuditLog::logins()->whereDate('created_at', today())->count(),
            'usuarios_activos' => AuditLog::logins()
                ->whereDate('created_at', today())
                ->distinct('user_id')
                ->count('user_id'),
        ];

        return view('admin.auditoria.index', compact('logs', 'stats'));
    }

    /**
     * Muestra el detalle de un log específico
     */
    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        return view('admin.auditoria.show', compact('log'));
    }
}
