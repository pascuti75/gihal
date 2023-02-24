<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class UbicacionController extends Controller
{

    /**
     * Display a listing of the resource.
     */

     /*
    public function index()
    {
        $datos['ubicaciones'] = Ubicacion::paginate(5);

        //se redirige  a la vista /ubicacion/index
        return view('ubicacion.index', $datos);
    }
    */

    public function index(Request $request)
    {
        $ubicaciones_query = Ubicacion::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $ubicaciones_query = Ubicacion::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $ubicaciones_query = Ubicacion::paginate(5);
        }

        $ubicaciones = $ubicaciones_query;

        return view('ubicacion.index', compact('ubicaciones', 'search_param'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //se redirige  a la vista /ubicacion/create
        return view('ubicacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'servicio' => 'required|string|max:250',
            'dependencia' => 'required|string|max:250',
            'direccion' => 'required|string|max:500',
            'planta' => 'max:30'
        ];

        //mensajes de validación
        $mensaje = [
            'required' => 'La :attribute es obligatoria',
            'servicio.required' => 'El :attribute es obligatorio'
        ];


        $this->validate($request, $campos, $mensaje);


        $ubicacion = new Ubicacion($request->all());
        $ubicacion->save();
        return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        return view('ubicacion.edit', compact('ubicacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'servicio' => 'required|string|max:250',
            'dependencia' => 'required|string|max:250',
            'direccion' => 'required|string|max:500',
            'planta' => 'max:30'
        ];

        //mensajes de validación
        $mensaje = [
            'required' => 'La :attribute es obligatoria',
            'servicio.required' => 'El :attribute es obligatorio'
        ];


        $this->validate($request, $campos, $mensaje);



        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->fill($request->all());
        $ubicacion->save();
        //para volver a mostrar el contenido de la ubicación modificada
        $ubicacion = Ubicacion::findOrFail($id);
        //return view('ubicacion.edit', compact('ubicacion'));
        return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Ubicacion::destroy($id);
        return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha eliminado correctamente');
    }
}
