@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE EQUIPOS</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif



    <a href="{{ url('/equipo/create') }}" class="btn btn-success">Crear equipo</a>
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
                <th>#</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Cod.Interno</th>
                <th>Cod.Externo</th>
                <th>Num.Serie</th>
                <th>Product Number</th>
                <th>ID Contratacion</th>
                <th>Tipo Equipo</th>
                <th class="action-column text-nowrap text-center"F>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $equipos as $equipo)
            <tr>
                <td>{{ $equipo->id }}</td>
                <td>{{ $equipo->marca }}</td>
                <td>{{ $equipo->modelo }}</td>
                <td>{{ $equipo->cod_interno }}</td>
                <td>{{ $equipo->cod_externo }}</td>
                <td>{{ $equipo->num_serie }}</td>
                <td>{{ $equipo->product_number }}</td>
                <td>{{ $equipo->id_contratacion }}</td>
                <td>{{ $equipo->id_tipo_equipo }}</td>
                <td>
                    <a href="{{ url('/equipo/'.$equipo->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                    |
                    <form action="{{ url('/equipo/'.$equipo->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar el equipo?')" value="eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $equipos->links() !!}
    {{ 'Total registros: '. $equipos->total() }}
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