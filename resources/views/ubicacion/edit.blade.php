{{-- Plantilla blade para editar una ubicacion --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">
    {{-- Creamos el formulario --}}
    <form action="{{url('/ubicacion/'.$ubicacion->id)}}" method="post">
        {{-- genera el token para el formulario --}}
        @csrf
        {{-- indicamos que el metodo de envio es PATCH --}}
        {{ method_field('PATCH') }}
        {{-- incluimos la vista parcial con el contenido del fotmulario. indicamos a la vista parcial que entramos en modo de editar --}}
        @include('ubicacion.form', ['modo'=>'editar'])
    </form>

</div>

@endsection