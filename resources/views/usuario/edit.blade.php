@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/usuario/'.$user->id)}}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('usuario.form', ['modo'=>'editar'])
    </form>

</div>

@endsection