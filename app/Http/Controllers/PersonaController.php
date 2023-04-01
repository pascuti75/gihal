<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class PersonaController extends Controller
{


    public function index(Request $request)
    {
        $personas_query = Persona::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $personas_query = Persona::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $personas_query = Persona::paginate(5);
        }

        $personas = $personas_query;

        return view('persona.index', compact('personas', 'search_param'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //se redirige  a la vista /persona/create
        return view('persona.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'nombre' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'tipo_personal' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'nombre.required' => 'El :attribute es obligatorio',
            'apellidos.required' => 'Los :attribute son obligatorios',
            'tipo_personal.required' => 'El :attribute es obligatorio',
        ];


        $this->validate($request, $campos, $mensaje);


        $persona = new Persona($request->all());
        $persona->save();
        return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        return view('persona.edit', compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'nombre' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'tipo_personal' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'nombre.required' => 'El :attribute es obligatorio',
            'apellidos.required' => 'Los :attribute son obligatorios',
            'tipo_personal.required' => 'El :attribute es obligatorio',
        ];


        $this->validate($request, $campos, $mensaje);



        $persona = Persona::findOrFail($id);
        $persona->fill($request->all());
        $persona->save();
        //para volver a mostrar el contenido de la persona modificada
        $persona = Persona::findOrFail($id);
        return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            Persona::destroy($id);
            return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([PersonaController::class, 'index'])->with('error', 'No es posible eliminar la persona');
        }
    }
}
