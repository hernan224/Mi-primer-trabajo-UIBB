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
 * @property integer $tipo
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
 * @method static Builder|Institucion whereTipo($value)
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
    // Tipos de institución (contienen egresados del mismo tipo)
    const TIPO_ESCUELA_TECNICA = 1;
    const TIPO_CENTRO_FORMACION = 2;

    CONST TIPOS_LABELS = [
        self::TIPO_ESCUELA_TECNICA => 'Escuela Técnica',
        self::TIPO_CENTRO_FORMACION => 'Centro de Formación Profesional'
    ];
    CONST TIPOS_EGRESADOS_LABELS = [
        self::TIPO_ESCUELA_TECNICA => Egresado::TIPO_TECNICOS_LABEL,
        self::TIPO_CENTRO_FORMACION => Egresado::TIPO_OFICIOS_LABEL
    ];
    const TIPOS_MAP = [
        Egresado::TIPO_TECNICOS_LABEL => self::TIPO_ESCUELA_TECNICA,
        Egresado::TIPO_OFICIOS_LABEL => self::TIPO_CENTRO_FORMACION
    ];

    protected $table = 'instituciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'direccion', 'telefono','localidad','email','foto', 'tipo'
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

    public function getTipoLabel() {
        try {
            return self::TIPOS_LABELS[$this->tipo];
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getTipoEgresadosLabel() {
        try {
            return self::TIPOS_EGRESADOS_LABELS[$this->tipo];
        } catch (\Exception $e) {
            return '';
        }
    }

}
