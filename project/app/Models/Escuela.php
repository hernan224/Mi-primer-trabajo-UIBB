<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Escuela
 *
 * @property integer $id
 * @property string $name
 * @property string $direccion
 * @property string $telefono
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $email
 * @property string $localidad
 * @property string $foto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alumno[] $alumnos
 * @method static Builder|Escuela whereId($value)
 * @method static Builder|Escuela whereName($value)
 * @method static Builder|Escuela whereDireccion($value)
 * @method static Builder|Escuela whereTelefono($value)
 * @method static Builder|Escuela whereCreatedAt($value)
 * @method static Builder|Escuela whereUpdatedAt($value)
 * @method static Builder|Escuela whereEmail($value)
 * @method static Builder|Escuela whereLocalidad($value)
 * @method static Builder|Escuela whereFoto($value)
 * @mixin \Eloquent
 */
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
        else return false;
    }

}
