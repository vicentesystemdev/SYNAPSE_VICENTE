<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Servicio centralizado para auditoría de acciones del sistema
 */
class AuditService
{
    /**
     * Registra un login exitoso
     */
    public function logLogin(User $user, Request $request): void
    {
        $this->createLog(
            user: $user,
            action: 'login',
            request: $request,
            payload: [
                'nombre' => $user->nombre_usu,
                'email' => $user->email,
                'rol' => $user->getRoleNames()->first() ?? 'sin_rol',
            ]
        );
    }

    /**
     * Registra un logout
     */
    public function logLogout(User $user, Request $request): void
    {
        // Calcular duración de la sesión si es posible
        $lastLogin = AuditLog::where('user_id', $user->id)
            ->where('accion_audit', 'login')
            ->latest('created_at')
            ->first();

        $duracion = null;
        if ($lastLogin) {
            $duracion = now()->diffInMinutes($lastLogin->created_at);
        }

        $this->createLog(
            user: $user,
            action: 'logout',
            request: $request,
            payload: [
                'duracion_sesion_minutos' => $duracion,
            ]
        );
    }

    /**
     * Registra una acción genérica
     */
    public function logAction(
        User $user,
        string $action,
        Request $request,
        ?string $entidad = null,
        ?int $entidadId = null,
        array $payload = []
    ): void {
        $this->createLog(
            user: $user,
            action: $action,
            request: $request,
            entidad: $entidad,
            entidadId: $entidadId,
            payload: $payload
        );
    }

    /**
     * Crea un registro de auditoría
     */
    private function createLog(
        User $user,
        string $action,
        Request $request,
        ?string $entidad = null,
        ?int $entidadId = null,
        array $payload = []
    ): void {
        AuditLog::create([
            'user_id' => $user->id,
            'accion_audit' => $action,
            'entidad_audit' => $entidad,
            'entidad_id_audit' => $entidadId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload_audit' => $payload,
        ]);
    }

    /**
     * Obtiene los últimos logins
     */
    public function getRecentLogins(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->where('accion_audit', 'login')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtiene el historial de sesiones de un usuario
     */
    public function getUserSessionHistory(int $userId, int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::where('user_id', $userId)
            ->whereIn('accion_audit', ['login', 'logout'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtiene logins desde una IP específica
     */
    public function getLoginsByIp(string $ip, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->where('ip_address', $ip)
            ->where('accion_audit', 'login')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
