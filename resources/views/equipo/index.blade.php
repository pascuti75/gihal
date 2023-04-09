{{-- Plantilla blade para mostrar la vista de listado de equipos --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">

    <h1 class="text-center">GESTIÓN DE EQUIPOS</h1>

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


    {{-- Definición del boton Crear equipo --}}
    <a href="{{ url('/equipo/create') }}" class="btn btn-success">Crear equipo</a>
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
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cod.Interno</th>
                    <th>Cod.Externo</th>
                    <th>Num.Serie</th>
                    <th>Product Number</th>
                    <th class="text-center">Contrato</th>
                    <th class="text-center">Tipo Equipo</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- recorremos los equipos obtenidos desde el controlador para montar el contenido la tabla --}}
                @foreach( $equipos as $equipo)
                <tr>
                    <td>{{ $equipo->id }}</td>
                    <td>{{ $equipo->marca }}</td>
                    <td>{{ $equipo->modelo }}</td>
                    <td>{{ $equipo->cod_interno }}</td>
                    <td>{{ $equipo->cod_externo }}</td>
                    <td>{{ $equipo->num_serie }}</td>
                    <td>{{ $equipo->product_number }}</td>
                    {{-- definimos la columna de acciones --}}
                    <td class="text-center">
                        @if ($equipo->id_contratacion!=null)
                        <a class="btn btn-sm btn-outline-secondary" href="#" data-toggle="tooltip" title="{{ $equipo->contratacion->empresa.': '.$equipo->contratacion->titulo . 
                        '   Fecha Inicio: '. date('d/m/Y',strtotime($equipo->contratacion->fecha_inicio)) . '   Fecha Fin: '. 
                        date('d/m/Y',strtotime($equipo->contratacion->fecha_fin))}}">ver</a>
                        @endif
                    </td>
                    <td class="text-center">{{ $equipo->tipoEquipo->tipo }}</td>
                    <td class="action-column text-nowrap text-center">
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
        {{-- totales y paginacion --}}
        {!! $equipos->links() !!}
        {{ 'Total registros: '. $equipos->total() }}
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initEquipoIndex();
    });
</script>

@endsection