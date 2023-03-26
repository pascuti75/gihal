@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="text-center">CONSULTAS</h1>

    <table class="table table-light" style="font-size:13px">

        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Tipo Oper.</th>
                <th>Tipo Equ.</th>
                <th>Cod.Interno</th>
                <th>Persona</th>
                <th>Ubicación</th>
                <th>Empresa</th>
                <th>Técnico</th>
                <th class="action-column text-nowrap text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $operaciones as $operacion)
            <tr>
                <td>{{ $operacion->fecha_operacion }}</td>
                <td>{{ $operacion->tipo_operacion }}</td>
                <td>{{ $operacion->equipo->tipoEquipo->tipo }}</td>
                <td>{{ $operacion->equipo->cod_interno }}</td>
                <td>{{ isset($operacion->id_persona) ? $operacion->persona->nombre .' '. $operacion->persona->apellidos :'' }}</td>
                <td>{{ isset($operacion->id_ubicacion) ? $operacion->ubicacion->servicio .' - '. $operacion->ubicacion->dependencia : '' }}</td>
                <td>{{ isset($operacion->equipo->contratacion) ? $operacion->equipo->contratacion->empresa : '' }}</td>
                <td>{{ isset($operacion->id_user) ? $operacion->user->username : '' }}</td>
                <td class="action-column text-nowrap text-center">

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $operaciones->links() !!}
    {{ 'Total registros: '. $operaciones->total() }}

</div>



</div>


@endsection