<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'dni','nombre','apellido','sexo','nacimiento','nacionalidad',
        'domicilio','localidad','barrio','tel_fijo','celular','email',
        'facebook','twitter','linkedin'
    ];

    public static $image_path = 'img/alumnos';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_alumno>.<tipo_img>
}
