<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property integer $escuela_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $telefono
 * @property string $direccion
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Escuela $escuela
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alumno[] $alumnos
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereEscuelaId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereTelefono($value)
 * @method static Builder|User whereDireccion($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    /**
     * Consulta si puede editar alumnos (sólo disponible para escuelas)
     * @return bool
     */
    public function puedeEditar() {
        return $this->hasRole('escuela'); // || $this->hasRole('admin');
    }

    /**
     * Consulta de rol.
     *      Roles posibles:
     *          - escuela: puede crear, editar, eliminar alumnos propios
     *          - admin: puede crear publicaciones
     * @param $rol
     * @return bool
     */
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
     * Relación M:1 con Empresa - Desactivado (no hay usuarios tipo empresa)
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
