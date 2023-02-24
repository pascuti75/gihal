<?php

use Illuminate\Support\Facades\Route;

//Importamos la clase UbicacionController
use App\Http\Controllers\UbicacionController;

//Importamos la clase UserController
use App\Http\Controllers\UserController;

//Importamos la clase PersonaController
use App\Http\Controllers\PersonaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//La raiz lo lleva a la ventana de login si no está logado
Route::get('/', function () {
    return view('auth.login');
});

/*

//acceso al index de ubicaciones
Route::get('/ubicacion', function () {
    return view('ubicacion.index');
});

//esta vez la redireccion es por clase (en el controlador UbicacionController). La clase es UbicacionController y el metodo create.
Route::get('/ubicacion/create',[UbicacionController::class,'create']);
*/
//IMPORTANTE. Para acceder a todas las rutas de una clase en vez de ir una por una como estamos haciendo antes podemos hacer esto

//definimos las rutas de auth pero indicamos la que no queremos utilizar
Auth::routes(['register' => false, 'reset' => false]);


//Route::get('/home', [UbicacionController::class, 'index'])->name('home');


//restriccion de acceso a routes por usuario autententicado y permiso esAdministrador
Route::group(['middleware' => ['auth', 'es-administrador']], function () {
    Route::resource('usuario', UserController::class);
});


//restriccion de acceso a routes por usuario autententicado y permiso esGestor
Route::group(['middleware' => ['auth', 'es-gestor']], function () {
    Route::resource('ubicacion', UbicacionController::class);
    Route::resource('persona', PersonaController::class);
});


//restriccion de acceso a routes por usuario autententicado y permiso esTecnico
Route::group(['middleware' => ['auth', 'es-tecnico']], function () {
});

//restriccion de acceso a routes por usuario autententicado y permiso esConsultor
Route::group(['middleware' => ['auth', 'es-consultor']], function () {
});


//restriccion de acceso a routes por usuario autententicado  y acceso a home
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
});
