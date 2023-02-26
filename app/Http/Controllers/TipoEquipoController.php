<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoEquipo;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class TipoEquipoController extends Controller
{


    public function index(Request $request)
    {
        $tipos_equipo_query = TipoEquipo::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $tipos_equipo_query = TipoEquipo::search($search_param)->orderBy('cod_tipo_equipo', 'asc')->paginate(5);
        } else {
            $tipos_equipo_query = TipoEquipo::orderBy('cod_tipo_equipo', 'asc')->paginate(5);
        }

        $tipos_equipo = $tipos_equipo_query;

        return view('tipo_equipo.index', compact('tipos_equipo', 'search_param'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //se redirige  a la vista /tipo_equipo/create
        return view('tipo_equipo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'cod_tipo_equipo' => 'required|string|max:3',
            'tipo' => 'required|string|max:100',
        ];

        //mensajes de validación
        $mensaje = [
            'cod_tipo_equipo.required' => 'El código es obligatorio',
            'tipo.required' => 'El tipo es obligatorio'
        ];


        $this->validate($request, $campos, $mensaje);


        $tipo_equipo = new TipoEquipo($request->all());
        $tipo_equipo->save();
        return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoEquipo $tipo_equipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipo_equipo = TipoEquipo::findOrFail($id);
        return view('tipo_equipo.edit', compact('tipo_equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'cod_tipo_equipo' => 'required|string|max:3',
            'tipo' => 'required|string|max:100',
        ];

        //mensajes de validación
        $mensaje = [
            'cod_tipo_equipo.required' => 'El código es obligatorio',
            'tipo.required' => 'El tipo es obligatorio'
        ];



        $this->validate($request, $campos, $mensaje);



        $tipo_equipo = TipoEquipo::findOrFail($id);
        $tipo_equipo->fill($request->all());
        $tipo_equipo->save();
        //para volver a mostrar el contenido de la contratacion modificada
        $tipo_equipo = TipoEquipo::findOrFail($id);
        return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TipoEquipo::destroy($id);
        return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha eliminado correctamente');
    }
}
