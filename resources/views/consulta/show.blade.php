@extends('layouts.app')

@section('content')
<div class="container">

    <fieldset class="border border-dark border-1 p-4 mt-4">
        <legend class="float-none w-auto px-3 legend-form">
            FICHA DE OPERACIÓN
        </legend>

        <div class="form-group row mb-2">
            <div class="col-md-6">
                <label for="tipo_operacion">Tipo de operación:</label>
                <input type="text" class="form-control" name="tipo_operacion" id="tipo_operacion" value="{{ $operacion->tipo_operacion }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="fecha_operacion">Fecha de operación:</label>
                <input type="text" class="form-control" name="fecha_operacion" id="fecha_operacion" value="{{ $operacion->fecha_operacion }}" readonly>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-12">
                <label for="equipo">Equipo:</label>
                <input type="text" class="form-control" name="equipo" id="equipo" value="{{ $operacion->equipo->tipoEquipo->tipo 
                    .': ' . $operacion->equipo->marca . ' ' . $operacion->equipo->modelo}}" readonly>
            </div>
        </div>
    </fieldset>

</div>

@endsection