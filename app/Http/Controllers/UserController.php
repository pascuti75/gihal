<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */


    /*
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $users = User::search($request->search)->paginate(5);
        } else {
            $users = User::paginate(5);
        }

        return view('usuario.index', compact('users'));
    }
*/


    public function index(Request $request)
    {
        $users_query = User::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $users_query = User::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $users_query = User::paginate(5);
        }

        $users = $users_query;

        return view('usuario.index', compact('users', 'search_param'));
    }


    /*
    public function index(Request $request)
    {

        if ($request->filled('search')) {
            $datos['users']  = User::search($request->search)->get();
        } else {
            $datos['users'] = User::paginate(5);
        }
        //$datos['users'] = User::paginate(5);

        //se redirige  a la vista /ubicacion/index
        
        return view('usuario.index', $datos);
    }
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
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
            'password.required' => 'La contraseña es obligatoria'
        ];


        $this->validate($request, $campos, $mensaje);

        $usuario = new User([
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'es_administrador' => $request->has('es_administrador'),
            'es_gestor' =>  $request->has('es_gestor'),
            'es_tecnico' =>  $request->has('es_tecnico'),
            'es_consultor' =>  $request->has('es_consultor'),
        ]);

        //return response()->json($request);
        $usuario->save();
        return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        return view('usuario.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
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
            'password.required' => 'La contraseña es obligatoria'
        ];


        $this->validate($request, $campos, $mensaje);

        $usuario = User::findOrFail($id);
        $datos = [
            'password' => Hash::make($request['password']),
            'es_administrador' => $request->has('es_administrador'),
            'es_gestor' =>  $request->has('es_gestor'),
            'es_tecnico' =>  $request->has('es_tecnico'),
            'es_consultor' =>  $request->has('es_consultor'),
        ];

        $usuario->fill($datos);
        $usuario->save();
        //para volver a mostrar el contenido del usuario modificado
        $usuario = User::findOrFail($id);
        return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return redirect()->action([UserController::class, 'index'])->with('mensaje', 'El usuario se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([UserController::class, 'index'])->with('error', 'No es posible eliminar el usuario');
        }
    }
}
