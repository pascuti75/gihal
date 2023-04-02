<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Informe</title>

    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: center;
        }

        td {
            border: 1px solid black;
            padding-left: 3px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .cabecera {
            background-color: black;
            color: white;
        }

        .pagenum:before {
            font-size: 12px;
            margin-left: 20px;
            content: "Página " + counter(page);
        }

        main {
            margin-bottom: 30px;
        }


        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 12px;
            text-align: right;
        }
    </style>
</head>

<body>

    <footer>
        GIHAL. {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}<span class="pagenum"></span>
    </footer>
    <main>
        <h2 class="text-center">INFORME</h2>
        <br>
        <table class="table table-light table-wide">

            <thead class="cabecera">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo Oper.</th>
                    <th>Tipo Equ.</th>
                    <th>Modelo</th>
                    <th>Cod.Interno</th>
                    <th>Num.Serie</th>
                    <th>Persona</th>
                    <th>Ubicación</th>
                    <th>Técnico</th>
            </thead>
            <tbody>
                @foreach( $operaciones as $operacion)
                <tr>
                    <td>{{ $operacion->fecha_operacion }}</td>
                    <td>{{ $operacion->tipo_operacion }}</td>
                    <td>{{ $operacion->equipo->tipoEquipo->tipo }}</td>
                    <td>{{ $operacion->equipo->marca . ' ' .  $operacion->equipo->modelo}}</td>
                    <td>{{ $operacion->equipo->num_serie}}</td>
                    <td>{{ $operacion->equipo->cod_interno }}</td>
                    <td>{{ isset($operacion->id_persona) ? $operacion->persona->nombre .' '. $operacion->persona->apellidos :'' }}</td>
                    <td>{{ isset($operacion->id_ubicacion) ? $operacion->ubicacion->servicio .' - '. $operacion->ubicacion->dependencia : '' }}</td>
                    <td>{{ isset($operacion->id_user) ? $operacion->user->username : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>


</html>