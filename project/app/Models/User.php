<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role', 'telefono'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function puedeEditar() {
        return $this->hasRole('escuela'); // || $this->hasRole('admin');
    }

    public function hasRole($rol) {
        return $this->role == $rol;
    }

    /**
     * Relación M:1 con Escuela
     */
    public function escuela() {
        return $this->belongsTo(Escuela::class);
    }

    /**
     * Relación M:1 con Empresa
     */
    // public function empresa() {
    //     return $this->belongsTo(Empresa::class);
    // }

    /**
     * Relación 1:M con Alumnos
     */
    public function alumnos() {
        return $this->hasMany(Alumno::class);
    }


}
