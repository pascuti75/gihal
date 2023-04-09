<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\Contratacion;
use App\Models\Operacion;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 Equipo Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la gestión de equipos y las redirecciones 
a partir de la funcion definida en las rutas de la gestión de equipos

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   equipo ................................................... equipo.index › EquipoController@index  
POST       equipo ................................................... equipo.store › EquipoController@store  
GET|HEAD   equipo/create ........................................... equipo.create › EquipoController@create  
PUT|PATCH  equipo/{equipo} ......................................... equipo.update › EquipoController@update  
DELETE     equipo/{equipo} ........................................ equipo.destroy › EquipoController@destroy  
GET|HEAD   equipo/{equipo}/edit ...................................... equipo.edit › EquipoController@edit
*/

class EquipoController extends Controller
{

    /*
    Devuelve el listado de equipos en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de resultados
   */
    public function index(Request $request)
    {
        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de equipos total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $equipos = Equipo::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $equipos = Equipo::orderBy('id', 'asc')->paginate(5);
        }

        //Nos redirigimos a la vista del listado de equipos con el resultado de equipos obtenido
        return view('equipo.index', compact('equipos', 'search_param'));
    }

    /*
     Redirige a la vista con el formulario de creación de equipos
   */
    public function create()
    {

        //para campo combo selector de tipo
        $tipos  = TipoEquipo::all()->sortBy("tipo");
        //para campo combo selector de contratacion
        $contrataciones  = Contratacion::all()->sortBy("titulo");

        //se redirige  a la vista /equipo/create
        return view('equipo.create', compact(['tipos', 'contrataciones']));
    }

    /*
     Almacena en base de datos la información del nuevo equipo creado.
     Redirige a la vista con el listado de equipos.
   */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'cod_interno' => 'nullable|string|max:100',
            'cod_externo' => 'nullable|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:250',
            'product_number' => 'nullable|string|max:250',
            'num_serie' => 'required|string|max:100',
            'id_tipo_equipo' => 'required',
        ];


        //mensajes de validación
        $mensaje = [
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'num_serie.required' => 'El número de serie es obligatorio',
            'id_tipo_equipo.required' => 'El tipo es obligatorio',
            'cod_interno.max' => 'El código interno debe de tener una longitud menor o igual a 100 caracteres',
            'cod_externo.max' => 'El código externo debe de tener una longitud menor o igual a 100 caracteres',
            'marca.max' => 'La marca debe de tener una longitud menor o igual a 100 caracteres',
            'modelo.max' => 'El modelo debe de tener una longitud menor o igual a 250 caracteres',
            'product_number.max' => 'El product number debe de tener una longitud menor o igual a 250 caracteres',
            'num_serie.max' => 'El número de serie debe de tener una longitud menor o igual a 100 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);
        //Creamos el nuevo equipo y la guardamos con los datos registrados por la petición post
        $equipo  = new Equipo($request->all());
        $equipo->save();

        //creamos la operacion de almacenaje asociada a la creacion del equipo
        $operacion  = new Operacion();
        $operacion->fecha_operacion = now()->format('Y-m-d H:i:s');
        $operacion->tipo_operacion = 'almacenaje';
        $operacion->id_equipo = $equipo->id;
        $operacion->id_ubicacion = 1; //la ubicacion 1 siempre debe de ser el almacen
        $operacion->save();

        //Nos redirigimos a la vista del listado de equipos
        return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha creado correctamente');
    }


    /*
     Redirige a la vista con el formulario para la edición de un equipo en particular
   */
    public function edit($id)
    {
        //recuperamos el equipo a partir de su id recuperado por la petición GET
        $equipo  = Equipo::find($id);
        //para campo combo selector de tipo
        $tipos  = TipoEquipo::all()->sortBy("tipo");
        //para campo combo selector de contratacion
        $contrataciones  = Contratacion::all()->sortBy("titulo");
        //Nos redirigimos al formario de edición de la ficha de equipo con los datos del equipo recuperado
        return view('equipo.edit', compact('equipo', 'tipos', 'contrataciones'));
    }

    /*
     Actualiza en base de datos la información del equipo editado.
     Redirige a la vista con el listado de equipos.
   */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'cod_interno' => 'nullable|string|max:100',
            'cod_externo' => 'nullable|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:250',
            'product_number' => 'nullable|string|max:250',
            'num_serie' => 'required|string|max:100',
            'id_tipo_equipo' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'num_serie.required' => 'El número de serie es obligatorio',
            'id_tipo_equipo.required' => 'El tipo es obligatorio',
            'cod_interno.max' => 'El código interno debe de tener una longitud menor o igual a 100 caracteres',
            'cod_externo.max' => 'El código externo debe de tener una longitud menor o igual a 100 caracteres',
            'marca.max' => 'La marca debe de tener una longitud menor o igual a 100 caracteres',
            'modelo.max' => 'El modelo debe de tener una longitud menor o igual a 250 caracteres',
            'product_number.max' => 'El product number debe de tener una longitud menor o igual a 250 caracteres',
            'num_serie.max' => 'El número de serie debe de tener una longitud menor o igual a 100 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información del equipo
        $equipo  = Equipo::find($id);
        $equipo->fill($request->all());
        $equipo->save();
        //Nos redirigimos a la vista del listado de equipos
        return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos el equipo indicado.
     Redirige a la vista con el listado de equipos.
   */
    public function destroy($id)
    {
        try {
            //eliminamos en base de datos el equipo a partir de su id recuperado de la petición DELETE
            Equipo::destroy($id);
            return redirect()->action([EquipoController::class, 'index'])->with('mensaje', 'El equipo se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([EquipoController::class, 'index'])->with('error', 'No es posible eliminar el equipo');
        }
    }
}
