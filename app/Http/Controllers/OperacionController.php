<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 Operacion Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de las operaciones sobre los equipos y las redirecciones 
a partir de la funcion definida en las rutas de las operaciones

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   operacion ............................................. operacion.index › OperacionController@index  
GET|HEAD   operacion/{id}/instalar ................................................. OperacionController@edit  
PUT|PATCH  operacion/{operacion} ................................ operacion.update › OperacionController@update  
*/


class OperacionController extends Controller
{
    /*
    Devuelve el listado de operaciones en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de operacioness
   */
    public function index(Request $request)
    {
        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->get('query');

        //devolvemos el listado de operaciones total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $operaciones = Operacion::orderBy('id', 'desc')
                ->orCodInternoActiva($search_param)
                ->orTipoOperacionActiva($search_param)
                ->orTecnicoActiva($search_param)
                ->orPersonaActiva($search_param)
                ->orTipoEquipoActiva($search_param)
                ->orUbicacionActiva($search_param)
                ->paginate(5);
        } else {
            $operaciones = Operacion::where('activa', 'si')->orderBy('id', 'desc')->paginate(5);
        }

        //Nos redirigimos a la vista del listado de operaciones con el resultado de operaciones obtenido
        return view('operacion.index', compact('operaciones', 'search_param'));
    }


    /*
     Redirige a la vista con el formulario para realizar una operacion de instalacion
   */
    public function edit($id)
    {
        //recuperamos la operacion a partir de su id recuperado por la petición GET
        $operacion  = Operacion::find($id);
        //para campo combo selector de persona
        $personas  = Persona::all()->sortBy(["apellidos", "nombre"]);
        //para campo combo selector de ubicaciones
        $ubicaciones  = Ubicacion::all()->sortBy(["servicio", "dependencia"]);
        //para campo combo selector de equipos
        $equipos  = Equipo::all()->sortBy(["cod_interno"]);
        //para campo combo selector de users
        $users  = User::all()->sortBy(["username"]);
        //Nos redirigimos al formario de instalacion con los datos de la operacion anterior recuperados
        return view('operacion.instalar', compact('operacion', 'personas', 'ubicaciones', 'equipos', 'users'));
    }


    /*
     Actualiza en base de datos la información de la operacion realizada.
     Redirige a la vista con el listado de equipos.
   */
    public function update(Request $request, $id)
    {
        $mensaje = "";
        $error = "";

        //recuperamos la información de la ultima operación realizada sobre el equipo
        $operacion_anterior  = Operacion::find($id);
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

            if ($request->tipo_operacion == "instalacion") { //rellenamos y guardamos la informacion de la operacion para el caso de una instalacion
                $operacion->id_equipo = $request->id_equipo;
                $operacion->id_persona = $request->id_persona;
                $operacion->id_ubicacion = $request->id_ubicacion;
                $operacion->id_user = $request->id_user;
                $operacion->save();
            } elseif ($request->tipo_operacion == "almacenaje") { //rellenamos y guardamos la informacion de la operacion para el caso de una instalacion
                $operacion->id_equipo = $operacion_anterior->id_equipo;
                $operacion->id_persona = null;
                $operacion->id_ubicacion = 1;
                $operacion->id_user = auth()->user()->id;
                $operacion->save();
            } elseif (in_array($request->tipo_operacion, ["reparacion", "baja"])) { //rellenamos y guardamos la informacion de la operacion para el caso de una reparacion o baja
                $operacion->id_equipo = $operacion_anterior->id_equipo;
                $operacion->id_persona = $operacion_anterior->id_persona;
                $operacion->id_ubicacion = $operacion_anterior->id_ubicacion;
                $operacion->id_user = auth()->user()->id;
                $operacion->save();
            }

            $mensaje = "Operación realizada correctamente";
        }

        //Nos redirigimos a la vista del listado de operaciones
        return redirect()->action([OperacionController::class, 'index'])->with('mensaje', $mensaje)->with('error', $error);
    }
}
