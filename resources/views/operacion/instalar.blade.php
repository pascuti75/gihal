@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/operacion/'.$operacion->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('operacion.form', ['tipo'=>'instalacion'])
    </form>

</div>

@endsection