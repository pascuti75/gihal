<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\TipoEquipo;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class EquipoController extends Controller
{

    public function index(Request $request)
    {
        $equipos_query = Equipo::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $equipos_query = Equipo::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $equipos_query = Equipo::orderBy('id', 'asc')->paginate(5);
        }

        $equipos = $equipos_query;

        return view('equipo.index', compact('equipos', 'search_param'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //para campo combo selector de tipo
        $tipos  = TipoEquipo::all()->sortBy("tipo");
        //se redirige  a la vista /equipo/create
        return view('equipo.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //campos para validar

        $campos = [
            'cod_interno' => 'nullable|string|max:100',
            'cod_externo' => 'nullable|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:250',
            'product_number' => 'nullable|string|max:250',
            'num_serie' => 'required|string|max:100',
            'id_tipo_equipo' => 'required',
        ];


        //mensajes de validación
        $mensaje = [
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'num_serie.required' => 'El número de serie es obligatorio',
            'id_tipo_equipo.required' => 'El tipo es obligatorio',
        ];


        $this->validate($request, $campos, $mensaje);


        $equipo  = new Equipo($request->all());
        $equipo->save();
        return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $equipo  = Equipo::findOrFail($id);
        //para campo combo selector de tipo
        $tipos  = TipoEquipo::all()->sortBy("tipo");
        return view('equipo.edit', compact('equipo', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'cod_interno' => 'nullable|string|max:100',
            'cod_externo' => 'nullable|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:250',
            'product_number' => 'nullable|string|max:250',
            'num_serie' => 'required|string|max:100',
            'id_tipo_equipo' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'num_serie.required' => 'El número de serie es obligatorio',
            'id_tipo_equipo.required' => 'El tipo es obligatorio',
        ];


        $this->validate($request, $campos, $mensaje);


        $equipo  = Equipo::findOrFail($id);
        $equipo->fill($request->all());
        $equipo->save();
        //para volver a mostrar el contenido del equipo modificado
        $equipo  = Equipo::findOrFail($id);
        return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Equipo::destroy($id);
        return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha eliminado correctamente');
    }
}
