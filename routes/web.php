<?php

use Illuminate\Support\Facades\Route;

//Importamos la clase UbicacionController
use App\Http\Controllers\UbicacionController;

//Importamos la clase UserController
use App\Http\Controllers\UserController;

//Importamos la clase PersonaController
use App\Http\Controllers\PersonaController;

//Importamos la clase ContratacionController
use App\Http\Controllers\ContratacionController;

//Importamos la clase TipoEquipoController
use App\Http\Controllers\TipoEquipoController;

//Importamos la clase EquipoController
use App\Http\Controllers\EquipoController;

//Importamos la clase OperacionController
use App\Http\Controllers\OperacionController;

//Importamos la clase ConsultaController
use App\Http\Controllers\ConsultaController;

//Importamos la clase AutocompletarController
use App\Http\Controllers\AutocompletarController;

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
Route::get('/phpinfo', function () {
    phpinfo();
});
*/

//definimos las rutas de auth pero indicamos la funcionalidad que no queremos utilizar (register y reset)
Auth::routes(['register' => false, 'reset' => false]);


//restriccion de acceso a routes por usuario autententicado y permiso esAdministrador
Route::group(['middleware' => ['auth', 'es-administrador']], function () {
    Route::resource('usuario', UserController::class);
});


//restriccion de acceso a routes por usuario autententicado y permiso esGestor
Route::group(['middleware' => ['auth', 'es-gestor']], function () {
    Route::resource('ubicacion', UbicacionController::class);
    Route::resource('persona', PersonaController::class);
    Route::resource('contratacion', ContratacionController::class);
    Route::resource('tipo_equipo', TipoEquipoController::class);
    Route::resource('equipo', EquipoController::class);
    Route::resource('operacion', OperacionController::class);
    Route::get('/operacion/{id}/instalar', [OperacionController::class, 'edit']);
});


//restriccion de acceso a routes por usuario autententicado y permiso esTecnico
Route::group(['middleware' => ['auth', 'es-tecnico']], function () {
    Route::resource('operacion', OperacionController::class);
    Route::get('/operacion/{id}/instalar', [OperacionController::class, 'edit']);
});

//restriccion de acceso a routes por usuario autententicado y permiso esConsultor
Route::group(['middleware' => ['auth', 'es-consultor']], function () {
    Route::get('/consulta/pdf', [ConsultaController::class, 'pdf'])->name('consulta.pdf');
    Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta.index');
    Route::get('/consulta/{operacion}', [ConsultaController::class, 'show'])->name('consulta.show');
    Route::post('/autocompletar/{campo}', [AutocompletarController::class, 'search'])->name('autocompletar.autosearch');;
});


//restriccion de acceso a routes por usuario autententicado y acceso a home
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/home', function () {
        return view('home');
    });
    Route::get('/ayuda', function () {
        return view('/ayuda/show');
    });
});
