<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Operacion;
use Illuminate\Support\Facades\DB;


/*
--------------------------------------------------------------------------
 Autocompletar Controller
--------------------------------------------------------------------------
 Este controlador realiza el manejo de la funcionalidad de autocompletar
 de los campos cod_interno, num_serie y product_number de la funcionalidad
 de consultas

 La relación entre las rutas, el controlador, y los métodos es la siguiente: 

POST     autocompletar/{campo} .................................autocompletar.autosearch › AutocompletarController@search

*/


class AutocompletarController extends Controller
{

    //Método que genera la estructura de la lista de resultados para selececcionar en el campo con
    //la funcionalidad de autocompletar
    public function search(Request $request, $campo)
    {

        //recuperamos el parametro query del query_string con el valor a buscar
        $q = $request->get('query');

        //aplicamos esta funcionalidad a los campos  cod_interno, num_serie y product_number
        if (in_array($campo, ['cod_interno', 'num_serie', 'product_number'])) {

            //realizamos la búsqueda
            $elementos = DB::table('operaciones')
                ->join('equipos', 'operaciones.id_equipo', '=', 'equipos.id')
                ->select('equipos.' . $campo)
                ->where('equipos.' . $campo, 'like', "%$q%")
                ->distinct()
                ->get();

            //Si hemos obtenido resultados montamos el código html con el listado de resultados para incorporar al campo                
            if ($elementos->count() > 0) {

                $output = '<ul class="dropdown-menu" style="display:block;">';
                foreach ($elementos as $elem) {

                    $output .= '<li><a class="dropdown-item" href="#">' . $elem->{$campo} . '</a></li>';
                }
                $output .= '</ul>';
                echo $output;
            }
        }
    }
}
