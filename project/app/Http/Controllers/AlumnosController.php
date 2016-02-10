<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

// Actions para listado, carga, edicion y eliminación de CVs de alumnos.
class AlumnosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth'); (definido en routes)
    }

    /**
     * Muestra pantalla con listado de alumnos.
     * Depende del rol de usuario.
     *
     * URL: /alumnos
     *
     * @return \Illuminate\Http\Response
     */
    public function listado()
    {
        return view('alumnos.listado');
    }
}
