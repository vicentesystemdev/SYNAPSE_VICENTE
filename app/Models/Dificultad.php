<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dificultad extends Model
{
    use HasFactory;

    protected $table = 'dificultades';
    protected $primaryKey = 'id_dif';

    protected $fillable = [
        'nombre_dif',
        'orden_dif',
    ];

    protected $casts = [
        'orden_dif' => 'integer',
    ];

    /** Relaciones */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'dificultad_id', 'id_dif');
    }
}
