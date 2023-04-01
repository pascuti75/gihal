<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\TipoEquipo;
use App\Models\User;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\Contratacion;
use App\Models\Equipo;

use Illuminate\Support\Facades\Validator;


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
        $f_oper_ini = $request->get('f_oper_ini');
        $f_oper_fin = $request->get('f_oper_fin');
        $marca = $request->get('marca');
        $modelo = $request->get('modelo');
        $num_serie = $request->get('num_serie');
        $product_number = $request->get('product_number');

        $tipos  = TipoEquipo::all()->sortBy("tipo");
        $tecnicos  = User::where('es_tecnico', 1)->get()->sortBy("username");
        $personas  = Persona::all()->sortBy(["apellidos", "nombre"]);
        $ubicaciones  = Ubicacion::all()->sortBy(["servicio", "dependencia"]);
        $contrataciones  = Contratacion::all()->sortBy(["empresa", "fecha_inicio", "fecha_fin"]);
        $marcas = Equipo::select('marca')->distinct()->orderBy('marca')->pluck('marca');
        $modelos = Equipo::select('modelo')->distinct()->orderBy('modelo')->pluck('modelo');


        //campos para validar
        $campos = [
            'f_oper_ini' => 'nullable|date',
            'f_oper_fin' => 'nullable|date|after:f_oper_ini'
        ];

        //mensajes de validación
        $mensaje = [
            'f_oper_ini.date' => '\'Desde fecha operación...\' debe de ser una fecha válida',
            'f_oper_fin.date' => '\'Hasta fecha operación...\'  debe de ser una fecha válida',
            'f_oper_fin.after' => '\'Hasta fecha operación...\' debe de ser posterior a \'Desde fecha operación...\'',
        ];


        $this->validate($request, $campos, $mensaje);

        $operaciones = Operacion::orderBy('id', 'desc')
            ->codInterno($cod_interno)
            ->tipoOperacion($tipo_operacion)
            ->tecnico($tecnico)
            ->persona($persona)
            ->tipoEquipo($tipo_equipo)
            ->ubicacion($ubicacion)
            ->contratacion($contratacion)
            ->fOperIni($f_oper_ini)
            ->fOperFin($f_oper_fin)
            ->marca($marca)
            ->modelo($modelo)
            ->numSerie($num_serie)
            ->productNumber($product_number)
            ->activa($activa)
            ->paginate(5)
            ->withQueryString();


        return view('consulta.index', compact(['operaciones', 'tipos', 'tecnicos', 'personas', 'ubicaciones', 'contrataciones', 'marcas', 'modelos']))->with('error', $mensaje);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $operacion  = Operacion::findOrFail($id);

        return view('consulta.show', compact('operacion'));
    }
}
