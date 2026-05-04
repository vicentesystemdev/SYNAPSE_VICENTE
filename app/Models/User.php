<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atributos que se pueden asignar masivamente
     */
    protected $fillable = [
        'name',         // nombre(s)
        'app_usu',      // apellido paterno
        'apm_usu',      // apellido materno
        'email',
        'password',
        'activo_usu',   // estado activo/inactivo
    ];

    /**
     * Atributos ocultos (no se devuelven en JSON)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de tipos
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'activo_usu'        => 'boolean',
    ];

    /**
     * Relaciones personalizadas (ejemplo)
     */
    public function intentos()
    {
        return $this->hasMany(Intento::class, 'user_id', 'id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id', 'id');
    }

    public function rendimientos()
    {
        return $this->hasMany(Rendimiento::class, 'user_id', 'id');
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class, 'user_id', 'id');
    }

    public function habilidades()
    {
        return $this->hasOne(EstHabilidad::class, 'user_id', 'id');
    }

    public function estHabilidad()
    {
        return $this->hasOne(EstHabilidad::class, 'user_id', 'id');
    }

    /**
     * Accesor: nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->name} {$this->app_usu} {$this->apm_usu}");
    }
}
