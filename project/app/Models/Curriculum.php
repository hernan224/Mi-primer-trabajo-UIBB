<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Curriculum
 *
 * @property integer $id
 * @property integer $egresado_id
 * @property string $especialidad
 * @property float $promedio
 * @property string $asignaturas
 * @property string $practicas_tipo
 * @property string $practicas_lugar
 * @property boolean $responsabilidad
 * @property boolean $puntualidad
 * @property boolean $proactividad
 * @property boolean $equipo
 * @property boolean $creatividad
 * @property boolean $liderazgo
 * @property boolean $conciliador
 * @property boolean $perseverancia
 * @property boolean $asertividad
 * @property boolean $relaciones
 * @property boolean $objetivos
 * @property boolean $saludable
 * @property string $extras
 * @property string $participacion
 * @property string $carta_presentacion
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $estudios
 * @property string $estudios_carrera
 * @property string $estudios_lugar
 * @property-read \App\Models\Egresado $egresado
 * @method static Builder|Curriculum whereId($value)
 * @method static Builder|Curriculum whereEgresadoId($value)
 * @method static Builder|Curriculum whereEspecialidad($value)
 * @method static Builder|Curriculum wherePromedio($value)
 * @method static Builder|Curriculum whereAsignaturas($value)
 * @method static Builder|Curriculum wherePracticasTipo($value)
 * @method static Builder|Curriculum wherePracticasLugar($value)
 * @method static Builder|Curriculum whereResponsabilidad($value)
 * @method static Builder|Curriculum wherePuntualidad($value)
 * @method static Builder|Curriculum whereProactividad($value)
 * @method static Builder|Curriculum whereEquipo($value)
 * @method static Builder|Curriculum whereCreatividad($value)
 * @method static Builder|Curriculum whereLiderazgo($value)
 * @method static Builder|Curriculum whereConciliador($value)
 * @method static Builder|Curriculum wherePerseverancia($value)
 * @method static Builder|Curriculum whereAsertividad($value)
 * @method static Builder|Curriculum whereRelaciones($value)
 * @method static Builder|Curriculum whereObjetivos($value)
 * @method static Builder|Curriculum whereSaludable($value)
 * @method static Builder|Curriculum whereExtras($value)
 * @method static Builder|Curriculum whereParticipacion($value)
 * @method static Builder|Curriculum whereCartaPresentacion($value)
 * @method static Builder|Curriculum whereCreatedAt($value)
 * @method static Builder|Curriculum whereUpdatedAt($value)
 * @method static Builder|Curriculum whereEstudios($value)
 * @method static Builder|Curriculum whereEstudiosCarrera($value)
 * @method static Builder|Curriculum whereEstudiosLugar($value)
 * @mixin \Eloquent
 */
class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'especialidad','promedio','asignaturas','practicas_tipo','practicas_lugar',
        'estudios', 'estudios_carrera', 'estudios_lugar','extras','participacion','carta_presentacion',
        // actitudes (booleans)
        'responsabilidad','puntualidad','proactividad','equipo','creatividad','liderazgo',
        'conciliador','perseverancia','asertividad','relaciones','objetivos','saludable'
    ];

    public static $actitudes_names = [
        'responsabilidad','puntualidad','proactividad','equipo','creatividad','liderazgo',
        'conciliador','perseverancia','asertividad','relaciones','objetivos','saludable'
    ];

    /**
     * Relacion 1:1 con Egresado (inversa)
     */
    public function egresado()
    {
        return $this->belongsTo(Egresado::class);
    }

    /**
     * Formatea fecha al obtener fecha de actualizacion
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $date = new \DateTime($value);
        return $date->format('d/m/Y');
    }

    /**
     * Devuelve array con las actitudes indicadas
     */
    public function getActitudes() {
        $result = [];
        foreach (self::$actitudes_names as $actitud) {
            if ($this->$actitud) {
                $result[] = $actitud;
            }
        }
        return $result;
    }

    /**
     *  Mutator promedio
     * @param $value
     */
    public function setPromedioAttribute($value) {
        if (!$value) {
            $this->attributes['promedio'] = null;
        }
        else {
            $this->attributes['promedio'] = $value;
        }
    }

}
