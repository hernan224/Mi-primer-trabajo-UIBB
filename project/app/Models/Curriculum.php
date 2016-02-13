<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'especialidad','promedio','asignaturas','practicas_tipo','practicas_lugar',
        'extras','participacion','carta',
        // actitudes (booleans)
        'responsabilidad','puntualidad','proactividad','equipo','creatividad','liderazgo',
        'conciliador','perseverancia','asertividad','relaciones','objetivos','saludable'
    ];

    public static $actitudes_names = [
        'responsabilidad','puntualidad','proactividad','equipo','creatividad','liderazgo',
        'conciliador','perseverancia','asertividad','relaciones','objetivos','saludable'
    ];

    /**
     * Relacion 1:1 con Alumno (inversa)
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

}
