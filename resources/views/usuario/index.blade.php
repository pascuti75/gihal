@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">ADMINISTRACIÓN DE USUARIOS</h1>

    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('mensaje') }}
    </div>
    @endif
    @if(Session::has('error') && Session::get('error')!=="")
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif

    <a href="{{ url('/usuario/create') }}" class="btn btn-success">Crear usuario</a>
    <br><br>
    <form method="GET">
        <div class="input-group mb-3">
            <input type="search" name="query" id="query" value="{{ request()->get('query') }}" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="boton-buscar">
            <button class="btn btn-outline-success" type="submit" id="boton-buscar">Buscar</button>
            <button class="btn btn-outline-success" type="submit" id="boton-reset">Reset</button>
        </div>
    </form>


    <div class="card card-body">
        <table class="table table-light">

            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th class="text-center">Administrador</th>
                    <th class="text-center">Gestor</th>
                    <th class="text-center">Técnico</th>
                    <th class="text-center">Consultor</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td class="text-center">@if($user->es_administrador==1) SI @else - @endif</td>
                    <td class="text-center">@if($user->es_gestor==1) SI @else - @endif</td>
                    <td class="text-center">@if($user->es_tecnico==1) SI @else - @endif</td>
                    <td class="text-center">@if($user->es_consultor==1) SI @else - @endif</td>
                    <td class="action-column text-nowrap text-center">
                        <a href="{{ url('/usuario/'.$user->id.'/edit')}}" class="btn btn-sm btn-warning">editar</a>
                        |
                        <form action="{{ url('/usuario/'.$user->id)}}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quieres eliminar el usuario?')" value="eliminar">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $users->links() !!}

        {{ 'Total registros: '. $users->total() }}
    </div>
</div>

<script>
    $(document).ready(function() {
        initUsuarioIndex();
    });
</script>

@endsection