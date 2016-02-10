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
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    // Acceso a plataforma:
    //    redirecciona a login si no está autenticado, o al listado de alumnos si está logueado
    Route::get('/acceso', function () {
        return redirect('/login');
    })->middleware('guest'); // el middleware guest hace redireccion a /alumnos si está logueado (definido en Middleware/RedirectIfAuthenticated)


});

// Routes con autenticacion
Route::group(['middleware' => ['web','auth']], function () {

    // Listado de alumnos: cambia segun rol de usuario
    Route::get('/alumnos','AlumnosController@listadoAlumnos');
});
