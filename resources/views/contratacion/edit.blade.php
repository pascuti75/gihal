@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/contratacion/'.$contratacion->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('contratacion.form', ['modo'=>'editar'])
    </form>

</div>

@endsection