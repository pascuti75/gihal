@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/persona/'.$persona->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('persona.form', ['modo'=>'editar'])
    </form>

</div>

@endsection