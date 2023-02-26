@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/tipo_equipo/'.$tipo_equipo->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('tipo_equipo.form', ['modo'=>'editar'])
    </form>

</div>

@endsection