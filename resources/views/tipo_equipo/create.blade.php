@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/tipo_equipo')}}" method="post">
        @csrf
        @include('tipo_equipo.form', ['modo'=>'crear'])
    </form>
</div>

@endsection