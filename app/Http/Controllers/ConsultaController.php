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
        $tecnico = $request->get('tecnico');
        $cod_interno = $request->get('cod_interno');
        $tipo_equipo = $request->get('tipo_equipo');


        $operaciones = Operacion::orderBy('id', 'desc')
            ->codInterno($cod_interno)
            ->tipoOperacion($tipo_operacion)
            ->tecnico($tecnico)
            ->tipoEquipo($tipo_equipo)
            //->activa($tipo_operacion)
            ->paginate(5)
            ->withQueryString();
        return view('consulta.index', compact('operaciones'));
    }
}
