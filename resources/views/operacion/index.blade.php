@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">OPERACIONES</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif


    <br><br>
    <form method="GET">
        <div class="input-group mb-3">
            <input type="search" name="query" id="query" value="{{ request()->get('query') }}" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="boton-buscar">
            <button class="btn btn-outline-success" type="submit" id="boton-buscar">Buscar</button>
            <button class="btn btn-outline-success" type="submit" id="boton-reset">Reset</button>
        </div>
    </form>

    <table class="table table-light">

        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Tipo Oper.</th>
                <th>Tipo Equ.</th>
                <th>Cod.Interno</th>
                <th>Persona</th>
                <th>Ubicación</th>
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
                <td>{{ isset($operacion->id_user) ? $operacion->user->username : '' }}</td>
                <td class="action-column text-nowrap text-center">
                    <a href="{{ url('/operacion/'.$operacion->id.'/instalar')}}" class="btn btn-sm btn-primary">ins</a>
                    <a href="{{ url('/operacion/'.$operacion->id.'/edit')}}" class="btn btn-sm btn-success">alm</a>
                    <a href="{{ url('/operacion/'.$operacion->id.'/edit')}}" class="btn btn-sm btn-warning">rep</a>
                    <a href="{{ url('/operacion/'.$operacion->id.'/edit')}}" class="btn btn-sm btn-danger">baja</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $operaciones->links() !!}
    {{ 'Total registros: '. $operaciones->total() }}

</div>

<script>
    $(document).ready(function() {

        $("#boton-reset").on('click', function(event) {
            $('#query').val('');
            $("#boton-buscar").click();
        });

    });
</script>

@endsection