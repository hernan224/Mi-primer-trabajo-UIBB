<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'direccion', 'telefono','localidad','email','foto'
    ];

    public static $image_path = 'media/img/escuelas';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_alumno>.<tipo_img>


    /**
     * Relación 1:M con user
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Relación 1:M con Alumnos
     */
    public function alumnos() {
        return $this->hasMany(Alumno::class);
    }

    public function getUrlFoto() {
        if ($this->foto) {
            return asset(self::$image_path.'/'.$this->foto);
        }
        else false;
    }

}
