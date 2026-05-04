<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodos';
    protected $primaryKey = 'id_per';

    protected $fillable = [
        'nombre_per',
        'gestion_per',
        'activo_per',
    ];

    protected $casts = [
        'activo_per' => 'boolean',
    ];

    /** Relaciones */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'periodo_id', 'id_per');
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class, 'periodo_id', 'id_per');
    }
}
