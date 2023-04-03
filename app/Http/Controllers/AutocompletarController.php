<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Operacion;
use Illuminate\Support\Facades\DB;


class AutocompletarController extends Controller
{
    public function search(Request $request, $campo)
    {

        $q = $request->get('query');

        if (in_array($campo, ['cod_interno', 'num_serie', 'product_number'])) {

            $elementos = DB::table('operaciones')
                ->join('equipos', 'operaciones.id_equipo', '=', 'equipos.id')
                ->select('equipos.' . $campo)
                ->where('equipos.' . $campo, 'like', "%$q%")
                ->distinct()
                ->get();

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
