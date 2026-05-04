<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Historial de posiciones por período.
 * Nombres anteriores: id_rank, posicion_rank, puntaje_total_rank, r_global_rank.
 */
class Ranking extends Model
{
    use HasFactory;

    protected $table = 'rankings';

    protected $fillable = [
        'user_id',
        'periodo_id',
        'skill_id',
        'puntaje_total',
        'posicion',
    ];

    protected $casts = [
        'puntaje_total' => 'float',
        'posicion'      => 'integer',
        'skill_id'      => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id', 'id_per');
    }
}
