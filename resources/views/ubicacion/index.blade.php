{{-- Plantilla blade para mostrar la vista de listado de ubicaciones --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE UBICACIONES</h1>

    {{-- seccion para mostrar los mensajes de exito --}}
    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif
    {{-- seccion para mostrar los mensajes de error --}}
    @if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif

    {{-- Definición del boton Crear ubicacion --}}
    <a href="{{ url('/ubicacion/create') }}" class="btn btn-success">Crear ubicación</a>
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
                    <th>Servicio</th>
                    <th>Dependencia</th>
                    <th>Dirección</th>
                    <th class="text-center">Planta</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- recorremos las ubicaciones obtenidas desde el controlador para montar el contenido la tabla --}}
                @foreach( $ubicaciones as $ubicacion)
                <tr>
                    <td>{{ $ubicacion->id }}</td>
                    <td>{{ $ubicacion->servicio }}</td>
                    <td>{{ $ubicacion->dependencia }}</td>
                    <td>{{ $ubicacion->direccion }}</td>
                    {{-- definimos la columna de acciones --}}
                    <td class="text-center">{{ $ubicacion->planta }}</td>
                    <td class="action-column text-nowrap text-center">
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
        {{-- totales y paginacion --}}
        {!! $ubicaciones->links() !!}
        {{ 'Total registros: '. $ubicaciones->total() }}
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initUbicacionIndex();
    });
</script>

@endsection