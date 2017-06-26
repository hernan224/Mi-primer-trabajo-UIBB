<?php

use App\Models\Institucion;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Routes sin autenticacion
Route::group(['middleware' => 'web'], function () {

    // Pantallas publicas
    // Home
    Route::get('/', function () {
        return view('public.home');
    });
    Route::get('/instituciones-educativas', function () {
        return view('public.instituciones',['instituciones' => Institucion::all()]);
    });
    // Pantalla empresas - NO USADA
    // Route::get('/empresas', function () {
    //     return view('public.empresas',['empresas' => Empresa::all()]);
    // });
    Route::get('/legal', function () {
        return view('public.aviso_legal');
    });

    // Route::auth(); // no incluyo routes de registro
    // Login & logut
    Route::get('login', 'Auth\AuthController@showLoginForm');
    // si Login  es ok redirecciona a /panel-administracion (seteado en AuthController)
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    /** Acceso a plataforma para instituciones o admin
     *  (panel administración instituciones: listado editable de egresados de la institucion)
     *  (panel administración admin: listado editable de publicaciones)
     *
     *  Redirecciona a login si no está autenticado,
     *      al listado de egresados propios si está logueado y es institucion
     *      o al listado de publicaciones para editar si está logueado y es admin
     */
    Route::get('/panel-administracion', function () {
        return redirect('/login');
    })->middleware('guest'); // el middleware guest hace redireccion a /listado-egresados o /admin-publicaciones si está logueado
    //     (definido en Middleware/RedirectIfAuthenticated)


    /** Listado de egresados público */
    // GET pantalla
    Route::get('/listado-egresados','EgresadosController@showListado')->name('egresados_public');
    // GET lista egresados públicos (resp JSON)
    // Puede incluir filtros y ordenamiento como parametros get, y numero pagina
    Route::get('/egresados','EgresadosController@lista')->name('egresados_public_list');
    // Busqueda nombre, apellido, especialidad (resp JSON)
    Route::get('/egresados/search','EgresadosController@search')->name('egresados_public_search');

    // GET vista y PDF egresado
    Route::get('/egresado/pdf/{id?}','EgresadosController@pdf')->name('egresado_pdf');
    Route::get('/egresado/{id?}','EgresadosController@show')->name('egresado_show');


    /** Listado público de publicaciones: pantallas y lista JSON **/
    // GET pantalla publicaciones categoría capacitaciones
    Route::get('/publicaciones/capacitaciones', function () {
        return view('publicaciones.capacitaciones');
    })->name('publicaciones_capacitaciones');
    // GET pantalla publicaciones categoría practicas
    Route::get('/publicaciones/practicas', function () {
        return view('publicaciones.practicas');
    })->name('publicaciones_practicas');

    // GET lista publicacion (resp JSON). Parámetro get categoria opcional
    Route::get('/publicaciones-list/{categoria?}','PublicacionesController@lista')->name('publicaciones_public_list');
    // GET lista publicaciones para home.
    Route::get('/publicaciones-home','PublicacionesController@listaHome')->name('publicaciones_home_list');
    // GET vista publicación
    Route::get('/publicaciones/{categoria?}/{id?}','PublicacionesController@show')->name('publicacion_show');

    /** Pantallas públicas con POSTs con formularios de email **/
    // Solicitar acceso - NO USADA
    // Route::get('/solicitar-acceso', function () {
    //     return view('public.solicitar_acceso');
    // });
    // Route::post('/solicitar-acceso/{tipo}','MailsController@solicitarAcceso');
    Route::get('/contacto', function () {
        return view('public.contacto');
    });
    Route::post('/contacto','MailsController@contacto');

    // Solicitar datos egresados
    Route::post('/solicitar-datos-egresado/{id}','MailsController@solicitarDatosEgresado')->name('egresado_solicitar');
});

// Institución: Routes con autenticación y usuario institucion (creación, edición y eliminación de egresados)
Route::group(['middleware' => ['web','auth','role:institucion'],'as' => 'institucion.'], function () {

    // Listado de egresados propios de la institución (sólo renderiza pantalla)
    Route::get('/administrar-egresados','EgresadosController@showListadoInstitucion')->name('admin_egresados');

    // GET AJAX lista egresados de la institucion (resp JSON)
    // Puede incluir filtros y ordenamiento como parametros get, y numero pagina
    Route::get('/egresados-institucion','EgresadosController@listaInstitucion')->name('egresados_list');

    // GET AJAX: Busqueda nombre, apellido, especialidad (resp JSON)
    Route::get('/egresados-institucion/search','EgresadosController@searchInstitucion')->name('egresados_search');

    /** Creacion, edicion, eliminación **/
    // GET pantalla formulario nuevo egresado
    Route::get('/administrar-egresados/nuevo','EgresadosController@nuevo')->name('egresado_nuevo');
    // POST formulario nuevo egresado
    Route::post('/administrar-egresados/nuevo','EgresadosController@store')->name('egresado_nuevo_post');
    // GET pantalla formulario editar egresado
    Route::get('/administrar-egresados/editar/{id?}','EgresadosController@edit')->name('egresado_edit');
    // PUT formulario editar egresado
    Route::put('/administrar-egresados/edit/{id}','EgresadosController@update')->name('egresado_edit_put');
    // GET AJAX para eliminar egresado
    Route::get('/administrar-egresados/delete/{id?}','EgresadosController@destroy')->name('egresado_delete');
    // ToDo: set privado desde listado

    // Formulario ayuda (no estaba en requerimientos)
    // Route::get('/ayuda', function () {
    //     return view('auth.ayuda');
    // });
    // Route::post('/ayuda','MailsController@ayuda');

});

// Publicaciones: Routes con autenticacion y usuario admin (creacion, edicion y eliminacion de publicaciones)
Route::group(['middleware' => ['web','auth','role:admin'],'as' => 'publicaciones.'], function () {

    // Listado de publicaciones (sólo renderiza pantalla)
    Route::get('/administrar-publicaciones','PublicacionesController@administrar')->name('admin_publicaciones');

    /** Creacion, edicion, eliminación de publicaciones **/
    // GET pantalla formulario nueva publicación
    Route::get('/administrar-publicaciones/nueva','PublicacionesController@nueva')->name('publicacion_nueva');
    // POST formulario nueva publicación
    Route::post('/administrar-publicaciones/nueva','PublicacionesController@store')->name('publicacion_nueva_post');
    // GET pantalla formulario editar publicación
    Route::get('/administrar-publicaciones/editar/{id?}','PublicacionesController@edit')->name('publicacion_edit');
    // PUT formulario editar publicación
    Route::put('/administrar-publicaciones/edit/{id}','PublicacionesController@update')->name('publicacion_edit_put');
    // GET AJAX para eliminar publicación
    Route::get('/administrar-publicaciones/delete/{id?}','PublicacionesController@destroy')->name('publicacion_delete');

});


// ROUTE TEMPORAL PARA EJECUTAR COMANDOS EN SERVIDOR
// Route::get('/artisan', function () {
//
//     Artisan::call('cache:clear', [
//     ]);
//
//     dump(Artisan::output());
//
//     Artisan::call('migrate', [
//         '--force' => true
//     ]);
//     dump(Artisan::output());
//     Artisan::call('db:seed', [
//         '--force' => true
//     ]);
//     dump(Artisan::output());
//
//     Artisan::call('optimize', [
//         '--force' => true
//     ]);
//
//     dump(Artisan::output());
// });

// ROUTE TEMPORAL PARA PROBAR PDF
// Route::get('/testpdf', function () {
//     $pdf = PDF::loadView('test_pdf');
//     return $pdf->download('test.pdf');
// });