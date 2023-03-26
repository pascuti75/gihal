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
        $operaciones = Operacion::orderBy('id', 'desc')->paginate(5);
        return view('consulta.index', compact('operaciones'));
    }
}
