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

    public function escuela() {
        return $this->belongsTo(Escuela::class);
    }

    public function puedeEditar() {
        return $this->hasRole('escuela') || $this->hasRole('admin');
    }

    public function hasRole($rol) {
        return $this->role == $rol;
    }

}