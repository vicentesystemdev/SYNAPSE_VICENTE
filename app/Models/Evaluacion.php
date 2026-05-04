<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne; // Importar HasOne

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_eval';

    protected $fillable = [
        'categoria_id',
        'dificultad_id',
        'periodo_id',
        'docente_user_id',
        'titulo_eval',
        'descripcion_eval',
        'puntaje_base_eval',
        'fecha_inicio_eval',
        'fecha_fin_eval',
        'flag_hash_eval',
        'solution_md5',
        'metadata_eval',
        'estado_eval',
        'archivo_adjunto',
    ];

    protected $casts = [
        'puntaje_base_eval' => 'decimal:2',
        'fecha_inicio_eval' => 'datetime',
        'fecha_fin_eval' => 'datetime',
        'estado_eval'      => 'integer',
        'metadata_eval'    => 'array',
    ];

    /** Relaciones */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_cat');
    }

    public function dificultad()
    {
        return $this->belongsTo(Dificultad::class, 'dificultad_id', 'id_dif');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id', 'id_per');
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_user_id', 'id');
    }

    public function intentos()
    {
        return $this->hasMany(Intento::class, 'evaluacion_id', 'id_eval');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'evaluacion_id', 'id_eval');
    }

    // Relación con IrtParametro (UN A UNO)
    public function irtParametros(): HasOne
    {
        return $this->hasOne(IrtParametro::class, 'evaluacion_id', 'id_eval');
    }
}
