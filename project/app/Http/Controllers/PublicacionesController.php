<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

use App\Http\Requests;

class PublicacionesController extends Controller
{

    /**
     * Pantallas públicas (sin data que obtiene por JSON), definidas en routes:
     *      - Capacitaciones: URL /capacitaciones - Template publicaciones.capacitaciones
     *      - Prácticas: URL /practicas - Template publicaciones.practicas
     **/

    /**
     * Lista de publicaciones [JSON público, con preview de texto]
     * Si se indica categoría, se devuelven sólo los de esa categoría
     * Route: publicaciones_public_list - URL: /publicaciones/{categoria?} [GET]
     *      Parametro get categoria opcional
     *
     * @param string $categoria
     * @return \Illuminate\Http\Response
     */
    public function lista($categoria = null){

        return response()->json(['ToDo']);
    }


    /**
     * Muestra pantalla listado de alumnos de escuela para administrar (sin data: la obtiene por AJAX de lista)
     * Route: publicaciones.admin_publicaciones - URL: /administrar-publicaciones [GET, role admin]
     */
    public function administrar() {
        // ToDo
        $view_data = [];
        return view('publicaciones.administrar',$view_data);
    }

    /**
     * Muestra pantalla visualización de publicación completa
     * Route: publicacion_show - URL: /publicacion/{categoria}/{id} [GET]
     *
     * @param string $categoria
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoria, $id = null)
    {
        $view_data = [
            'categoria' => $categoria
        ];
        if (!$id) {
            return redirect('/'.$categoria);
        }
        $publicacion = Publicacion::find($id);
        if (!$publicacion || $publicacion->categoria != $categoria) {
            return redirect('/'.$categoria);
        }

        $view_data = [
            'id' => $id,
            'publicacion' => $publicacion,
        ];

        return view('publicaciones.show',$view_data);
    }


    /**
     * Muestra pantalla creación de Publicacion (Nota en Capacitaciones o Prácticas Profesionalizantes)
     * Solo para rol admin (middleware agregado en routes)
     * Route: publicaciones.publicacion_nueva -  URL: /administrar-publicaciones/nueva [GET, role admin]
     *
     * @return \Illuminate\Http\Response
     */
    public function nueva()
    {
        $publicacion = new Publicacion();
        $view_data = [
            'nuevo' => true,
            'publicacion' => $publicacion
        ];
        return view('publicaciones.form',$view_data);
    }

    /**
     * Procesa POST nueva Publicacion y guarda en la BD.
     * Route: publicaciones.publicacion_nueva_post - URL: /administrar-publicaciones/nuevo [POST, role admin]
     *
     * @param  PostPublicacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostPublicacionRequest $request)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action nuevo())

        return redirect()->route('publicaciones.admin_publicaciones');
    }

    /**
     * Muestra pantalla con form para editar publicación
     * Route: publicaciones.publicacion_edit - URL: /administrar-publicacion/editar/{id} [GET, role admin]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->route('publicaciones.admin_publicaciones');
        }
        $publicacion = Publicacion::find($id);
        if (!$publicacion) {
            return redirect()->route('publicaciones.admin_publicaciones');
        }

        $view_data = [
            'nuevo' => false,
            'id' => $id,
            'publicacion' => $publicacion
        ];
        return view('publicaciones.form',$view_data);
    }

    /**
     * Procesa POST edicion de Publicacion y actualiza en la BD.
     * Route: publicaciones.publicacion_edit_put - URL: /administrar-publicaciones/edit/{id} [PUT, role admin]
     *
     * @param  PostPublicacionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostPublicacionRequest $request, $id)
    {
        // el request hace la validación primero.
        // Si falla se redirige nuevamente a la pantalla que envió el post (action edit())

        $publicacion = Publicacion::find($id);
        if (!$publicacion) {
            return redirect()->route('publicaciones.admin_publicaciones');
        }

        // redirigir a show
        return redirect()->route('publicacion_show',['id'=> $id]);
    }

    /**
     * Elimina publicacion
     * Route: publicaciones.publicacion_delete - URL: /administrar-publicaciones/delete/{id} [GET, role admin]
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        if (!$id) {
            return redirect()->route('publicaciones.admin_publicaciones');
        }
        $publicacion = Publicacion::find($id);
        if (!$publicacion) {
            return redirect()->route('publicaciones.admin_publicaciones');
        }
        $publicacion->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'ok']);
        }
        else {
            return redirect()->route('publicaciones.admin_publicaciones');
        }
    }

}
