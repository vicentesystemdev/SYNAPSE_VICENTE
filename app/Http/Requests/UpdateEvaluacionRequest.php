<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin','docente']) ?? false;
    }

    public function rules(): array
    {
        return [
            'categoria_id'       => ['required', 'exists:categorias,id_cat'],
            'dificultad_id'      => ['required', 'exists:dificultades,id_dif'],
            'periodo_id'         => ['nullable', 'exists:periodos,id_per'],
            'docente_user_id'    => ['nullable', 'exists:users,id'],

            'titulo_eval'        => ['required', 'string', 'max:150'],
            'descripcion_eval'   => ['nullable', 'string'],
            'puntaje_base_eval'  => ['required', 'numeric', 'min:0', 'max:999999.99'],

            'fecha_inicio_eval'  => ['nullable', 'date'],
            'fecha_fin_eval'     => ['nullable', 'date', 'after_or_equal:fecha_inicio_eval'],

            'flag_hash_eval'     => ['nullable', 'string', 'max:255'],
            'estado_eval'        => ['required', 'integer', 'in:1,2,3'],
            'archivo_adjunto'    => ['nullable', 'file', 'max:10240'],
        ];
    }
}
