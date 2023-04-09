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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

/*
--------------------------------------------------------------------------
 Consulta Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de las consultas, la generación del inform pdf y las redirecciones 
a partir de la funcion definida en las rutas de las consultas

La relación entre las rutas, el controlador, y los métodos es la siguiente:

GET|HEAD   consulta ............................................... consulta.index › ConsultaController@index  
GET|HEAD   consulta/pdf ............................................. consulta.pdf › ConsultaController@pdf  
GET|HEAD   consulta/{operacion} .................................... consulta.show › ConsultaController@show 

*/

class ConsultaController extends Controller
{
    /*
    Devuelve el listado de resultados de la consulta.
    Redirige a la vista con el listado de resultados
   */
    public function index(Request $request)
    {
        //recuperamos del request los distintos parámetros de búsqueda
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

        //recuperamos los listados de elementos necesarios para los campos de tipo Select
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

        //Realizamos la validación
        $this->validate($request, $campos, $mensaje);

        //Aplicamos los filtros a la operaciones y obtenemos la colección de resultados
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


        //Nos redirigimos a la vista del listado de la consulta con el resultado de la búsqueda de las operaciones y los distintos listados para los campos select 
        return view('consulta.index', compact(['operaciones', 'tipos', 'tecnicos', 'personas', 'ubicaciones', 'contrataciones', 'marcas', 'modelos']))->with('error', $mensaje);
    }


    /*
    Genera un archivo pdf en función de los parámetros de búsquedas aplicados
   */
    public function pdf(Request $request)
    {

        //recuperamos del request los distintos parámetros de búsqueda
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


        //Aplicamos los filtros a la operaciones y obtenemos la colección de resultados
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
            ->get();

        //Cargamos la vista consulta.pdf donde está definida la estructura del informe y le pasamos el listado de operaciones
        $pdf = Pdf::loadView('consulta.pdf', compact(['operaciones']));
        //Configuramos la horientación del pdf
        $pdf->setPaper('A4', 'landscape');
        //Generamos y descargamos el fichero pdf
        return $pdf->download('informe_' . Carbon::now()->format('YmdHis') . '.pdf');
    }



    /*
    Redirige a la vista para mostrar la ficha de la operación pasándole los datos de esta
   */
    public function show($id)
    {
        //recuperamos la operación a partir del parámetro id obtenido de la petición get
        $operacion  = Operacion::find($id);

        //nos redirigimos a la ficha de la operación pasándole la información de esta
        return view('consulta.show', compact('operacion'));
    }
}
