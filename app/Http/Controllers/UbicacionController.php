<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 Ubicacion Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la gestión de ubicaciones y las redirecciones 
a partir de la funcion definida en las rutas de la gestión de ubicaciones

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   ubicacion ............................................. ubicacion.index › UbicacionController@index  
POST       ubicacion ............................................. ubicacion.store › UbicacionController@store  
GET|HEAD   ubicacion/create ..................................... ubicacion.create › UbicacionController@create  
PUT|PATCH  ubicacion/{ubicacion} ................................ ubicacion.update › UbicacionController@update  
DELETE     ubicacion/{ubicacion} ............................... ubicacion.destroy › UbicacionController@destroy  
GET|HEAD   ubicacion/{ubicacion}/edit ............................. ubicacion.edit › UbicacionController@edit  

*/

class UbicacionController extends Controller
{

    /*
    Devuelve el listado de ubicaciones en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de ubicaciones
   */
    public function index(Request $request)
    {

        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de ubicaciones total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $ubicaciones = Ubicacion::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $ubicaciones = Ubicacion::paginate(5);
        }

        //Nos redirigimos a la vista del listado de ubicaciones con el resultado de ubicaciones obtenido
        return view('ubicacion.index', compact('ubicaciones', 'search_param'));
    }

    /*
     Redirige a la vista con el formulario de creación de ubicaciones
   */
    public function create()
    {
        //se redirige  a la vista /ubicacion/create
        return view('ubicacion.create');
    }

    /*
     Almacena en base de datos la información de la nueva ubicacion creada.
     Redirige a la vista con el listado de ubicaciones.
   */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'servicio' => 'required|string|max:250',
            'dependencia' => 'required|string|max:250',
            'direccion' => 'required|string|max:500',
            'planta' => 'max:30'
        ];

        //mensajes de validación
        $mensaje = [
            'required' => 'La :attribute es obligatoria',
            'servicio.required' => 'El :attribute es obligatorio',
            'servicio.max' => 'El servicio debe de tener una longitud menor o igual a 250 caracteres',
            'dependencia.max' => 'La dependencia debe de tener una longitud menor o igual a 250 caracteres',
            'direccion.max' => 'La dirección debe de tener una longitud menor o igual a 500 caracteres',
            'planta.max' => 'La planta debe de tener una longitud menor o igual a 30 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);
        //Creamos la nueva ubicacion y la guardamos con los datos registrados por la petición post
        $ubicacion = new Ubicacion($request->all());
        $ubicacion->save();
        //Nos redirigimos a la vista del listado de ubicaciones
        return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha creado correctamente');
    }


    /*
     Redirige a la vista con el formulario para la edición de una ubicacion en particular
   */
    public function edit($id)
    {
        //recuperamos la ubicacion a partir de su id recuperado por la petición GET
        $ubicacion = Ubicacion::find($id);
        //Nos redirigimos al formario de edición de la ficha de ubicacion con los datos de la ubicacion recuperada
        return view('ubicacion.edit', compact('ubicacion'));
    }

    /*
     Actualiza en base de datos la información de la ubicacion editada.
     Redirige a la vista con el listado de ubicaciones.
   */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'servicio' => 'required|string|max:250',
            'dependencia' => 'required|string|max:250',
            'direccion' => 'required|string|max:500',
            'planta' => 'max:30'
        ];

        //mensajes de validación
        $mensaje = [
            'required' => 'La :attribute es obligatoria',
            'direccion.required' => 'La dirección es obligatoria',
            'servicio.required' => 'El :attribute es obligatorio',
            'servicio.max' => 'El servicio debe de tener una longitud menor o igual a 250 caracteres',
            'dependencia.max' => 'La dependencia debe de tener una longitud menor o igual a 250 caracteres',
            'direccion.max' => 'La dirección debe de tener una longitud menor o igual a 500 caracteres',
            'planta.max' => 'La planta debe de tener una longitud menor o igual a 30 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información de la ubicacion
        $ubicacion = Ubicacion::find($id);
        $ubicacion->fill($request->all());
        $ubicacion->save();
        //Nos redirigimos a la vista del listado de ubicaciones
        return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos la ubicacion indicada.
     Redirige a la vista con el listado de ubicaciones.
   */
    public function destroy($id)
    {
        try {
            //eliminamos en base de datos la ubicacion a partir de su id recuperado de la petición DELETE
            Ubicacion::destroy($id);
            return redirect()->action([UbicacionController::class, 'index'])->with('mensaje', 'La ubicación se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([UbicacionController::class, 'index'])->with('error', 'No es posible eliminar la ubicación');
        }
    }
}
