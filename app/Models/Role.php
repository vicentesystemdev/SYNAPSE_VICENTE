<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'estado',
    ];

    /**
     * Get the estado description.
     */
    public function getEstadoTextoAttribute(): string
    {
        return match ($this->estado) {
            1 => 'Activo',
            2 => 'Inactivo',
            default => 'Desconocido',
        };
    }
}
