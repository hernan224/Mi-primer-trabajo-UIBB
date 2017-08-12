<?php

namespace App\Http\Requests;

// Reglas de validacion para POST de egresado
class PostEgresadoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // La verificacion de si el id del egresado corresponde al usuario
        // cuando se edita, se invoca desde el controller
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

        $dni_validation = 'required_without:privado|integer|max:99999999|unique:egresados,dni';
        // Si estoy editando, verifico que el DNI sea unico, sin tener en cuenta el egresado actual
        $route = $this->route()->getName();
        if ($route == 'institucion.egresado_edit_put') {
            $id_egresado = $this->route('id');
            $dni_validation .= ','.$id_egresado;
        }
        return [
            // data egresado
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'dni' => $dni_validation,
            'sexo' => 'required|in:m,f',
            'nacimiento' => 'required_without:privado|date_format:d/m/Y',
            'nacionalidad' => 'required_without:privado|string|max:50',
            'domicilio' => 'required_without:privado|string',
            'localidad' => 'required_without:privado|string|max:50',
            'barrio' => 'string|max:50',
            'tel_fijo' => 'string|max:20',
            'celular' => 'required_without:privado|string|max:20',
            'email' => 'required_without:privado|email',
            'foto' => 'image',
            // data curriculum
            'rubro' => 'required_if:tipo,oficios|string',
            'especialidad' => 'required_if:tipo,tecnicos|string',
            'promedio' => 'required_without:privado|between:0,10',
            'asignaturas' => 'string',
            // 'practicas_tipo' => 'required_without:privado|string',
            // 'practicas_lugar' => 'required_without:privado|string',
            // 'practicas_tipo' => 'required_with:practicas_lugar'
            // 'carta_presentacion' => 'required_without:privado',
            'estudios_carrera' => 'required_if:estudios,si',
            'estudios_lugar' => 'required_if:estudios,si'
        ];

    }
}
