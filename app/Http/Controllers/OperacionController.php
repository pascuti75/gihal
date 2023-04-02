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
        //$operaciones_query = Operacion::query();

        // $search_param = $request->query('query');

        $search_param = $request->get('query');


        if ($search_param) {

            $operaciones_query = Operacion::orderBy('id', 'desc')
                ->orCodInternoActiva($search_param)
                ->orTipoOperacionActiva($search_param)
                ->orTecnicoActiva($search_param)
                ->orPersonaActiva($search_param)
                ->orTipoEquipoActiva($search_param)
                ->orUbicacionActiva($search_param)
                ->paginate(5);


            //  $operaciones_query = Operacion::search($search_param)->where('activa', 'si')->orderBy('id', 'desc')->paginate(5);
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
        $mensaje = "";
        $error = "";

        $operacion_anterior  = Operacion::findOrFail($id);
        //si el equipo ya está en baja no podemos hacer ninguna operacion
        if ($operacion_anterior->tipo_operacion == "baja") {
            $error = "No se puede realizar una operación sobre un equipo dado de baja";
        } else {
            //marcamos la operacion actual como no activa para que no se muestre
            $operacion_anterior->activa = "no";
            $operacion_anterior->save();

            //creamos la nueva operacion
            $operacion  = new Operacion();
            $operacion->fecha_operacion = now()->format('Y-m-d H:i:s');
            $operacion->tipo_operacion = $request->tipo_operacion;

            if ($request->tipo_operacion == "instalacion") {
                $operacion->id_equipo = $request->id_equipo;
                $operacion->id_persona = $request->id_persona;
                $operacion->id_ubicacion = $request->id_ubicacion;
                $operacion->id_user = $request->id_user;
                $operacion->save();
            } elseif ($request->tipo_operacion == "almacenaje") {
                $operacion->id_equipo = $operacion_anterior->id_equipo;
                $operacion->id_persona = null;
                $operacion->id_ubicacion = 1;
                $operacion->id_user = auth()->user()->id;
                $operacion->save();
            } elseif (in_array($request->tipo_operacion, ["reparacion", "baja"])) {
                $operacion->id_equipo = $operacion_anterior->id_equipo;
                $operacion->id_persona = $operacion_anterior->id_persona;
                $operacion->id_ubicacion = $operacion_anterior->id_ubicacion;
                $operacion->id_user = auth()->user()->id;
                $operacion->save();
            }

            $mensaje = "Operación realizada correctamente";
        }

        return redirect()->action([OperacionController::class, 'index'])->with('mensaje', $mensaje)->with('error', $error);
    }
}
