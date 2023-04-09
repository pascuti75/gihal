{{-- Plantilla blade para crear un tipo de equipo --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">
    {{-- Creamos el formulario --}}
    <form action="{{url('/tipo_equipo')}}" method="post">
        {{-- genera el token para el formulario --}}
        @csrf
        {{-- incluimos la vista parcial con el contenido del fotmulario. indicamos a la vista parcial que entramos en modo de crear --}}
        @include('tipo_equipo.form', ['modo'=>'crear'])
    </form>
</div>

@endsection