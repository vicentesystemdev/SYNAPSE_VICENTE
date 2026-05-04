<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intento extends Model
{
    use HasFactory;

    protected $table = 'intentos';
    protected $primaryKey = 'id_int';

    protected $fillable = [
        'evaluacion_id',
        'user_id',
        'respuesta_flag_int',
        'es_correcto_int',
        'nro_intento_int',
        'tiempo_envio_int',
        'latencia_seg_int',
        'meta_int',
    ];

    protected $casts = [
        'es_correcto_int'  => 'boolean',
        'tiempo_envio_int' => 'integer', // Unix timestamp (integer)
        'latencia_seg_int' => 'float',
        'meta_int'         => 'array',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id', 'id_eval');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
