@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="text-center">GESTIÓN DE CONTRATACIONES</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif



    <a href="{{ url('/contratacion/create') }}" class="btn btn-success">Crear contratación</a>
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
                <th class="text-center">#</th>
                <th class="text-left">Título</th>
                <th class="text-left">Empresa</th>
                <th class="text-center" style="width:100px;">Fecha Inicio</th>
                <th class="text-center" style="width:100px;">Fecha Fin</th>
                <th class="action-column text-nowrap text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $contrataciones as $contratacion)
            <tr>
                <td>{{ $contratacion->id }}</td>
                <td>{{ $contratacion->titulo }}</td>
                <td>{{ $contratacion->empresa }}</td>
                <td class="text-center">{{ date('d/m/Y',strtotime($contratacion->fecha_inicio)) }} </td>
                <td class="text-center">{{ date('d/m/Y',strtotime($contratacion->fecha_fin)) }}</td>
                <td class="text-center">
                    <a href="{{ url('/contratacion/'.$contratacion->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                    |
                    <form action="{{ url('/contratacion/'.$contratacion->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar la contratación?')" value="eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $contrataciones->links() !!}
    {{ 'Total registros: '. $contrataciones->total() }}
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