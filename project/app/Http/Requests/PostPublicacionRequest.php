<?php

namespace App\Http\Requests;

// Reglas de validacion para POST de nota informativa
use App\Models\Publicacion;

class PostPublicacionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // La verificacion de rol de usuario se hace con middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Trim inputs
        $trim_if_string = function($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));

        $categorias = Publicacion::CATEGORIA_CAPACITACIONES.','.Publicacion::CATEGORIA_PRACTICAS;

        return [
            // data alumno
            'titulo' => 'required|max:120',
            'texto' => 'required',
            'categoria' => 'required|in:'.$categorias,
            'imagen' => 'image',
        ];

    }
}
