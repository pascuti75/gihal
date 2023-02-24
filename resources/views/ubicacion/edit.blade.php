@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/ubicacion/'.$ubicacion->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('ubicacion.form', ['modo'=>'editar'])
    </form>

</div>

@endsection