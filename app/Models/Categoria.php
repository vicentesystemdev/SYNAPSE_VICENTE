<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_cat';

    protected $fillable = [
        'codigo_cat',
        'nombre_cat',
        'descripcion_cat',
        'activo_cat',
    ];

    protected $casts = [
        'activo_cat' => 'boolean',
    ];

    /** Relaciones */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'categoria_id', 'id_cat');
    }

    public function rendimientos()
    {
        return $this->hasMany(Rendimiento::class, 'categoria_id', 'id_cat');
    }
}
