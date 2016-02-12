<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     * Lista de alumnos [JSON]
     * Si usuario es empresa o admin, se listan todos
     * Si usuario es escuela se listan sólo los de la escuela
     *
     * URL: /alumnos [GET]
     *
     * Puede incluir los siguientes filtros o num pag (parametros en request)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lista(Request $request)
    {
        return response()->json(['status' => 'ok','accion'=> 'lista']);
    }

    /**
     * Muestra pantalla creación de Alumno / Curriculum
     *
     * URL: /alumnos/nuevo [GET]
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
        return response()->json(['status' => 'ok','accion'=> 'get nuevo']);
    }

    /**
     * Procesa POST nuevo Alumno / Curriculum y guarda en la BD.
     *
     * URL: /alumnos/nuevo [POST]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(['status' => 'ok','accion'=> 'post nuevo']);
    }

    /**
     * Muestra pantalla alumno / curriculum creado.
     *
     * URL: /alumnos/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['status' => 'ok','accion'=> 'show alumno']);
    }

    /**
     * Muestra pantalla con form para editar alumno / curriculum.
     *
     * URL: /alumnos/edit/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(['status' => 'ok','accion'=> 'get edit alumno']);
    }

    /**
     * Procesa POST edicion de Alumno / Curriculum y actualiza en la BD.
     *
     * URL: /alumnos/edit/{id} [POST]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json(['status' => 'ok','accion'=> 'post edit alumno']);
    }

    /**
     * Elimina alumno
     *
     * URL: /alumnos/delete/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['status' => 'ok','accion'=> 'delete alumno']);
    }

}
