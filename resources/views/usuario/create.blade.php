@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/usuario')}}" method="post">
        @csrf
        @include('usuario.form', ['modo'=>'crear'])
    </form>
</div>

@endsection