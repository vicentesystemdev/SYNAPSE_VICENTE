<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * EMA por categoría.
 * Nombres anteriores: id_rend, n_intentos.
 */
class Rendimiento extends Model
{
    use HasFactory;

    protected $table = 'rendimientos';

    protected $fillable = [
        'user_id',
        'categoria_id',
        'r_ema',
        'muestras',
    ];

    protected $casts = [
        'r_ema'    => 'float',
        'muestras' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_cat');
    }
}
