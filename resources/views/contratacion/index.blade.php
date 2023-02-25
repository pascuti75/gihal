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
            <input type="text" name="query" value="{{ request()->get('query') }}" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="boton-buscar">
            <button class="btn btn-outline-success" type="submit" id="boton-buscar">Buscar</button>
        </div>
    </form>

    <table class="table table-light">

        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Empresa</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $contrataciones as $contratacion)
            <tr>
                <td>{{ $contratacion->id }}</td>
                <td>{{ $contratacion->titulo }}</td>
                <td>{{ $contratacion->empresa }}</td>
                <td>{{ $contratacion->fecha_inicio }}</td>
                <td>{{ $contratacion->fecha_fin }}</td>
                <td>
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
@endsection