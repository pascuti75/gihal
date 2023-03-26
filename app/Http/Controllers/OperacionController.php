<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OperacionController extends Controller
{
    public function index(Request $request)
    {
        $operaciones_query = Operacion::query();

        $search_param = $request->query('query');

        if ($search_param) {
            $operaciones_query = Operacion::search($search_param)->where('activa', 'si')->orderBy('id', 'desc')->paginate(5);
        } else {
            $operaciones_query = Operacion::where('activa', 'si')->orderBy('id', 'desc')->paginate(5);
        }

        $operaciones = $operaciones_query;

        return view('operacion.index', compact('operaciones', 'search_param'));
    }


    public function edit($id)
    {
        $operacion  = Operacion::findOrFail($id);
        //para campo combo selector de persona
        $personas  = Persona::all()->sortBy(["apellidos", "nombre"]);
        //para campo combo selector de ubicaciones
        $ubicaciones  = Ubicacion::all()->sortBy(["servicio", "dependencia"]);
        //para campo combo selector de equipos
        $equipos  = Equipo::all()->sortBy(["cod_interno"]);
        //para campo combo selector de users
        $users  = User::all()->sortBy(["username"]);

        return view('operacion.instalar', compact('operacion', 'personas', 'ubicaciones', 'equipos', 'users'));
    }

    public function update(Request $request, $id)
    {

        $operacion_actual  = Operacion::findOrFail($id);
        //marcamos la operacion actual como no activa para que no se muestre
        $operacion_actual->activa = "no";
        $operacion_actual->save();

        //creamos la nueva operacion
        $operacion  = new Operacion();
        $operacion->fecha_operacion = now()->format('Y-m-d H:i:s');
        $operacion->tipo_operacion = $request->tipo_operacion;
        $operacion->id_equipo = $request->id_equipo;
        $operacion->id_persona = $request->id_persona;
        $operacion->id_ubicacion = $request->id_ubicacion;
        $operacion->id_user = $request->id_user;
        $operacion->save();

        return redirect()->action([OperacionController::class, 'index'])->with('mensaje', 'Operación realizada correctamente');
    }
}
