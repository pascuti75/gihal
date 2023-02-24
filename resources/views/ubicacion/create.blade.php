@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/ubicacion')}}" method="post">
        @csrf
        @include('ubicacion.form', ['modo'=>'crear'])
    </form>
</div>

@endsection