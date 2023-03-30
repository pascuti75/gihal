<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\TipoEquipo;
use App\Models\User;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\Contratacion;

use Illuminate\Support\Facades\Validator;

// llamar a la referencia del modelo

class ConsultaController extends Controller
{


    public function index(Request $request)
    {
        $tipo_operacion = $request->get('tipo_operacion');
        $activa = $request->get('activa');
        $tecnico = $request->get('tecnico');
        $persona = $request->get('persona');
        $cod_interno = $request->get('cod_interno');
        $tipo_equipo = $request->get('tipo_equipo');
        $ubicacion = $request->get('ubicacion');
        $contratacion = $request->get('contratacion');


        $operaciones = Operacion::orderBy('id', 'desc')
            ->codInterno($cod_interno)
            ->tipoOperacion($tipo_operacion)
            ->tecnico($tecnico)
            ->persona($persona)
            ->tipoEquipo($tipo_equipo)
            ->ubicacion($ubicacion)
            ->contratacion($contratacion)
            ->activa($activa)
            ->paginate(5)
            ->withQueryString();


        $tipos  = TipoEquipo::all()->sortBy("tipo");
        $tecnicos  = User::where('es_tecnico', 1)->get()->sortBy("username");
        $personas  = Persona::all()->sortBy(["apellidos", "nombre"]);
        $ubicaciones  = Ubicacion::all()->sortBy(["servicio", "dependencia"]);
        $contrataciones  = Contratacion::all()->sortBy(["empresa", "fecha_inicio", "fecha_fin"]);

        return view('consulta.index', compact(['operaciones', 'tipos', 'tecnicos', 'personas', 'ubicaciones', 'contrataciones']));
    }
}
