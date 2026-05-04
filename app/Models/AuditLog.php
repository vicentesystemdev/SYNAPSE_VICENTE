<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';
    protected $primaryKey = 'id_audit';

    protected $fillable = [
        'user_id',
        'accion_audit',
        'entidad_audit',
        'entidad_id_audit',
        'payload_audit',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'payload_audit' => 'array',
    ];

    /** Relaciones */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** Scopes para consultas comunes */
    
    /**
     * Scope para filtrar solo logins
     */
    public function scopeLogins($query)
    {
        return $query->where('accion_audit', 'login');
    }

    /**
     * Scope para filtrar solo logouts
     */
    public function scopeLogouts($query)
    {
        return $query->where('accion_audit', 'logout');
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para filtrar por IP
     */
    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Scope para obtener registros recientes
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope para sesiones (login y logout)
     */
    public function scopeSessions($query)
    {
        return $query->whereIn('accion_audit', ['login', 'logout']);
    }
}
