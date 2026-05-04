<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Puntaje agregado por evaluación.
 * Nombres anteriores: id_score, puntaje_obtenido_score, ema_cat_score, ema_global_score, ultimo_correcto_score.
 */
class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    protected $fillable = [
        'user_id',
        'evaluacion_id',
        'puntaje',
        'porcentaje',
        'calculo_meta',
    ];

    protected $casts = [
        'puntaje'      => 'float',
        'porcentaje'   => 'float',
        'calculo_meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id', 'id_eval');
    }
}
