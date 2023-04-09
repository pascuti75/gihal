{{-- Plantilla blade para mostrar la vista de listado de tipos de equipo --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE TIPOS DE EQUIPO</h1>

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

    {{-- Definición del boton Crear tipo --}}
    <a href="{{ url('/tipo_equipo/create') }}" class="btn btn-success">Crear tipo</a>
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
                    <th class="ancho-50">Código</th>
                    <th>Tipo</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- recorremos los tipos de equipo obtenidos desde el controlador para montar el contenido la tabla --}}
                @foreach( $tipos_equipo as $tipo_equipo)
                <tr>
                    <td class="ancho-50">{{ $tipo_equipo->cod_tipo_equipo }}</td>
                    <td>{{ $tipo_equipo->tipo }}</td>
                    {{-- definimos la columna de acciones --}}
                    <td class="action-column text-nowrap text-center">
                        <a href="{{ url('/tipo_equipo/'.$tipo_equipo->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                        |
                        <form action="{{ url('/tipo_equipo/'.$tipo_equipo->id)}}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar el tipo de equipo?')" value="eliminar">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- totales y paginacion --}}
        {!! $tipos_equipo->links() !!}
        {{ 'Total registros: '. $tipos_equipo->total() }}
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initTipoEquipoIndex();
    });
</script>

@endsection