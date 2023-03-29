<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class ConsultaController extends Controller
{


    public function index(Request $request)
    {
        $tipo_operacion = $request->get('tipo_operacion');
        $activa = $request->get('activa');


        $operaciones = Operacion::orderBy('id', 'desc')
            ->tipoOperacion($tipo_operacion)
            ->activa($tipo_operacion)
            ->paginate(5);
        return view('consulta.index', compact('operaciones'));
    }
}
