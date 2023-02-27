@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/equipo/'.$equipo->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('equipo.form', ['modo'=>'editar'])
    </form>

</div>

@endsection