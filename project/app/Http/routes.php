<?php

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

    // Home
    Route::get('/', function () {
        return view('home');
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

    // Acceso a plataforma:
    //    redirecciona a login si no está autenticado, o al listado de alumnos si está logueado
    Route::get('/acceso', function () {
        return redirect('/login');
    })->middleware('guest'); // el middleware guest hace redireccion a /listado-alumnos si está logueado (definido en Middleware/RedirectIfAuthenticated)


});

// Routes con autenticacion
Route::group(['middleware' => ['web','auth'],'as' => 'alumnos.'], function () {

    // Listado de alumnos (sólo renderiza pantalla)
    Route::get('/listado-alumnos',function () {
        return view('alumnos.listado');
    })->name('listado');

    // GET lista alumnos (resp JSON)
    // Si es escuela devuelve alumnos de la escuela, si no todos
    // Puede incluir filtros como parametros get, y numero pagina
    Route::get('/alumnos','AlumnosController@lista')->name('lista');

    // Routes con autenticacion y usuario escuela o admin  (creacion, edicion y eliminacion de alumnos)
    Route::group(['middleware' => 'role:escuela'], function () {

        Route::get('/alumno/nuevo','AlumnosController@nuevo')->name('nuevo');
        Route::post('/alumno/nuevo','AlumnosController@store')->name('nuevo_post');
        Route::get('/alumno/{id}/edit','AlumnosController@edit')->name('edit');
        Route::put('/alumno/{id}','AlumnosController@update')->name('edit_put');
        Route::delete('/alumno/{id}','AlumnosController@destroy')->name('delete');
        Route::get('/alumno/{id}/delete','AlumnosController@destroy')->name('delete_get');

    });

    // GET pantalla alumno
    Route::get('/alumno/{id}','AlumnosController@show')->name('show');

});
