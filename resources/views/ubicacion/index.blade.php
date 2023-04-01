@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE UBICACIONES</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif



    <a href="{{ url('/ubicacion/create') }}" class="btn btn-success">Crear ubicación</a>
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
                <th>Servicio</th>
                <th>Dependencia</th>
                <th>Dirección</th>
                <th>Planta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $ubicaciones as $ubicacion)
            <tr>
                <td>{{ $ubicacion->id }}</td>
                <td>{{ $ubicacion->servicio }}</td>
                <td>{{ $ubicacion->dependencia }}</td>
                <td>{{ $ubicacion->direccion }}</td>
                <td>{{ $ubicacion->planta }}</td>
                <td>
                    <a href="{{ url('/ubicacion/'.$ubicacion->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                    |
                    <form action="{{ url('/ubicacion/'.$ubicacion->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar la ubicación?')" value="eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $ubicaciones->links() !!}
    {{ 'Total registros: '. $ubicaciones->total() }}
</div>

<script>
    $(document).ready(function() {
        initUbicacionIndex();
    });
</script>

@endsection