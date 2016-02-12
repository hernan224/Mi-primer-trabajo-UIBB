<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PostAlumnoRequest;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Curriculum;

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
     * Muestra pantalla alumno / curriculum creado.
     *
     * URL: /alumnos/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ToDo autorizar: si es escuela y no es alumno de la escuela, lanzar error
        $view_data = [
            'nuevo' => false,
            'id' => $id
        ];
        return view('alumnos.show',$view_data);
    }

    /**
     * Muestra pantalla creación de Alumno / Curriculum
     *
     * URL: /alumnos/nuevo [GET] - Solo para rol escuela (middleware agregado en routes)
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
        $alumno = new Alumno;
        $curriculum = new Curriculum;
        $alumno->curriculum = $curriculum;
        $view_data = [
            'nuevo' => true,
            'alumno' => $alumno
        ];
        return view('alumnos.form',$view_data);
    }

    /**
     * Procesa POST nuevo Alumno / Curriculum y guarda en la BD.
     *
     * URL: /alumnos/nuevo [POST]
     *
     * @param  \Illuminate\Http\PostAlumnoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostAlumnoRequest $request)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action nuevo())

        // Obtengo nombres de atributo de alumno
        $alumno_temp = new Alumno;
        $atributos_alumno = $alumno_temp->getFillable();
        // data recibida del post, correspondiente al modelo alumno
        $data_alumno = $request->only($atributos_alumno);
        // convierto fecha de nacimiento al formato a guardar
        $this->parseDate($data_alumno);

        // asocio docente y escuela
        $docente = $request->user();
        $escuela = $docente->escuela;

        // creo alumno, asociado a la escuela
        $alumno = $escuela->alumnos()->create($data_alumno);
        // asocio docente
        $alumno->docente()->associate($docente);
        $alumno->save();

        // redirigir a show
        return redirect()->route('alumnos.show',['id'=> $alumno->id]);
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
        $alumno = new Alumno;
        // ToDo get alumno, si no hay o falla autorizacion, tirar apntalla forbidden: https://laravel.com/docs/5.2/authorization
        $view_data = [
            'nuevo' => false,
            'id' => $id,
            'alumno' => $alumno
        ];
        return view('alumnos.form',$view_data);
    }

    /**
     * Procesa POST edicion de Alumno / Curriculum y actualiza en la BD.
     *
     * URL: /alumnos/edit/{id} [POST]
     *
     * @param  \Illuminate\Http\PostAlumnoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostAlumnoRequest $request, $id)
    {
        $alumno = new Alumno;
        // ToDo get alumno, si no hay o falla autorizacion, tirar pantalla forbidden: https://laravel.com/docs/5.2/authorization

        // redirigir a show
        $view_data = [
            'nuevo' => true,
            'id' => $id,
            'alumno' => null
        ];
        return view('alumnos.form',$view_data);
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

    // Convierte date recibida al formato que se guarda en BD
    protected function parseDate(&$data_alumno) {
        $date_input = $data_alumno['nacimiento'];
        // Transformo date
        $data_alumno['nacimiento'] = \DateTime::createFromFormat('d/m/Y',$date_input)->format('Y-m-d');
    }

}
