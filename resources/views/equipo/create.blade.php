@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/equipo')}}" method="post">
        @csrf
        @include('equipo.form', ['modo'=>'crear'])
    </form>
</div>

@endsection