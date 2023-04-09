<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 User Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la administración de usuarios y las redirecciones 
a partir de la funcion definida en las rutas de la administración de usuarios

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   usuario ................................................. usuario.index › UserController@index  
POST       usuario ................................................. usuario.store › UserController@store  
GET|HEAD   usuario/create ......................................... usuario.create › UserController@create  
PUT|PATCH  usuario/{usuario} ...................................... usuario.update › UserController@update  
DELETE     usuario/{usuario} ..................................... usuario.destroy › UserController@destroy  
GET|HEAD   usuario/{usuario}/edit ................................... usuario.edit › UserController@edit  

*/

class UserController extends Controller
{

    /*
    Devuelve el listado de usuarios en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de usuarios
   */
    public function index(Request $request)
    {
        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de usuarios total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $users = User::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $users = User::paginate(5);
        }

        //Nos redirigimos a la vista del listado de usuarios con el resultado de usuarios obtenido
        return view('usuario.index', compact('users', 'search_param'));
    }


    /*
     Redirige a la vista con el formulario de creación de usuarios
   */
    public function create()
    {
        return view('usuario.create');
    }

    /*
     Almacena en base de datos la información del nuevo usuario creado.
     Redirige a la vista con el listado de usuarios.
   */
    public function store(Request $request)
    {

        //campos para validar
        $campos = [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];

        //mensajes de validación
        $mensaje = [
            'username.required' => 'El nombre de usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'username.max' => 'El usuario debe de tener una longitud menor o igual a 255 caracteres',
            'password.min' => 'La contraseña debe de tener una longitud mínima de 8 caracteres',
            'username.unique' => 'El nombre de usuario ya está en uso',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);
        //Creamos el nuevo usuario y la guardamos con los datos registrados por la petición post
        $usuario = new User([
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'es_administrador' => $request->has('es_administrador'),
            'es_gestor' =>  $request->has('es_gestor'),
            'es_tecnico' =>  $request->has('es_tecnico'),
            'es_consultor' =>  $request->has('es_consultor'),
        ]);
        $usuario->save();
        //Nos redirigimos a la vista del listado de usuarios
        return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha creado correctamente');
    }


    /*
     Redirige a la vista con el formulario para la edición de un usuario en particular
   */
    public function edit($id)
    {
        //recuperamos el usuario a partir de su id recuperado por la petición GET
        $user = User::find($id);
        //Nos redirigimos al formario de edición de la ficha de usuario con los datos del usuario recuperado
        return view('usuario.edit', compact('user'));
    }

    /*
     Actualiza en base de datos la información del usurio editado.
     Redirige a la vista con el listado de usuarios.
   */
    public function update(Request $request, $id)
    {
        //campos para validar
        $campos = [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];

        //mensajes de validación
        $mensaje = [
            'username.required' => 'El nombre de usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'username.max' => 'El usuario debe de tener una longitud menor o igual a 255 caracteres',
            'password.min' => 'La contraseña debe de tener una longitud mínima de 8 caracteres'
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información del usuario
        $usuario = User::find($id);
        $datos = [
            'password' => Hash::make($request['password']),
            'es_administrador' => $request->has('es_administrador'),
            'es_gestor' =>  $request->has('es_gestor'),
            'es_tecnico' =>  $request->has('es_tecnico'),
            'es_consultor' =>  $request->has('es_consultor'),
        ];
        $usuario->fill($datos);
        $usuario->save();
        //Nos redirigimos a la vista del listado de usuarios
        return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos el usuario indicado.
     Redirige a la vista con el listado de usuarios.
   */
    public function destroy($id)
    {
        try {
            //eliminamos en base de datos el usuario a partir de su id recuperado de la petición DELETE
            User::destroy($id);
            return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([UserController::class, 'index'])->with('error', 'No es posible eliminar el usuario');
        }
    }
}
