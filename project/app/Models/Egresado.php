<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Egresado
 *
 * @property integer $id
 * @property integer $tipo
 * @property integer $institucion_id
 * @property integer $docente_id
 * @property integer $dni
 * @property string $nombre
 * @property string $apellido
 * @property string $sexo
 * @property string $nacimiento
 * @property string $nacionalidad
 * @property string $domicilio
 * @property string $localidad
 * @property string $barrio
 * @property string $tel_fijo
 * @property string $celular
 * @property string $email
 * @property string $foto
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $privado
 * @property-read \App\Models\Curriculum $curriculum
 * @property-read \App\Models\Institucion $institucion
 * @property-read \App\Models\User $docente
 * @method static Builder|Egresado whereId($value)
 * @method static Builder|Egresado whereTipo($value)
 * @method static Builder|Egresado whereInstitucionId($value)
 * @method static Builder|Egresado whereDocenteId($value)
 * @method static Builder|Egresado whereDni($value)
 * @method static Builder|Egresado whereNombre($value)
 * @method static Builder|Egresado whereApellido($value)
 * @method static Builder|Egresado whereSexo($value)
 * @method static Builder|Egresado whereNacimiento($value)
 * @method static Builder|Egresado whereNacionalidad($value)
 * @method static Builder|Egresado whereDomicilio($value)
 * @method static Builder|Egresado whereLocalidad($value)
 * @method static Builder|Egresado whereBarrio($value)
 * @method static Builder|Egresado whereTelFijo($value)
 * @method static Builder|Egresado whereCelular($value)
 * @method static Builder|Egresado whereEmail($value)
 * @method static Builder|Egresado whereFoto($value)
 * @method static Builder|Egresado whereCreatedAt($value)
 * @method static Builder|Egresado whereUpdatedAt($value)
 * @method static Builder|Egresado wherePrivado($value)
 * @mixin \Eloquent
 */
class Egresado extends Model
{
    // Tipos de egresado
    const TIPO_TECNICO = 1;
    const TIPO_OFICIO = 2;
    const TIPO_TECNICOS_LABEL = 'tecnicos';
    const TIPO_OFICIOS_LABEL = 'oficios';
    const TIPOS_LABELS = [
        self::TIPO_TECNICO => self::TIPO_TECNICOS_LABEL,
        self::TIPO_OFICIO => self::TIPO_OFICIOS_LABEL
    ];
    const TIPOS_MAP = [
        self::TIPO_TECNICOS_LABEL => self::TIPO_TECNICO,
        self::TIPO_OFICIOS_LABEL => self::TIPO_OFICIO
    ];


    protected $table = 'egresados';

    protected $fillable = [
        'dni','nombre','apellido','sexo','nacimiento','nacionalidad',
        'domicilio','localidad','barrio','tel_fijo','celular','email',
        //'facebook','twitter','linkedin'
        'privado'
    ];

    public static $image_path = 'media/img/egresados';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_egresado>_randomstring.<tipo_img>

    /**
     * Relacion 1:1 con Curriculum
     */
    public function curriculum()
    {
        return $this->hasOne(Curriculum::class);
    }

    /**
     * Relacion M:1 con Institucion
     */
    public function institucion() {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * Relacion M:1 con User docente
     */
    public function docente() {
        return $this->belongsTo(User::class);
    }

    public function getFullName() {
        return $this->nombre.' '.$this->apellido;
    }

    /**
     * Formatea fecha al obtener fecha de nacimiento
     * @param $value
     * @return null|string
     */
    public function getNacimientoAttribute($value)
    {
        if (!$value)
            return null;
        $date = new \DateTime($value);
        return $date->format('d/m/Y');
    }

    public function getEdad() {
        if (!$this->nacimiento) {
            return null;
        }
        $fecha_nac = \DateTime::createFromFormat('d/m/Y', $this->nacimiento);
        $hoy = new \DateTime();
        return $hoy->diff($fecha_nac)->y;
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

    /**
     * Formatea fecha al obtener fecha de nacimiento
     * @param $value
     * @return null|string
     */
    public function getUpdatedAtAttribute($value)
    {
        if (!$value)
            return null;
        $date = new \DateTime($value);
        return $date->format('d/m/Y');
    }

}
