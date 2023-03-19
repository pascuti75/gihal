@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE PERSONAS</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif



    <a href="{{ url('/persona/create') }}" class="btn btn-success">Crear persona</a>
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
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $personas as $persona)
            <tr>
                <td>{{ $persona->id }}</td>
                <td>{{ $persona->nombre }}</td>
                <td>{{ $persona->apellidos }}</td>
                <td>{{ $persona->tipo_personal }}</td>
                <td>
                    <a href="{{ url('/persona/'.$persona->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                    |
                    <form action="{{ url('/persona/'.$persona->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar la persona?')" value="eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $personas->links() !!}
    {{ 'Total registros: '. $personas->total() }}
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