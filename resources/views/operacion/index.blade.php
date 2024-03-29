{{-- Plantilla blade para mostrar la vista de listado de operaciones --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container-fluid">

    <h1 class="text-center">OPERACIONES</h1>

    {{-- seccion para mostrar los mensajes de exito --}}
    @if(Session::has('mensaje') && Session::get('mensaje')!=="")
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

    <br><br>
    {{-- Definición de la seccion de busqueda. se realiza mediante get por un evento submit --}}
    <form method="GET">
        <div class="input-group mb-3">
            <input type="search" name="query" id="query" value="{{ request()->get('query') }}" class="form-control " placeholder="Buscar..." aria-label="Buscar" aria-describedby="boton-buscar">
            <button class="btn btn-outline-success" type="submit" id="boton-buscar">Buscar</button>
            <button class="btn btn-outline-success" type="submit" id="boton-reset">Reset</button>
        </div>
    </form>

    <div class="card card-body">
        {{-- tabla para mostrar los resultados --}}
        <table class="table table-light table-wide">
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
                {{-- recorremos las operaciones obtenidas desde el controlador para montar el contenido la tabla --}}
                @foreach( $operaciones as $operacion)
                <tr>
                    <td>{{ $operacion->fecha_operacion }}</td>
                    <td>{{ $operacion->tipo_operacion }}</td>
                    <td>{{ $operacion->equipo->tipoEquipo->tipo }}</td>
                    <td>{{ $operacion->equipo->cod_interno }}</td>
                    <td>{{ isset($operacion->id_persona) ? $operacion->persona->nombre .' '. $operacion->persona->apellidos :'' }}</td>
                    <td>{{ isset($operacion->id_ubicacion) ? $operacion->ubicacion->servicio .' - '. $operacion->ubicacion->dependencia : '' }}</td>
                    <td>{{ isset($operacion->id_user) ? $operacion->user->username : '' }}</td>
                    {{-- definimos la columna de acciones --}}
                    <td class="action-column text-nowrap text-center">
                        @if($operacion->tipo_operacion!=="baja")
                        <a href="{{ url('/operacion/'.$operacion->id.'/instalar')}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="instalación">ins</a>
                        <form action="{{ url('/operacion/'.$operacion->id)}}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('PATCH') }}
                            <input name="tipo_operacion" type="hidden" value="almacenaje">
                            <input type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Quieres enviar el equipo al almacén?')" value="alm" data-toggle="tooltip" title="almacenaje">
                        </form>
                        <form action="{{ url('/operacion/'.$operacion->id)}}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('PATCH') }}
                            <input name="tipo_operacion" type="hidden" value="reparacion">
                            <input type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Quieres enviar el equipo a reparación')" value="rep" data-toggle="tooltip" title="reparación">
                        </form>
                        <form action="{{ url('/operacion/'.$operacion->id)}}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('PATCH') }}
                            <input name="tipo_operacion" type="hidden" value="baja">
                            <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres dar de baja al equipo')" value="baja" data-toggle="tooltip" title="baja">
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- totales y paginacion --}}
        {!! $operaciones->links() !!}
        {{ 'Total registros: '. $operaciones->total() }}
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initOperacionIndex();
    });
</script>

@endsection