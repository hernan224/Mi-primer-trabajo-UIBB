<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'especialidad','promedio','asignaturas','practicas_tipo','practicas_lugar',
        // actitudes (booleans)
        'responsabilidad','puntualidad','proactividad','equipo','creatividad','liderazgo',
        'conciliador','perseverancia','asertividad','relaciones','objetivos','saludable',
        'extra','participacion','carta_presentacion'
    ];

    /**
     * Relacion 1:1 con Alumno (inversa)
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

}
