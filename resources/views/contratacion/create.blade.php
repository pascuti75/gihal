@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/contratacion')}}" method="post">
        @csrf
        @include('contratacion.form', ['modo'=>'crear'])
    </form>
</div>

@endsection