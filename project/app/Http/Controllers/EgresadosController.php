<?php

namespace App\Http\Controllers;

use Gate;
use Auth;
use DB;
use Illuminate\Database\Query\Builder;
use PDF;
use Illuminate\Http\Request;
use App\Http\Requests\PostEgresadoRequest;
use App\Models\Egresado;
use App\Models\Curriculum;
use App\Models\Institucion;

// Actions para listado, carga, edicion y eliminación de CVs de egresados.
class EgresadosController extends Controller
{
    /**
     * Muestra pantalla listado público de egresados del tipo indiccado (sin data: la obtiene por AJAX de lista)
     *
     * Route: egresados - URL: /egresados/{tipo} [GET]
     *  Tipo puede ser tecnicos u oficios
     *
     * @param string $tipo constante (label) definida en Egresado
     * @return \Illuminate\View\View
     */
    public function showListado($tipo) {

        if (!in_array($tipo,Egresado::TIPOS_LABELS)) {
            return abort(404);
        }

        $instituciones = Institucion::all();
        $view_data = [
            'tipo' => $tipo,
            'admin_institucion' => false,
            'urls' => [
                'get_list' => route('egresados_list',['tipo' => $tipo]),
                'search' => route('egresados_search',['tipo' => $tipo]),
                'fotos' => asset(Egresado::$image_path),
                'show' => route('egresado_show'),
                'edit' => false,
                'delete' => false
            ],
            'instituciones' => $instituciones
        ];
        return view('egresados.listado',$view_data);
    }

    /**
     * Muestra pantalla listado de egresados de institucion logueada para administrar
     *  (sin data: la obtiene por AJAX de listaInstitucion)
     * Route: institucion.admin_egresados - URL: /administrar-egresados  [GET, role institucion]
     *
     * En el routing se utiliza el middleware auth y role:institucion,
     *      que asegura que haya usuario con role institución logueado
     */
    public function showListadoInstitucion() {

        // obtengo docente y institucion para obtener tipo (esta accion sólo está autorizada para institucion)
        $docente = Auth::user();
        $tipo_egresados = $docente->institucion->getTipoEgresadosLabel();

        $instituciones = Institucion::all();
        $view_data = [
            'tipo' => $tipo_egresados,
            'admin_institucion' => true,
            'urls' => [
                'get_list' =>  route('institucion.egresados_list'),
                'search' => route('institucion.egresados_search'),
                'fotos' => asset(Egresado::$image_path),
                'show' => route('egresado_show'),
                'edit' => route('institucion.egresado_edit'),
                'delete' => route('institucion.egresado_delete')
            ],
            'instituciones' => $instituciones
        ];

        return view('egresados.listado',$view_data);
    }

    /**
     * Lista de egresados publicos [JSON]
     * Si usuario es empresa o admin, se listan todos
     * Route: egresados_public_list - URL: /egresados [GET]
     *      Parametros GET:
     *      Puede incluir filtros, ordenamiento o num pag (parametros en request):
     *      page=<number> : es interpretada automaticamente al invocar paginate() en la query
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $tipo constante (label) definida en Egresado - No se indica si admin_institucion es true
     * @param  boolean $admin_institucion si es true, se buscan solo los egresados de la institución
     * @return \Illuminate\Http\Response
     */
    public function lista(Request $request, $tipo, $admin_institucion = false){
        if (!$admin_institucion && !in_array($tipo,Egresado::TIPOS_LABELS)) {
            // Chequeo de tipo válido si no son los egresados de la institución
            return abort(404);
        }

        $select_array = [
            'egresados.id','egresados.nombre','egresados.apellido','egresados.nacimiento',
            'egresados.localidad','egresados.barrio','egresados.foto','egresados.sexo','egresados.privado',
            'instituciones.id as institucion_id', 'instituciones.name as institucion',
            'users.name as docente',
            'curriculums.rubro','curriculums.especialidad','curriculums.promedio','curriculums.updated_at',
        ];
        if(trim($request->query('actit'))) { // si quiere filtrar por actitudes, debo seleccionarlas
            $select_array = array_merge($select_array,[
                'curriculums.responsabilidad','curriculums.puntualidad','curriculums.proactividad',
                'curriculums.equipo','curriculums.creatividad','curriculums.liderazgo',
                'curriculums.conciliador','curriculums.perseverancia','curriculums.asertividad',
                'curriculums.relaciones','curriculums.objetivos','curriculums.saludable'
            ]);
        }

        $query = DB::table('egresados')
            ->leftJoin('curriculums','egresados.id','=','curriculums.egresado_id')
            ->leftJoin('instituciones','egresados.institucion_id','=','instituciones.id')
            ->leftJoin('users','egresados.docente_id','=','users.id')
            ->select($select_array);

        $where_array = [];
        // Si es request de listado de admin institucion, sólo busca los egresados de su institucion.
        if ($admin_institucion) {
            $institucion_id = Auth::user()->institucion_id;
            $where_array[] = ['egresados.institucion_id',$institucion_id];
        }
        else {
            // si no, sólo los publicos del tipo indicado
            $where_array[] = ['egresados.privado', false];
            $where_array[] = ['egresados.tipo', Egresado::TIPOS_MAP[$tipo] ];
        }

        // filtros
        $this->lista_filtros($request,$where_array);

        if(count($where_array)) {
            $query->where($where_array);
        }

        // Ordenamiento
        $this->lista_ordenamiento($request,$query);

        return $query->paginate(18); // retorna JSON automáticamente, paginando el resultado
    }

    /**
     * Lista de egresados de institución (logueada) [JSON]
     * Route: institucion.egresados_list - URL: /egresados-institucion [GET, role institucion]
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listaInstitucion(Request $request){
        // No se define tipo ya que se obtienen los egresados de la institución
        return $this->lista($request,null,true);
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

        $institucion_id = $request->query('inst');
        if ($institucion_id && is_numeric($institucion_id)) {
            $where_array[] = ['instituciones.id',$institucion_id];
        }

        $localidad = trim(filter_var($request->query('loc'),FILTER_SANITIZE_STRING));
        if ($localidad) {
            $where_array[] = ['egresados.localidad','LIKE','%'.$localidad.'%'];
        }

        $barrio = trim(filter_var($request->query('bar'),FILTER_SANITIZE_STRING));
        if ($barrio) {
            $where_array[] = ['egresados.barrio','LIKE','%'.$barrio.'%'];
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

        else if ($ordenamiento == 'rub_asc')
            $query->orderBy('curriculums.rubro','ASC');
        else if ($ordenamiento == 'rub_desc')
            $query->orderBy('curriculums.rubro','DESC');

        else if ($ordenamiento == 'esp_asc')
            $query->orderBy('curriculums.especialidad','ASC');
        else if ($ordenamiento == 'esp_desc')
            $query->orderBy('curriculums.especialidad','DESC');

        else if ($ordenamiento == 'esc_asc')
            $query->orderBy('institucion','ASC');
        else if ($ordenamiento == 'esc_desc')
            $query->orderBy('institucion','DESC');

        else if ($ordenamiento == 'doc_asc')
            $query->orderBy('docente','ASC');
        else if ($ordenamiento == 'doc_desc')
            $query->orderBy('docente','DESC');

        else if ($ordenamiento == 'nac_asc')
            $query->orderBy('egresados.nacimiento','ASC');
        else if ($ordenamiento == 'nac_desc')
            $query->orderBy('egresados.nacimiento','DESC');

        else if ($ordenamiento == 'loc_asc')
            $query->orderBy('egresados.localidad','ASC');
        else if ($ordenamiento == 'loc_desc')
            $query->orderBy('egresados.localidad','DESC');

        else if ($ordenamiento == 'bar_asc')
            $query->orderBy('egresados.barrio','ASC');
        else if ($ordenamiento == 'bar_desc')
            $query->orderBy('egresados.barrio','DESC');

        else if ($ordenamiento == 'ape_desc')
            $query->orderBy('egresados.apellido','DESC');

        // Como segundo ordenamiento siempre elijo el apellido
        $query->orderBy('egresados.apellido','ASC');
    }

    /**
     * Busqueda de egresados publicos [JSON]
     * Route: egresados_public_search - URL: /egresados/search [GET]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $tipo constante (label) definida en Egresado - No se indica si admin_institucion es true
     * @param  boolean  $admin_institucion si es true, se buscan solo los egresados de la institucion
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $tipo, $admin_institucion = false) {
        if (!$admin_institucion && !in_array($tipo,Egresado::TIPOS_LABELS)) {
            // Chequeo de tipo válido si no son los egresados de la institución
            return abort(404);
        }

        $select_array = [
            'egresados.id','egresados.nombre','egresados.apellido','curriculums.especialidad',
            'instituciones.name as institucion',
        ];

        $query = DB::table('egresados')
            ->leftJoin('curriculums','egresados.id','=','curriculums.egresado_id')
            ->leftJoin('instituciones','egresados.institucion_id','=','instituciones.id')
            ->select($select_array);

        if ($admin_institucion) {
            // Sólo busca los egresados de la institucion.
            $institucion_id = Auth::user()->institucion_id;
            $query->where('egresados.institucion_id',$institucion_id);
        }
        else {
            // solo los publicos del tipo indicado
            $query->where('egresados.privado',false);
            $query->where('egresados.tipo', Egresado::TIPOS_MAP[$tipo]);
        }

        $egresados = $query->get();
        $busqueda = [];
        $cant = 0;
        $max_results = 5;

        $search = $request->query('q');

        if ($search) {
            $search = strtolower($search);
            foreach ($egresados as $egresado) {
                $nombre_apellido = strtolower($egresado->nombre.' '.$egresado->apellido);
                $especialidad = strtolower($egresado->especialidad);
                if(strpos($nombre_apellido, $search) !== false || strpos($especialidad,$search) !== false) {
                    $busqueda[] = $egresado;
                    $cant ++;
                    if ($cant == $max_results) {
                        break;
                    }
                }
            }
        }
        else {
            $busqueda = array_slice($egresados,0,$max_results);
        }

        return response()->json($busqueda);
    }

    /**
     * Busqueda de egresados de institucion (logueada) [JSON]
     * Route: institucion.egresados_search - URL: /egresados-institucion/search [GET, role institucion]
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchInstitucion(Request $request){
        // No se define tipo ya que se obtienen los egresados de la institución
        return $this->lista($request,null,true);
    }

    /**
     * Muestra pantalla egresado / curriculum creado (vista o edición)
     *      El egresado puede ser de cualquiera de los dos tipos, ya que se usa el id
     * Route: egresado_show - URL: /egresados/{id} [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $egresado = Egresado::find($id);
        if (!$egresado) {
            return abort(404);
        }
        // autorizo accion si egresado no es público: sólo egresado de institucion
        if ($egresado->privado && Gate::denies('show-egresado-privado', $egresado)) {
            return abort(403);
        }
        $view_data = [
            'id' => $id,
            'egresado' => $egresado,
            'editable' => false,
            'url_back' => route('egresados', ['tipo' => $egresado->getTipoLabel()])
        ];
        // parametro editable: si usuario es institucion del egresado, muestra link de edición
        $user = Auth::user();
        if ($user && $user->hasRole('institucion') && $user->institucion->id == $egresado->institucion_id) {
            $view_data['editable'] = true;
            $view_data['url_back'] = route('institucion.admin_egresados');
        }
        return view('egresados.show',$view_data);
    }

    /**
     * Genera PDF de egresado
     * Route: egresado_pdf - URL: /egresados/{id}/pdf [GET]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id = null)
    {
        if (!$id) {
            return abort(403);
        }
        /** @var Egresado $egresado */
        $egresado = Egresado::find($id);
        if (!$egresado) {
            return abort(403);
        }
        // autorizo accion si egresado no es publico: sólo egresado de institucion
        if ($egresado->privado && Gate::denies('show-egresado-privado', $egresado)) {
            return abort(403);
        }
        $view_data = [
            'id' => $id,
            'egresado' => $egresado,
            'pdf' => true,
            'editable' => false
        ];
        // parametro editable: si usuario es institucion del egresado
        $user = Auth::user();
        if ($user && $user->hasRole('institucion') && $user->institucion->id == $egresado->institucion_id) {
            $view_data['editable'] = true;
        }
        $pdf = PDF::loadView('egresados.show_pdf', $view_data);
        $filename = $egresado->getFullName().'.pdf';
        return $pdf->download($filename);
    }

    /**
     * Muestra pantalla creación de Egresado / Curriculum
     * Solo para rol institucion (middleware agregado en routes)
     * Route: institucion.egresado_nuevo - URL: /administrar-egresados/nuevo [GET, role institucion]
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
        // obtengo docente y institucion (esta accion sólo está autorizada para institucion)
        $docente = Auth::user();
        $institucion = $docente->institucion;

        $egresado = new Egresado;
        $egresado->tipo = $institucion->tipo;
        $view_data = [
            'nuevo' => true,
            'egresado' => $egresado,
            'tipo' => $egresado->getTipoLabel()
        ];
        return view('egresados.form',$view_data);
    }

    /**
     * Procesa POST nuevo Egresado / Curriculum y guarda en la BD.
     * Route: institucion.egresado_nuevo_post - URL: /administrar-egresados/nuevo [POST, role institucion]
     *
     * @param  PostEgresadoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostEgresadoRequest $request)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action nuevo())

        $data_egresado = $this->getDataPostEgresado($request);
        $data_curriculum = $this->getDataPostCurriculum($request);

        // obtengo docente y institucion (esta accion sólo está autorizada para institucion)
        $docente = Auth::user();
        $institucion = $docente->institucion;

        // creo y guardo egresado, asociado a la institucion
        /** @var Egresado $egresado */
        $egresado = $institucion->egresados()->create($data_egresado);
        // Tipo de egresado: se setea en función al tipo de institucion
        $egresado->tipo = $institucion->tipo;
        // creo y guardo curriculum, asociado al egresado
        $egresado->curriculum()->create($data_curriculum);
        // asocio docente
        $egresado->docente()->associate($docente);

        // guardo imagen en el server si la envió, usando el id del egresado creado y un string aleatorio
        $this->saveImage($request,$egresado);

        $egresado->save();

        // redirigir a show
        // return redirect()->route('egresado_show',['id'=> $egresado->id]);
        // redirigir a lista egresados institucion
        return redirect()->route('institucion.admin_egresados');
    }

    /**
     * Muestra pantalla con form para editar egresado / curriculum.
     * Route: institucion.egresado_edit - URL: /administrar-egresados/editar/{id} [GET, role institucion]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $egresado = Egresado::find($id);
        if (!$egresado) {
            return abort(404);
        }
        // autorizo accion (solo para institucion de ese egresado)
        if (Gate::denies('edit-egresado', $egresado)) {
            return abort(403);
        }
        $view_data = [
            'nuevo' => false,
            'id' => $id,
            'egresado' => $egresado,
            'tipo' => $egresado->getTipoLabel()
        ];
        return view('egresados.form',$view_data);
    }

    /**
     * Procesa POST edicion de Egresado / Curriculum y actualiza en la BD.
     * Route: institucion.egresado_edit_put - URL: /administrar-egresados/edit/{id} [PUT, role institucion]
     *
     * @param  PostEgresadoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostEgresadoRequest $request, $id)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action edit())

        $egresado = Egresado::find($id);
        if (!$egresado) {
            return redirect()->route('institucion.admin_egresados');
        }
        // autorizo accion (solo para institucion de ese egresado)
        if (Gate::denies('edit-egresado', $egresado)) {
            return abort(403);
        }

        $data_egresado = $this->getDataPostEgresado($request);
        $data_curriculum = $this->getDataPostCurriculum($request);
        // actualizo data egresado
        $egresado->update($data_egresado);
        // actualizo data curriculum
        $egresado->curriculum->update($data_curriculum);
        $this->saveImage($request,$egresado); // guarda imagen de perfil si hay
        $egresado->save();

        // redirigir a show
        return redirect()->route('egresado_show',['id'=> $egresado->id]);

    }

    /**
     * Elimina egresado
     * Route: institucion.egresado_delete - URL: /administrar-egresados/delete/{id} [GET, role institucion]
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        if (!$id) {
            return redirect()->route('institucion.admin_egresados');
        }
        $egresado = Egresado::find($id);
        if (!$egresado) {
            return redirect()->route('institucion.admin_egresados');
        }
        // autorizo accion (solo para institucion de ese egresado)
        if (Gate::denies('edit-egresado', $egresado)) {
            return abort(403);
        }
        $egresado->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'ok']);
        }
        else {
            return redirect()->route('institucion.admin_egresados');
        }
    }

    /************************************************************************************
     * METODOS AUXILIARES
     */

    /**
     * Convierte date recibida al formato que se guarda en BD
     * @param $data_egresado
     */
    protected function parseDate(&$data_egresado) {
        $date_input = isset($data_egresado['nacimiento']) ? $data_egresado['nacimiento'] : null;
        if ($date_input) {
            // Transformo date
            $data_egresado['nacimiento'] = \DateTime::createFromFormat('d/m/Y',$date_input)->format('Y-m-d');
        }
        else {
            $data_egresado['nacimiento'] = null;
        }
    }

    protected function getDataPostEgresado(Request $request) {
        // Obtengo nombres de atributo de egresado
        $egresado_temp = new Egresado;
        $atributos_egresado = $egresado_temp->getFillable();
        // data recibida del post, correspondiente al modelo egresado
        $data_egresado = $request->only($atributos_egresado);
        // convierto fecha de nacimiento al formato a guardar
        $this->parseDate($data_egresado);

        $check_privado = isset($data_egresado['privado']) ? $data_egresado['privado'] : false;
        $data_egresado['privado'] = ($check_privado && $check_privado == 'si');

        if (!isset($data_egresado['dni']) || !$data_egresado['dni']) {
            $data_egresado['dni'] = null;
        }

        return $data_egresado;
    }

    protected function getDataPostCurriculum(Request $request) {
        // Obtengo nombres de atributo de egresado
        $curriculum_temp = new Curriculum;
        $atributos_curriculum = $curriculum_temp->getFillable();
        // data recibida del post, correspondiente al modelo egresado
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

    protected function saveImage(Request $request,$egresado) {
        // guardo imagen en el server, usando el id del egresado creado y un string aleatorio
        if($request->hasFile('foto') && $request->file('foto')->isValid() ) {
            $file = $request->file('foto');
            $foto_name = $egresado->id. '_' . str_random(8) . '.' .
                $file->getClientOriginalExtension();
            $file->move(public_path(Egresado::$image_path),$foto_name);
            $egresado->foto = $foto_name;
        }
    }

}
