<?php

namespace App\Http\Controllers;

use Gate;
use Auth;
use DB;
use Illuminate\Http\Request;
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
     * Puede incluir los siguientes filtros, ordenamiento o num pag (parametros en request):
     *
     *
     * page=<number> : es interpretada automaticamente al invcar paginate() en la query
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lista(Request $request)
    {
        $select_array = [
            'alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.nacimiento','alumnos.localidad','alumnos.barrio',
            'escuelas.name as escuela',
            'users.name as docente',
            'curriculums.especialidad','curriculums.promedio','curriculums.updated_at',
        ];
        if(trim($request->query('actit'))) { // si quiere filtrar por actitudes, debo seleccionarlas
            $select_array = array_merge($select_array,[
                'curriculums.responsabilidad','curriculums.puntualidad','curriculums.proactividad',
                'curriculums.equipo','curriculums.creatividad','curriculums.liderazgo',
                'curriculums.conciliador','curriculums.perseverancia','curriculums.asertividad',
                'curriculums.relaciones','curriculums.objetivos','curriculums.saludable'
            ]);
        }

        $query = DB::table('alumnos')
            ->leftJoin('curriculums','alumnos.id','=','curriculums.alumno_id')
            ->leftJoin('escuelas','alumnos.escuela_id','=','escuelas.id')
            ->leftJoin('users','alumnos.docente_id','=','users.id')
            ->select($select_array);

        $where_array = [];
        // Si usuario es docente, sólo busca los alumnos de su escuela.
        if (Auth::user()->hasRole('escuela')) {
            $escuela_id = Auth::user()->escuela_id;
            $where_array[] = ['alumnos.escuela_id',$escuela_id];
        }
        // filtros
        $this->lista_filtros($request,$where_array);

        if(count($where_array)) {
            $query->where($where_array);
        }

        // Ordenamiento
        $this->lista_ordenamiento($request,$query);

        return $query->paginate(5); // retorna JSON automáticamente, paginando el resultado
    }

    private function lista_filtros($request,&$where_array) {
        $promedio_min = $request->query('prom_min');
        if ($promedio_min && is_numeric($promedio_min)) {
            $where_array[] = ['curriculums.promedio','>=',$promedio_min];
        }

        $promedio_max = $request->query('prom_max');
        if ($promedio_max && is_numeric($promedio_max)) {
            $where_array[] = ['curriculums.promedio','<=',$promedio_max];
        }

        $especialidad = trim(filter_var($request->query('esp'),FILTER_SANITIZE_STRING));
        if ($especialidad) {
            $where_array[] = ['curriculums.especialidad','LIKE','%'.$especialidad.'%'];
        }

        $escuela = trim(filter_var($request->query('esc'),FILTER_SANITIZE_STRING));
        if ($escuela) {
            $where_array[] = ['escuelas.name','LIKE','%'.$escuela.'%'];
        }

        $localidad = trim(filter_var($request->query('loc'),FILTER_SANITIZE_STRING));
        if ($localidad) {
            $where_array[] = ['alumnos.localidad','LIKE','%'.$localidad.'%'];
        }

        $barrio = trim(filter_var($request->query('bar'),FILTER_SANITIZE_STRING));
        if ($barrio) {
            $where_array[] = ['alumnos.barrio','LIKE','%'.$barrio.'%'];
        }

        $actitudes = trim(filter_var($request->query('actit'),FILTER_SANITIZE_STRING));
        if ($actitudes) {
            $array_actitudes = explode(',',$actitudes);
            foreach (Curriculum::$actitudes_names as $actitud) {
                if (in_array($actitud,$array_actitudes)) {
                    $where_array[] = ['curriculums.'.$actitud,true];
                }
            }
        }
    }

    private function lista_ordenamiento($request,$query) {
        $ordenamiento = $request->query('order');

        if ($ordenamiento == 'fecha')
            $query->orderBy('curriculums.updated_at','ASC');
        else if ($ordenamiento == 'fecha_desc')
            $query->orderBy('curriculums.updated_at','DESC');

        else if ($ordenamiento == 'prom')
            $query->orderBy('curriculums.promedio','ASC');
        else if ($ordenamiento == 'prom_desc')
            $query->orderBy('curriculums.promedio','DESC');

        else if ($ordenamiento == 'esp')
            $query->orderBy('curriculums.especialidad','ASC');
        else if ($ordenamiento == 'esp_desc')
            $query->orderBy('curriculums.especialidad','DESC');

        else if ($ordenamiento == 'esc')
            $query->orderBy('escuela','ASC');
        else if ($ordenamiento == 'esc_desc')
            $query->orderBy('escuela','DESC');

        else if ($ordenamiento == 'doc')
            $query->orderBy('docente','ASC');
        else if ($ordenamiento == 'doc_desc')
            $query->orderBy('docente','DESC');

        else if ($ordenamiento == 'nac')
            $query->orderBy('alumnos.nacimiento','ASC');
        else if ($ordenamiento == 'nac_desc')
            $query->orderBy('alumnos.nacimiento','DESC');

        else if ($ordenamiento == 'loc')
            $query->orderBy('alumnos.localidad','ASC');
        else if ($ordenamiento == 'loc_desc')
            $query->orderBy('alumnos.localidad','DESC');

        else if ($ordenamiento == 'bar')
            $query->orderBy('alumnos.barrio','ASC');
        else if ($ordenamiento == 'bar_desc')
            $query->orderBy('alumnos.barrio','DESC');

        else if ($ordenamiento == 'ape_desc')
            $query->orderBy('alumnos.apellido','DESC');

        // Como segundo ordenamiento siempre elijo el apellido
        $query->orderBy('alumnos.apellido','ASC');
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
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('alumnos.listado');
        }
        // autorizo accion (solo para escuela de ese alumno, o para cualquier empresa)
        if (Gate::denies('show-alumno', $alumno)) {
            return response('No autorizado', 403);
        }
        $view_data = [
            'id' => $id,
            'alumno' => $alumno
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

        $data_alumno = $this->getDataPostAlumno($request);
        $data_curriculum = $this->getDataPostCurriculum($request);

        // obtengo docente y escuela (esta accion sólo está autorizada para escuela)
        $docente = Auth::user();
        $escuela = $docente->escuela;

        // creo y guardo alumno, asociado a la escuela
        $alumno = $escuela->alumnos()->create($data_alumno);
        // creo y guardo curriculum, asociado al alumno
        $alumno->curriculum()->create($data_curriculum);
        // asocio docente
        $alumno->docente()->associate($docente);

        // guardo imagen en el server si la envió, usando el id del alumno creado y un string aleatorio
        $this->saveImage($request,$alumno);

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
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('alumnos.listado');
        }
        // autorizo accion (solo para escuela de ese alumno)
        if (Gate::denies('edit-alumno', $alumno)) {
            return response('No autorizado', 403);
        }
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
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action edit())

        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('alumnos.listado');
        }
        // autorizo accion (solo para escuela de ese alumno)
        if (Gate::denies('edit-alumno', $alumno)) {
            return response('No autorizado', 403);
        }

        $data_alumno = $this->getDataPostAlumno($request);
        $data_curriculum = $this->getDataPostCurriculum($request);

        // actualizo data alumno
        $alumno->update($data_alumno);
        // actualizo data curriculum
        $alumno->curriculum->update($data_curriculum);
        $this->saveImage($request,$alumno); // guarda imagen de perfil si hay
        $alumno->save();

        // redirigir a show
        return redirect()->route('alumnos.show',['id'=> $alumno->id]);

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

    /************************************************************************************
     * METODOS AUXILIARES
     */

    // Convierte date recibida al formato que se guarda en BD
    protected function parseDate(&$data_alumno) {
        $date_input = $data_alumno['nacimiento'];
        // Transformo date
        $data_alumno['nacimiento'] = \DateTime::createFromFormat('d/m/Y',$date_input)->format('Y-m-d');
    }

    protected function getDataPostAlumno($request) {
        // Obtengo nombres de atributo de alumno
        $alumno_temp = new Alumno;
        $atributos_alumno = $alumno_temp->getFillable();
        // data recibida del post, correspondiente al modelo alumno
        $data_alumno = $request->only($atributos_alumno);
        // convierto fecha de nacimiento al formato a guardar
        $this->parseDate($data_alumno);

        return $data_alumno;
    }

    protected function getDataPostCurriculum($request) {
        // Obtengo nombres de atributo de alumno
        $curriculum_temp = new Curriculum;
        $atributos_curriculum = $curriculum_temp->getFillable();
        // data recibida del post, correspondiente al modelo alumno
        $data_curriculum = $request->only($atributos_curriculum);
        //agrego actitudes
        $actitudes_check = $request->input('actitudes');
        if(!$actitudes_check)
            $actitudes_check = [];
        foreach (Curriculum::$actitudes_names as $actitud) {
            $data_curriculum[$actitud] = (in_array($actitud,$actitudes_check));
        }
        return $data_curriculum;
    }

    protected function saveImage($request,$alumno) {
        // guardo imagen en el server, usando el id del alumno creado y un string aleatorio
        if($request->hasFile('foto') && $request->file('foto')->isValid() ) {
            $file = $request->file('foto');
            $foto_name = $alumno->id. '_' . str_random(8) . '.' .
                $file->getClientOriginalExtension();
            $file->move(public_path(Alumno::$image_path),$foto_name);
            $alumno->foto = $foto_name;
        }
    }

}
