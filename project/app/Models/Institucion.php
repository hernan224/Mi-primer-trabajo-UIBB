<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Institucion
 *
 * Institucion educativa: institucion técnica o centro de formación profesional (según tipo)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Egresado[] $egresados
 * @method static Builder|Institucion whereId($value)
 * @method static Builder|Institucion whereName($value)
 * @method static Builder|Institucion whereDireccion($value)
 * @method static Builder|Institucion whereTelefono($value)
 * @method static Builder|Institucion whereCreatedAt($value)
 * @method static Builder|Institucion whereUpdatedAt($value)
 * @method static Builder|Institucion whereEmail($value)
 * @method static Builder|Institucion whereLocalidad($value)
 * @method static Builder|Institucion whereFoto($value)
 * @mixin \Eloquent
 */
class Institucion extends Model
{
    const TIPO_ESCUELA_TECNINCA = 'escuela_tecnica';
    const TIPO_CENTRO_FORMACION = 'centro_formacion';

    protected $table = 'instituciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'direccion', 'telefono','localidad','email','foto'
    ];

    public static $image_path = 'media/img/instituciones';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_institucion>_randomstring.<tipo_img>


    /**
     * Relación 1:M con users  (docentes)
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Relación 1:M con egresados
     */
    public function egresados() {
        return $this->hasMany(Egresado::class);
    }

    public function getUrlFoto() {
        if ($this->foto) {
            return asset(self::$image_path.'/'.$this->foto);
        }
        else return false;
    }

}
