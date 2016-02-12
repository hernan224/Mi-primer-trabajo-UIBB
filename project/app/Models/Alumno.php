<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'dni','nombre','apellido','sexo','nacimiento','nacionalidad',
        'domicilio','localidad','barrio','tel_fijo','celular','email',
        //'facebook','twitter','linkedin'
    ];

    public static $image_path = 'media/img/alumnos';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_alumno>.<tipo_img>

    /**
     * Relacion 1:1 con Curriculum
     */
    public function curriculum()
    {
        return $this->hasOne(Curriculum::class);
    }

    /*
     * Relacion M:1 con Escuela
     */
    public function escuela() {
        return $this->belongsTo(Escuela::class);
    }

    /*
     * Relacion M:1 con Docente
     */
    public function docente() {
        return $this->belongsTo(User::class);
    }


}
