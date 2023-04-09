{{-- Plantilla blade para crear una contratacion --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')

<div class="container">
    {{-- Creamos el formulario --}}
    <form action="{{url('/contratacion')}}" method="post">
        {{-- genera el token para el formulario --}}
        @csrf
        {{-- incluimos la vista parcial con el contenido del fotmulario. indicamos a la vista parcial que entramos en modo de crear --}}
        @include('contratacion.form', ['modo'=>'crear'])
    </form>
</div>

@endsection