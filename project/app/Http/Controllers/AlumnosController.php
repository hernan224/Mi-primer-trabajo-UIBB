<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use Gate;
use Auth;
use DB;
use Illuminate\Database\Query\Builder;
use PDF;
use Illuminate\Http\Request;
use App\Http\Requests\PostAlumnoRequest;
use App\Models\Alumno;
use App\Models\Curriculum;
use App\Models\Escuela;

// Actions para listado, carga, edicion y eliminación de CVs de alumnos.
class AlumnosController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware('auth'); (definido en routes)
    }

    /**
     * Muestra pantalla listado pùblico de alumnos (sin data: la obtiene por AJAX)
     * URL: /listado-alumnos
     */
    public function showListado() {
        $escuelas = Escuela::all();
        $view_data = [
            'admin_escuela' => false,
            'urls' => [
                'get_list' =>  route('alumnos_public_list'),
                'search' => route('alumnos_public_search'),
                'fotos' => asset(Alumno::$image_path),
                'show' => route('alumno_show'),
                'edit' => false,
                'delete' => false
            ],
            'escuelas' => $escuelas
        ];
        return view('alumnos.listado',$view_data);
    }

    /**
     * Muestra pantalla listado de alumnos de escuela para administrar (sin data: la obtiene por AJAX)
     * URL: /administrar-alumnos
     */
    public function showListadoEscuela() {
        $escuelas = Escuela::all();
        $view_data = [
            'admin_escuela' => true,
            'urls' => [
                'get_list' =>  route('escuela.alumnos_list'),
                'search' => route('escuela.alumnos_search'),
                'fotos' => asset(Alumno::$image_path),
                'show' => route('alumno_show'),
                'edit' => route('escuela.alumno_edit'),
                'delete' => route('escuela.alumno_delete')
            ],
            'escuelas' => $escuelas
        ];
        return view('alumnos.listado',$view_data);
    }

    /**
     * Lista de alumnos publicos [JSON]
     * Si usuario es empresa o admin, se listan todos
     *
     * URL: /alumnos [GET]
     *
     * Puede incluir filtros, ordenamiento o num pag (parametros en request):
     *     page=<number> : es interpretada automaticamente al invocar paginate() en la query
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  boolean  $admin_escuela si es true, se buscan solo los alumnos de la escuela
     * @return \Illuminate\Http\Response
     */
    public function lista(Request $request, $admin_escuela = false){
        $select_array = [
            'alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.nacimiento',
            'alumnos.localidad','alumnos.barrio','alumnos.foto','alumnos.sexo','alumnos.privado',
            'escuelas.id as escuela_id', 'escuelas.name as escuela',
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
        // Si es request de listado de admin escuela, sólo busca los alumnos de su escuela.
        if ($admin_escuela) {
            $escuela_id = Auth::user()->escuela_id;
            $where_array[] = ['alumnos.escuela_id',$escuela_id];
        }
        else {
            // si no, solo los publicos
            $query->where('alumnos.privado',false);
        }

        // filtros
        $this->lista_filtros($request,$where_array);

        if(count($where_array)) {
            $query->where($where_array);
        }

        // Ordenamiento
        $this->lista_ordenamiento($request,$query);

        return $query->paginate(21); // retorna JSON automáticamente, paginando el resultado
    }

    /**
     * Lista de alumnos de escuela (logueada) [JSON]
     * URL: /alumnos-escuela
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listaEscuela(Request $request){
        return $this->lista($request,true);
    }

    private function lista_filtros(Request $request,&$where_array) {
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

        $escuela_id = $request->query('esc');
        if ($escuela_id && is_numeric($escuela_id)) {
            $where_array[] = ['escuelas.id',$escuela_id];
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

    private function lista_ordenamiento(Request $request,$query) {
        /** @var Builder $query */
        $ordenamiento = $request->query('order');

        if ($ordenamiento == 'fecha_asc')
            $query->orderBy('curriculums.updated_at','ASC');
        else if ($ordenamiento == 'fecha_desc')
            $query->orderBy('curriculums.updated_at','DESC');

        else if ($ordenamiento == 'prom_asc')
            $query->orderBy('curriculums.promedio','ASC');
        else if ($ordenamiento == 'prom_desc')
            $query->orderBy('curriculums.promedio','DESC');

        else if ($ordenamiento == 'esp_asc')
            $query->orderBy('curriculums.especialidad','ASC');
        else if ($ordenamiento == 'esp_desc')
            $query->orderBy('curriculums.especialidad','DESC');

        else if ($ordenamiento == 'esc_asc')
            $query->orderBy('escuela','ASC');
        else if ($ordenamiento == 'esc_desc')
            $query->orderBy('escuela','DESC');

        else if ($ordenamiento == 'doc_asc')
            $query->orderBy('docente','ASC');
        else if ($ordenamiento == 'doc_desc')
            $query->orderBy('docente','DESC');

        else if ($ordenamiento == 'nac_asc')
            $query->orderBy('alumnos.nacimiento','ASC');
        else if ($ordenamiento == 'nac_desc')
            $query->orderBy('alumnos.nacimiento','DESC');

        else if ($ordenamiento == 'loc_asc')
            $query->orderBy('alumnos.localidad','ASC');
        else if ($ordenamiento == 'loc_desc')
            $query->orderBy('alumnos.localidad','DESC');

        else if ($ordenamiento == 'bar_asc')
            $query->orderBy('alumnos.barrio','ASC');
        else if ($ordenamiento == 'bar_desc')
            $query->orderBy('alumnos.barrio','DESC');

        else if ($ordenamiento == 'ape_desc')
            $query->orderBy('alumnos.apellido','DESC');

        // Como segundo ordenamiento siempre elijo el apellido
        $query->orderBy('alumnos.apellido','ASC');
    }

    /**
     * Busqueda dealumnos publicos [JSON]
     *
     * URL: /alumnos/search [GET]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  boolean  $admin_escuela si es true, se buscan solo los alumnos de la escuela
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request,$admin_escuela = false) {
        $select_array = [
            'alumnos.id','alumnos.nombre','alumnos.apellido','curriculums.especialidad',
            'escuelas.name as escuela',
        ];

        $query = DB::table('alumnos')
            ->leftJoin('curriculums','alumnos.id','=','curriculums.alumno_id')
            ->leftJoin('escuelas','alumnos.escuela_id','=','escuelas.id')
            ->select($select_array);

        if ($admin_escuela) {
            // Sólo busca los alumnos de la escuela.
            $escuela_id = Auth::user()->escuela_id;
            $query->where('alumnos.escuela_id',$escuela_id);
        }
        else {
            // solo los publicos
            $query->where('alumnos.privado',false);
        }

        $alumnos = $query->get();
        $busqueda = [];
        $cant = 0;
        $max_results = 5;

        $search = $request->query('q');

        if ($search) {
            $search = strtolower($search);
            foreach ($alumnos as $alumno) {
                $nombre_apellido = strtolower($alumno->nombre.' '.$alumno->apellido);
                $especialidad = strtolower($alumno->especialidad);
                if(strpos($nombre_apellido, $search) !== false || strpos($especialidad,$search) !== false) {
                    $busqueda[] = $alumno;
                    $cant ++;
                    if ($cant == $max_results) {
                        break;
                    }
                }
            }
        }
        else {
            $busqueda = array_slice($alumnos,0,$max_results);
        }

        return response()->json($busqueda);
    }

    /**
     * Busqueda de alumnos de escuela (logueada) [JSON]
     * URL: /alumnos-escuela/search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchEscuela(Request $request){
        return $this->lista($request,true);
    }

    /**
     * Muestra pantalla alumno / curriculum creado.
     *
     * URL: /alumnos/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (!$id) {
            return redirect()->route('alumnos_public');
        }
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('alumnos_public');
        }
        // autorizo accion si alumno no es publico: sólo alumno de escuela
        if ($alumno->privado && Gate::denies('show-alumno-privado', $alumno)) {
            return abort(403);
        }
        $view_data = [
            'id' => $id,
            'alumno' => $alumno,
            'editable' => false
        ];
        // parametro editable: si usuario es escuela del alumno
        $user = Auth::user();
        if ($user && $user->hasRole('escuela') && $user->escuela->id == $alumno->escuela_id) {
            $view_data['editable'] = true;
        }
        return view('alumnos.show',$view_data);
    }

    /**
     * Genera PDF de alumno
     *
     * URL: /alumnos/{id}/pdf [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id = null)
    {
        if (!$id) {
            return abort(403);
        }
        /** @var Alumno $alumno */
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return abort(403);
        }
        // autorizo accion si alumno no es publico: sólo alumno de escuela
        if ($alumno->privado && Gate::denies('show-alumno-privado', $alumno)) {
            return abort(403);
        }
        $view_data = [
            'id' => $id,
            'alumno' => $alumno,
            'pdf' => true,
            'editable' => false
        ];
        // parametro editable: si usuario es escuela del alumno
        $user = Auth::user();
        if ($user && $user->hasRole('escuela') && $user->escuela->id == $alumno->escuela_id) {
            $view_data['editable'] = true;
        }
        $pdf = PDF::loadView('alumnos.show_pdf', $view_data);
        $filename = $alumno->getFullName().'.pdf';
        return $pdf->download($filename);
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
     * @param  PostAlumnoRequest  $request
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
        /** @var Alumno $alumno */
        $alumno = $escuela->alumnos()->create($data_alumno);
        // creo y guardo curriculum, asociado al alumno
        $alumno->curriculum()->create($data_curriculum);
        // asocio docente
        $alumno->docente()->associate($docente);

        // guardo imagen en el server si la envió, usando el id del alumno creado y un string aleatorio
        $this->saveImage($request,$alumno);

        $alumno->save();

        // redirigir a show
        // return redirect()->route('alumno_show',['id'=> $alumno->id]);
        // redirigir a lista alumnos escuela
        return redirect()->route('escuela.admin_alumnos');
    }

    /**
     * Muestra pantalla con form para editar alumno / curriculum.
     *
     * URL: /alumnos/edit/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->route('escuela.admin_alumnos');
        }
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('escuela.admin_alumnos');
        }
        // autorizo accion (solo para escuela de ese alumno)
        if (Gate::denies('edit-alumno', $alumno)) {
            return abort(403);
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
     * URL: /administrar-alumnos/edit/{id} [POST]
     *
     * @param  PostAlumnoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostAlumnoRequest $request, $id)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action edit())

        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('escuela.admin_alumnos');
        }
        // autorizo accion (solo para escuela de ese alumno)
        if (Gate::denies('edit-alumno', $alumno)) {
            return abort(403);
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
        return redirect()->route('alumno_show',['id'=> $alumno->id]);

    }

    /**
     * Elimina alumno
     *
     * URL: /alumnos/delete/{id}
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        if (!$id) {
            return redirect()->route('escuela.admin_alumnos');
        }
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return redirect()->route('escuela.admin_alumnos');
        }
        // autorizo accion (solo para escuela de ese alumno)
        if (Gate::denies('edit-alumno', $alumno)) {
            return abort(403);
        }
        $alumno->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'ok']);
        }
        else {
            return redirect()->route('escuela.admin_alumnos');
        }
    }

    /************************************************************************************
     * METODOS AUXILIARES
     */

    /**
     * Convierte date recibida al formato que se guarda en BD
     * @param $data_alumno
     */
    protected function parseDate(&$data_alumno) {
        $date_input = isset($data_alumno['nacimiento']) ? $data_alumno['nacimiento'] : null;
        if ($date_input) {
            // Transformo date
            $data_alumno['nacimiento'] = \DateTime::createFromFormat('d/m/Y',$date_input)->format('Y-m-d');
        }
        else {
            $data_alumno['nacimiento'] = null;
        }
    }

    protected function getDataPostAlumno(Request $request) {
        // Obtengo nombres de atributo de alumno
        $alumno_temp = new Alumno;
        $atributos_alumno = $alumno_temp->getFillable();
        // data recibida del post, correspondiente al modelo alumno
        $data_alumno = $request->only($atributos_alumno);
        // convierto fecha de nacimiento al formato a guardar
        $this->parseDate($data_alumno);

        $check_privado = isset($data_alumno['privado']) ? $data_alumno['privado'] : false;
        $data_alumno['privado'] = ($check_privado && $check_privado == 'si');

        if (!isset($data_alumno['dni']) || !$data_alumno['dni']) {
            $data_alumno['dni'] = null;
        }

        return $data_alumno;
    }

    protected function getDataPostCurriculum(Request $request) {
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

        $estudios = isset($data_curriculum['estudios']) ? $data_curriculum['estudios'] : false;
        $data_curriculum['estudios'] = ($estudios && $estudios == 'si');

        return $data_curriculum;
    }

    protected function saveImage(Request $request,$alumno) {
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
