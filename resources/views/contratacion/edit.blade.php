{{-- Plantilla blade para editar una contratacion --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">
    {{-- Creamos el formulario --}}
    <form action="{{url('/contratacion/'.$contratacion->id)}}" method="post">
        {{-- genera el token para el formulario --}}
        @csrf
        {{-- indicamos que el metodo de envio es PATCH --}}
        {{ method_field('PATCH') }}
        {{-- incluimos la vista parcial con el contenido del fotmulario. indicamos a la vista parcial que entramos en modo de editar --}}
        @include('contratacion.form', ['modo'=>'editar'])
    </form>

</div>

@endsection