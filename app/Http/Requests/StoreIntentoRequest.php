<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // o tu lógica de permisos
    }

    public function rules(): array
    {
        return [
            'respuesta_flag_int' => 'required|string|max:255',
        ];
    }
}
