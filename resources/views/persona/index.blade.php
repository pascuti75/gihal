{{-- Plantilla blade para mostrar la vista de listado de personas --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE PERSONAS</h1>

    {{-- seccion para mostrar los mensajes de exito --}}
    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif
    {{-- seccion para mostrar los mensajes de error --}}
    @if(Session::has('error') && Session::get('error')!=="")
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif


    {{-- Definición del boton Crear persona --}}
    <a href="{{ url('/persona/create') }}" class="btn btn-success">Crear persona</a>
    <br><br>
    {{-- Definición de la seccion de busqueda. se realiza mediante get por un evento submit --}}
    <form method="GET">
        <div class="input-group mb-3">
            <input type="search" name="query" id="query" value="{{ request()->get('query') }}" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="boton-buscar">
            <button class="btn btn-outline-success" type="submit" id="boton-buscar">Buscar</button>
            <button class="btn btn-outline-success" type="submit" id="boton-reset">Reset</button>
        </div>
    </form>

    <div class="card card-body">
        {{-- tabla para mostrar los resultados --}}
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th class="text-center">Tipo</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- recorremos las personas obtenidas desde el controlador para montar el contenido la tabla --}}
                @foreach( $personas as $persona)
                <tr>
                    <td>{{ $persona->id }}</td>
                    <td>{{ $persona->nombre }}</td>
                    <td>{{ $persona->apellidos }}</td>
                    <td class="text-center">{{ $persona->tipo_personal }}</td>
                    {{-- definimos la columna de acciones --}}
                    <td class="action-column text-nowrap text-center">
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
        {{-- totales y paginacion --}}
        {!! $personas->links() !!}
        {{ 'Total registros: '. $personas->total() }}
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initPersonaIndex();
    });
</script>

@endsection