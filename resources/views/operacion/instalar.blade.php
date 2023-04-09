{{-- Plantilla blade para instalar un equipo --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">
    {{-- Creamos el formulario --}}
    <form action="{{url('/operacion/'.$operacion->id)}}" method="post">
        {{-- genera el token para el formulario --}}
        @csrf
        {{-- indicamos que el metodo de envio es PATCH --}}
        {{ method_field('PATCH') }}
        {{-- incluimos la vista parcial con el contenido del formulario. indicamos a la vista parcial que entramos con el tipo instalacion --}}
        @include('operacion.form', ['tipo'=>'instalacion'])
    </form>

</div>

@endsection