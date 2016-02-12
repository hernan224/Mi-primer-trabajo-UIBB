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
        'name', 'direccion', 'telefono'
    ];

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

}
