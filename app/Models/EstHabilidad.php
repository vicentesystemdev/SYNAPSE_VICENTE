<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstHabilidad extends Model
{
    use HasFactory;

    protected $table = 'est_habilidades';
    protected $primaryKey = 'id_esth';

    protected $fillable = [
        'user_id',
        'theta_global',
        'theta_por_cat',
    ];

    protected $casts = [
        'theta_global' => 'decimal:4',
        'theta_por_cat' => 'array',
    ];

    /** Relaciones */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Obtiene el nivel del estudiante basado en theta global
     */
    public function obtenerNivel(): ?string
    {
        if ($this->theta_global === null) {
            return null;
        }

        $theta = (float) $this->theta_global;

        if ($theta < -0.5) {
            return 'bajo';
        } elseif ($theta < 0.5) {
            return 'medio';
        } else {
            return 'alto';
        }
    }

    /**
     * Obtiene el nivel del estudiante en una categoría específica
     */
    public function obtenerNivelPorCategoria(int $categoriaId): ?string
    {
        if (!$this->theta_por_cat || !isset($this->theta_por_cat[$categoriaId])) {
            return null;
        }

        $theta = (float) $this->theta_por_cat[$categoriaId];

        if ($theta < -0.5) {
            return 'bajo';
        } elseif ($theta < 0.5) {
            return 'medio';
        } else {
            return 'alto';
        }
    }

    /**
     * Obtiene theta por categoría
     */
    public function obtenerThetaPorCategoria(int $categoriaId): ?float
    {
        if (!$this->theta_por_cat || !isset($this->theta_por_cat[$categoriaId])) {
            return null;
        }

        return (float) $this->theta_por_cat[$categoriaId];
    }
}
