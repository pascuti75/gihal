<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratacion;
use Illuminate\Support\Facades\Validator;


/*
--------------------------------------------------------------------------
 Contratacion Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la gestión de contrataciones y las redirecciones 
a parttir de la funcion definida en las rutas de la gestión de contrataciones

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   contratacion ....................................... contratacion.index › ContratacionController@index  
POST       contratacion ....................................... contratacion.store › ContratacionController@store  
GET|HEAD   contratacion/create ............................... contratacion.create › ContratacionController@create  
GET|HEAD   contratacion/{contratacion} ......................... contratacion.show › ContratacionController@show  
PUT|PATCH  contratacion/{contratacion} ....................... contratacion.update › ContratacionController@update  
DELETE     contratacion/{contratacion} ...................... contratacion.destroy › ContratacionController@destroy  
GET|HEAD   contratacion/{contratacion}/edit .................... contratacion.edit › ContratacionController@edit

*/


class ContratacionController extends Controller
{

    /*
    Devuelve el listado de contrataciones en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de resultados
   */
    public function index(Request $request)
    {
        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de contrataciones total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $contrataciones = Contratacion::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $contrataciones = Contratacion::paginate(5);
        }

        //Nos redirigimos a la vista del listado de contrataciones con el resultado de contrataciones obtenido
        return view('contratacion.index', compact('contrataciones', 'search_param'));
    }

    /*
     Redirige a la vista con el formulario de creación de contrataciones
   */
    public function create()
    {
        return view('contratacion.create');
    }

    /*
     Almacena en base de datos la información de la nueva contratación creada.
     Redirige a la vista con el listado de contrataciones.
   */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'titulo' => 'required|string|max:500',
            'empresa' => 'required|string|max:250',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
        ];

        //mensajes de validación
        $mensaje = [
            'titulo.required' => 'El :attribute es obligatorio',
            'empresa.required' => 'La :attribute es obligatoria',
            'fecha_inicio.date' => 'La fecha de inicio no es una fecha válida',
            'fecha_fin.date' => 'La fecha de fin no es una fecha válida',
            'fecha_fin.after' => 'La fecha de fin debe de ser posterior a la fecha de inicio',
            'titulo.max' => 'El título debe de tener una longitud menor o igual a 500 caracteres',
            'empresa.max' => 'La empresa debe de tener una longitud menor o igual a 250 caracteres',
        ];


        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //Creamos la nueva contratación y la guardamos con los datos registrados por la petición post
        $contratacion = new Contratacion($request->all());
        $contratacion->save();
        //Nos redirigimos a la vista del listado de contrataciones
        return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha creado correctamente');
    }

    /**
     * No aplica en este proyecto
     */
    public function show(Contratacion $contratacion)
    {
        //
    }

    /*
     Redirige a la vista con el formulario para la edición de una contratación en particular
   */
    public function edit($id)
    {
        //recuperamos la contratación a partir de su id recuperado por la petición GET
        $contratacion = Contratacion::findOrFail($id);
        //Nos redirigimos al formario de edición de la ficha de operación con los datos de la operación recuperada
        return view('contratacion.edit', compact('contratacion'));
    }

    /*
     Actualiza en base de datos la información de la contratación editada.
     Redirige a la vista con el listado de contrataciones.
   */
    public function update(Request $request, $id)
    {
        //campos para validar
        $campos = [
            'titulo' => 'required|string|max:500',
            'empresa' => 'required|string|max:250',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
        ];

        //mensajes de validación
        $mensaje = [
            'titulo.required' => 'El :attribute es obligatorio',
            'empresa.required' => 'La :attribute es obligatoria',
            'fecha_inicio.date' => 'La fecha de inicio no es una fecha válida',
            'fecha_fin.date' => 'La fecha de fin no es una fecha válida',
            'fecha_fin.after' => 'La fecha de fin debe de ser posterior a la fecha de inicio',
            'titulo.max' => 'El título debe de tener una longitud menor o igual a 500 caracteres',
            'empresa.max' => 'La empresa debe de tener una longitud menor o igual a 250 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información de la contratación
        $contratacion = Contratacion::findOrFail($id);
        $contratacion->fill($request->all());
        $contratacion->save();
        //Nos redirigimos a la vista del listado de contrataciones
        return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos la contratación indicada.
     Redirige a la vista con el listado de contrataciones.
   */
    public function destroy($id)
    {
        try {
            //eliminamos en base de datos la contratacion a partir de su id recuperado de la petición DELETE
            Contratacion::destroy($id);
            return redirect()->action([ContratacionController::class, 'index'])->with('mensaje', 'La contratación se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([ContratacionController::class, 'index'])->with('error', 'No es posible eliminar la contratación');
        }
    }
}
