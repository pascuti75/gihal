{{-- Plantilla blade para mostrar la ficha de la operacion --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container">

    <fieldset class="border border-dark border-1 p-4 mt-4">
        <legend class="float-none w-auto px-3 legend-form">
            FICHA DE OPERACIÓN
        </legend>

        {{--Cargamos cada uno de los campos con la información de la operacion obtenidos desde el controlador --}}
        <div class="form-group row mb-2">
            <div class="col-md-4">
                <label for="tipo_operacion">Tipo de operación:</label>
                <input type="text" class="form-control" name="tipo_operacion" id="tipo_operacion" value="{{ $operacion->tipo_operacion }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="fecha_operacion">Fecha de operación:</label>
                <input type="text" class="form-control" name="fecha_operacion" id="fecha_operacion" value="{{ (new DateTime($operacion->fecha_operacion))->format('d/m/Y H:i:s') }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="tecnico">Técnico:</label>
                <input type="text" class="form-control" name="tecnico" id="tecnico" value="{{ isset($operacion->id_user) ? $operacion->user->username : ''}}" readonly>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-12">
                <label for="equipo">Equipo:</label>
                <input type="text" class="form-control" name="equipo" id="equipo" value="{{$operacion->equipo->cod_interno. ' - '. $operacion->equipo->tipoEquipo->tipo 
                    .': ' . $operacion->equipo->marca . ' ' . $operacion->equipo->modelo . ' - Num. Serie: '. $operacion->equipo->num_serie 
                    . ' - P/N: '. $operacion->equipo->product_number}}" readonly>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-6">
                <label for="persona">Persona:</label>
                <input type="text" class="form-control" name="persona" id="persona" value="{{isset($operacion->id_persona) ? $operacion->persona->nombre. ' '. $operacion->persona->apellidos : ''}}" readonly>
            </div>
            <div class="col-md-6">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" class="form-control" name="ubicacion" id="ubicacion" value="{{isset($operacion->id_ubicacion) ? $operacion->ubicacion->servicio. ' - '. $operacion->ubicacion->dependencia : ''}}" readonly>
            </div>
        </div>
    </fieldset>
    <br>
    {{-- Definimos el boton volver sobre la pagina que hemos accedido --}}
    <a href="{{ url()->previous() }}" class="btn btn-success" id="btn_volver">Volver</a>

</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initConsultaShow();
    });
</script>

@endsection