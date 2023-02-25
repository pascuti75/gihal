<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratacion;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class ContratacionController extends Controller
{


    public function index(Request $request)
    {
        $contrataciones_query = Contratacion::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $contrataciones_query = Contratacion::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $contrataciones_query = Contratacion::paginate(5);
        }

        $contrataciones = $contrataciones_query;

        return view('contratacion.index', compact('contrataciones', 'search_param'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //se redirige  a la vista /contratacion/create
        return view('contratacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'titulo' => 'required|string|max:500',
            'empresa' => 'required|string|max:250',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ];

        //mensajes de validación
        $mensaje = [
            'titulo.required' => 'El :attribute es obligatorio',
            'empresa.required' => 'La :attribute es obligatoria',
            'fecha_inicio.date' => 'La fecha de inicio no es una fecha válida',
            'fecha_fin.date' => 'La fecha de fin no es una fecha válida',
        ];


        $this->validate($request, $campos, $mensaje);


        $contratacion = new Contratacion($request->all());
        $contratacion->save();
        return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contratacion $contratacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contratacion = Contratacion::findOrFail($id);
        return view('contratacion.edit', compact('contratacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'titulo' => 'required|string|max:500',
            'empresa' => 'required|string|max:250',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ];

        //mensajes de validación
        $mensaje = [
            'titulo.required' => 'El :attribute es obligatorio',
            'empresa.required' => 'La :attribute es obligatoria',
            'fecha_inicio.date' => 'La fecha de inicio no es una fecha válida',
            'fecha_fin.date' => 'La fecha de fin no es una fecha válida',
        ];


        $this->validate($request, $campos, $mensaje);



        $contratacion = Contratacion::findOrFail($id);
        $contratacion->fill($request->all());
        $contratacion->save();
        //para volver a mostrar el contenido de la contratacion modificada
        $contratacion = Contratacion::findOrFail($id);
        return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Contratacion::destroy($id);
        return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha eliminado correctamente');
    }
}
