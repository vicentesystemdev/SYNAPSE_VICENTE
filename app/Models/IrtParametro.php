<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrtParametro extends Model
{
    use HasFactory;

    protected $table = 'irt_parametros';
    protected $primaryKey = 'id_irt';

    protected $fillable = [
        'evaluacion_id',
        'a_discriminacion',
        'b_dificultad',
        'c_azar',
    ];

    protected $casts = [
        'a_discriminacion' => 'decimal:3',
        'b_dificultad'     => 'decimal:3',
        'c_azar'           => 'decimal:3',
    ];

    /** Relaciones */
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id', 'id_eval');
    }
}
