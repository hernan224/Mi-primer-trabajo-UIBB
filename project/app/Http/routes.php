<?php

use App\Models\Escuela;
use App\Models\Empresa;

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
        return view('public.instituciones',['escuelas' => Escuela::all()]);
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
    Route::post('login', 'Auth\AuthController@login'); // si es ok redirecciona a /listado-alumnos (seteado en AuthController)
    Route::get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    /** Pantallas publicas con POSTs con formularios de email **/

    // Solicitar acceso - NO USADA
    // Route::get('/solicitar-acceso', function () {
    //     return view('public.solicitar_acceso');
    // });
    // Route::post('/solicitar-acceso/{tipo}','MailsController@solicitarAcceso');
    Route::get('/contacto', function () {
        return view('public.contacto');
    });
    Route::post('/contacto','MailsController@contacto');

    /** Listado de alumnos público */
    // GET pantalla
    Route::get('/listado-alumnos','AlumnosController@showListado')->name('alumnos_public');
    // GET lista alumnos públicos (resp JSON)
    // Puede incluir filtros y ordenamiento como parametros get, y numero pagina
    Route::get('/alumnos','AlumnosController@lista')->name('alumnos_public_list');
    // Busqueda nombre, apellido, especialidad (resp JSON)
    Route::get('/alumnos/search','AlumnosController@search')->name('alumnos_public_search');

    // GET vista y PDF alumno
    Route::get('/alumno/pdf/{id?}','AlumnosController@pdf')->name('alumno_pdf');
    Route::get('/alumno/{id?}','AlumnosController@show')->name('alumno_show');

    /** Acceso a plataforma para escuelas (panel administracion: listado editable de alumnos) **/
    //    redirecciona a login si no está autenticado, o al listado de alumnos propios si está logueado
    Route::get('/acceso-escuelas', function () {
        return redirect('/login');
    })->middleware('guest'); // el middleware guest hace redireccion a /listado-alumnos si está logueado
                             //     (definido en Middleware/RedirectIfAuthenticated)

});

// Routes con autenticacion y usuario escuela o admin  (creacion, edicion y eliminacion de alumnos)
Route::group(['middleware' => ['web','auth','role:escuela'],'as' => 'escuela.'], function () {

    // Listado de alumnos propios (sólo renderiza pantalla)
    // ToDo controller que chequee alumnos propios y redireccione a action showListado
    Route::get('/administrar-alumnos','AlumnosController@showListadoEscuela')->name('admin_alumnos');

    // GET AJAX lista alumnos de la escuela (resp JSON)
    // Puede incluir filtros y ordenamiento como parametros get, y numero pagina
    // ToDo controller que chequee alumnos propios y redireccione a action lista
    Route::get('/alumnos-escuela','AlumnosController@listaEscuela')->name('alumnos_list');

    // GET AJAX: Busqueda nombre, apellido, especialidad (resp JSON)
    // ToDo controller que chequee alumnos propios y redireccione a action lista
    Route::get('/alumnos-escuela/search','AlumnosController@searchEscuela')->name('alumnos_search');

    /** Creacion, edicion, eliminación **/
    // GET pantalla formulario nuevo alumno
    Route::get('/administrar-alumnos/nuevo','AlumnosController@nuevo')->name('alumno_nuevo');
    // POST formulario nuevo alumno
    Route::post('/administrar-alumnos/nuevo','AlumnosController@store')->name('alumno_nuevo_post');
    // GET pantalla formulario editar alumno
    Route::get('/administrar-alumnos/editar/{id?}','AlumnosController@edit')->name('alumno_edit');
    // PUT formulario editar alumno
    Route::put('/administrar-alumnos/edit/{id}','AlumnosController@update')->name('alumno_edit_put');
    // GET AJAX para eliminar alumno
    Route::get('/administrar-alumnos/delete/{id?}','AlumnosController@destroy')->name('alumno_delete');
    // ToDo: set privado desde listado

    // Formulario ayuda (no estaba en requerimientos)
    // Route::get('/ayuda', function () {
    //     return view('auth.ayuda');
    // });
    // Route::post('/ayuda','MailsController@ayuda');

});


// ROUTE TEMPORAL PARA EJECUTAR COMANDOS EN SERVIDOR
// Route::get('/artisan', function () {

    // Artisan::call('cache:clear', [
    // ]);

    // dump(Artisan::output());

    // Artisan::call('migrate:refresh', [
    //     '--force' => true
    // ]);
    // dump(Artisan::output());
    // Artisan::call('db:seed', [
    //     '--force' => true
    // ]);
    // dump(Artisan::output());

    // Artisan::call('optimize', [
    //     '--force' => true
    // ]);

    // dump(Artisan::output());
// });

// ROUTE TEMPORAL PARA PROBAR PDF
// Route::get('/testpdf', function () {
//     $pdf = PDF::loadView('test_pdf');
//     return $pdf->download('test.pdf');
// });