{{-- Plantilla blade de acceso a bienvenida cuando un usuario entra en la aplicacion --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Ha accedido a la plataforma de Gestión de Inventario Hardware para las Administraciones Públicas.
                    <br>Podrá gestionar todo el inventario hardware disponible en su entidad desde un mismo sitio.
                    <br>Acceda a la opción de menú deseada.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection