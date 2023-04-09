<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Validator;

/*
--------------------------------------------------------------------------
 Persona Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de la gestión de personas y las redirecciones 
a partir de la funcion definida en las rutas de la gestión de personas

La relación entre las rutas, el controlador, y los métodos es la siguiente: 

GET|HEAD   persona ................................................. persona.index › PersonaController@index  
POST       persona ................................................. persona.store › PersonaController@store  
GET|HEAD   persona/create ......................................... persona.create › PersonaController@create  
PUT|PATCH  persona/{persona} ...................................... persona.update › PersonaController@update  
DELETE     persona/{persona} ..................................... persona.destroy › PersonaController@destroy  
GET|HEAD   persona/{persona}/edit ................................... persona.edit › PersonaController@edit
*/

class PersonaController extends Controller
{

    /*
    Devuelve el listado de personas en función si se ha realizado búsqueda.
    Redirige a la vista con el listado de resultados
   */
    public function index(Request $request)
    {

        //recuperamos de la peticion get el parámetro de búsqueda
        $search_param = $request->query('query');

        //devolvemos el listado de personas total o filtrado en función si disponemos parámetro de búsqueda
        if ($search_param) {
            $personas = Persona::search($search_param)->orderBy('id', 'asc')->paginate(5);
        } else {
            $personas = Persona::paginate(5);
        }

        //Nos redirigimos a la vista del listado de personas con el resultado de personas obtenido
        return view('persona.index', compact('personas', 'search_param'));
    }

    /*
     Redirige a la vista con el formulario de creación de personas
   */
    public function create()
    {
        //se redirige  a la vista /persona/create
        return view('persona.create');
    }

    /*
     Almacena en base de datos la información de la nueva persona creada.
     Redirige a la vista con el listado de personas.
   */
    public function store(Request $request)
    {
        //campos para validar
        $campos = [
            'nombre' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'tipo_personal' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'nombre.required' => 'El :attribute es obligatorio',
            'apellidos.required' => 'Los :attribute son obligatorios',
            'tipo_personal.required' => 'El :attribute es obligatorio',
            'nombre.max' => 'El nombre debe de tener una longitud menor o igual a 250 caracteres',
            'apellidos.max' => 'Los apellidos deben de tener una longitud menor o igual a 250 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);
        //Creamos la nueva persona y la guardamos con los datos registrados por la petición post
        $persona = new Persona($request->all());
        $persona->save();
        //Nos redirigimos a la vista del listado de personas
        return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha creado correctamente');
    }


    /*
     Redirige a la vista con el formulario para la edición de una persona en particular
   */
    public function edit($id)
    {
        //recuperamos la persona a partir de su id recuperado por la petición GET
        $persona = Persona::find($id);
        //Nos redirigimos al formario de edición de la ficha de persona con los datos de la persona recuperada
        return view('persona.edit', compact('persona'));
    }

    /*
     Actualiza en base de datos la información de la persona editada.
     Redirige a la vista con el listado de equipos.
   */
    public function update(Request $request, $id)
    {

        //campos para validar
        $campos = [
            'nombre' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'tipo_personal' => 'required',
        ];

        //mensajes de validación
        $mensaje = [
            'nombre.required' => 'El :attribute es obligatorio',
            'apellidos.required' => 'Los :attribute son obligatorios',
            'tipo_personal.required' => 'El :attribute es obligatorio',
            'nombre.max' => 'El nombre debe de tener una longitud menor o igual a 250 caracteres',
            'apellidos.max' => 'Los apellidos deben de tener una longitud menor o igual a 250 caracteres',
        ];

        //se realiza la validación
        $this->validate($request, $campos, $mensaje);

        //actualizamos en base de datos la información de la persona
        $persona = Persona::find($id);
        $persona->fill($request->all());
        $persona->save();
        //Nos redirigimos a la vista del listado de personas
        return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha modificado correctamente');
    }

    /*
     Eliminamos en base de datos la persona indicada.
     Redirige a la vista con el listado de personas.
   */
    public function destroy($id)
    {

        try {
            //eliminamos en base de datos la persona a partir de su id recuperado de la petición DELETE
            Persona::destroy($id);
            return redirect()->action([PersonaController::class, 'index'])->with('mensaje', 'La persona se ha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->action([PersonaController::class, 'index'])->with('error', 'No es posible eliminar la persona');
        }
    }
}
