<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Alumno
 *
 * @property integer $id
 * @property integer $escuela_id
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
 * @property-read \App\Models\Escuela $escuela
 * @property-read \App\Models\User $docente
 * @method static Builder|Alumno whereId($value)
 * @method static Builder|Alumno whereEscuelaId($value)
 * @method static Builder|Alumno whereDocenteId($value)
 * @method static Builder|Alumno whereDni($value)
 * @method static Builder|Alumno whereNombre($value)
 * @method static Builder|Alumno whereApellido($value)
 * @method static Builder|Alumno whereSexo($value)
 * @method static Builder|Alumno whereNacimiento($value)
 * @method static Builder|Alumno whereNacionalidad($value)
 * @method static Builder|Alumno whereDomicilio($value)
 * @method static Builder|Alumno whereLocalidad($value)
 * @method static Builder|Alumno whereBarrio($value)
 * @method static Builder|Alumno whereTelFijo($value)
 * @method static Builder|Alumno whereCelular($value)
 * @method static Builder|Alumno whereEmail($value)
 * @method static Builder|Alumno whereFoto($value)
 * @method static Builder|Alumno whereCreatedAt($value)
 * @method static Builder|Alumno whereUpdatedAt($value)
 * @method static Builder|Alumno wherePrivado($value)
 * @mixin \Eloquent
 */
class Alumno extends Model
{
    protected $fillable = [
        'dni','nombre','apellido','sexo','nacimiento','nacionalidad',
        'domicilio','localidad','barrio','tel_fijo','celular','email',
        //'facebook','twitter','linkedin'
        'privado'
    ];

    public static $image_path = 'media/img/alumnos';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_alumno>_randomstring.<tipo_img>

    /**
     * Relacion 1:1 con Curriculum
     */
    public function curriculum()
    {
        return $this->hasOne(Curriculum::class);
    }

    /**
     * Relacion M:1 con Escuela
     */
    public function escuela() {
        return $this->belongsTo(Escuela::class);
    }

    /**
     * Relacion M:1 con Docente
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

}
