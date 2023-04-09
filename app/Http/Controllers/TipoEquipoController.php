<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoEquipo;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 TipoEquipo Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la gestión de tipos de equipo y las redirecciones 
a partir de la funcion definida en las rutas de la gestión de tipos de equipo.

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   tipo_equipo ......................................... tipo_equipo.index › TipoEquipoController@index  
POST       tipo_equipo ......................................... tipo_equipo.store › TipoEquipoController@store  
GET|HEAD   tipo_equipo/create ................................. tipo_equipo.create › TipoEquipoController@create  
PUT|PATCH  tipo_equipo/{tipo_equipo} .......................... tipo_equipo.update › TipoEquipoController@update  
DELETE     tipo_equipo/{tipo_equipo} ......................... tipo_equipo.destroy › TipoEquipoController@destroy  
GET|HEAD   tipo_equipo/{tipo_equipo}/edit ....................... tipo_equipo.edit › TipoEquipoController@edit  
*/

class TipoEquipoController extends Controller
{

    /*
    Devuelve el listado de tipos de equipo en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de tipos de equipo
   */
    public function index(Request $request)
    {
        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de tipos de equipo total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $tipos_equipo = TipoEquipo::search($search_param)->orderBy('cod_tipo_equipo', 'asc')->paginate(5);
        } else {
            $tipos_equipo = TipoEquipo::orderBy('cod_tipo_equipo', 'asc')->paginate(5);
        }

        //Nos redirigimos a la vista del listado de tipos de equipo con el resultado de tipos de equipo obtenido
        return view('tipo_equipo.index', compact('tipos_equipo', 'search_param'));
    }

    /*
     Redirige a la vista con el formulario de creación de tipos de equipo
   */
    public function create()
    {

        //se redirige  a la vista /tipo_equipo/create
        return view('tipo_equipo.create');
    }

    /*
     Almacena en base de datos la información del nuevo tipo de equipo creado.
     Redirige a la vista con el listado de tipos de equipo.
   */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'cod_tipo_equipo' => 'required|string|max:3|unique:tipos_equipo',
            'tipo' => 'required|string|max:100',
        ];

        //mensajes de validación
        $mensaje = [
            'cod_tipo_equipo.required' => 'El código es obligatorio',
            'cod_tipo_equipo.max' => 'El código debe de tener una longitud menor o igual a 3 caracteres',
            'tipo.required' => 'El tipo es obligatorio',
            'tipo.max' => 'El tipo debe de tener una longitud menor o igual a 100 caracteres',
            'cod_tipo_equipo.unique' => 'El código de tipo de equipo ya está en uso',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //Creamos el nuevo tipo de equipo y lo guardamos con los datos registrados por la petición post
        $tipo_equipo = new TipoEquipo($request->all());
        $tipo_equipo->save();
        //Nos redirigimos a la vista del listado de tipos de equipo
        return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha creado correctamente');
    }


    /*
     Redirige a la vista con el formulario para la edición de un tipo de equipo en particular
   */
    public function edit($id)
    {
        //recuperamos el tipo de equipo a partir de su id recuperado por la petición GET
        $tipo_equipo = TipoEquipo::find($id);
        //Nos redirigimos al formario de edición de la ficha de tipo de equipo con los datos del tipo de equipo recuperado
        return view('tipo_equipo.edit', compact('tipo_equipo'));
    }

    /*
     Actualiza en base de datos la información del tipo de equipo editado.
     Redirige a la vista con el listado de tipos de equipos.
   */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'cod_tipo_equipo' => 'required|string|max:3',
            'tipo' => 'required|string|max:100',
        ];

        //mensajes de validación
        $mensaje = [
            'cod_tipo_equipo.required' => 'El código es obligatorio',
            'cod_tipo_equipo.max' => 'El código debe de tener una longitud menor o igual a 3 caracteres',
            'tipo.required' => 'El tipo es obligatorio',
            'tipo.max' => 'El tipo debe de tener una longitud menor o igual a 100 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información del tipo de equipo
        $tipo_equipo = TipoEquipo::find($id);
        $tipo_equipo->fill($request->all());
        $tipo_equipo->save();
        //Nos redirigimos a la vista del listado detipos de equipo
        return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos el tipo de equipo indicado.
     Redirige a la vista con el listado de tipos de equipo.
   */
    public function destroy($id)
    {
        try {
            //eliminamos en base de datos el tipo de equipo a partir de su id recuperado de la petición DELETE
            TipoEquipo::destroy($id);
            return redirect()->action([TipoEquipoController::class, 'index'])->with('mensaje', 'El tipo de equipo se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([TipoEquipoController::class, 'index'])->with('error', 'No es posible eliminar el tipo de equipo');
        }
    }
}
