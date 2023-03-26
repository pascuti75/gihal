<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Persona;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;

class OperacionController extends Controller
{
    public function index(Request $request)
    {
        $operaciones_query = Operacion::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $operaciones_query = Operacion::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $operaciones_query = Operacion::orderBy('id', 'asc')->paginate(5);
        }

        $operaciones = $operaciones_query;

        return view('operacion.index', compact('operaciones', 'search_param'));
    }


    public function edit($id)
    {
        $operacion  = Operacion::findOrFail($id);
        //para campo combo selector de persona
        $personas  = Persona::all()->sortBy(["nombre", "apellidos"]);
        //para campo combo selector de ubicaciones
        $ubicaciones  = Ubicacion::all()->sortBy(["servicio", "dependencia"]);

        return view('operacion.instalar', compact('operacion', 'personas', 'ubicaciones'));
    }
}
