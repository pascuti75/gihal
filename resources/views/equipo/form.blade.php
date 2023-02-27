<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE EQUIPO
    </legend>


    @if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error)

            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-group">
        <label for="cod_interno">Código interno:</label>
        <input type="text" class="form-control" name="cod_interno" id="cod_interno" value="{{ isset($equipo->cod_interno)?$equipo->cod_interno:old('cod_interno') }}">
    </div>

    <div class="form-group">
        <label for="cod_externo">Código externo:</label>
        <input type="text" class="form-control" name="cod_externo" id="cod_externo" value="{{ isset($equipo->cod_externo)?$equipo->cod_externo:old('cod_externo') }}">
    </div>

    <div class="form-group">
        <label for="marca">Marca:</label>
        <input type="text" class="form-control" name="marca" id="marca" value="{{ isset($equipo->marca)?$equipo->marca:old('marca') }}">
    </div>

    <div class="form-group">
        <label for="modelo">Modelo:</label>
        <input type="text" class="form-control" name="modelo" id="modelo" value="{{ isset($equipo->modelo)?$equipo->modelo:old('modelo') }}">
    </div>

    <div class="form-group">
        <label for="product_number">Product Number:</label>
        <input type="text" class="form-control" name="product_number" id="product_number" value="{{ isset($equipo->product_number)?$equipo->product_number:old('product_number') }}">
    </div>

    <div class="form-group">
        <label for="num_serie">Número de serie:</label>
        <input type="text" class="form-control" name="num_serie" id="num_serie" value="{{ isset($equipo->num_serie)?$equipo->num_serie:old('num_serie') }}">
    </div>

    <div class="form-group">
        <label for="id_contratacion">Contratación:</label>
        <input type="text" class="form-control" name="id_contratacion" id="id_contratacion" value="{{ isset($equipo->id_contratacion)?$equipo->id_contratacion:old('id_contratacion') }}">
    </div>
    <!--
    <div class="form-group">
        <label for="id_tipo_equipo">Tipo de equipo:</label>
        <input type="text" class="form-control" name="id_tipo_equipo" id="id_tipo_equipo" value="{{ isset($equipo->id_tipo_equipo)?$equipo->id_tipo_equipo:old('id_tipo_equipo') }}">
    </div>
-->
    <div class="form-group">
        <label for="id_tipo_equipo">Tipo de equipo:</label>
        <select class="form-control" name="id_tipo_equipo" id="id_tipo_equipo">
            <option value="option_select" disabled selected>Seleccionar</option>
            @foreach ($tipos as $tipo)
            <option value="{{$tipo->id}}" {{old('id') == $tipo->id ? 'selected' : ''}}>{{$tipo->tipo}}</option>
            @endforeach
        </select>
    </div>

</fieldset>


<br>
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/ubicacion') }}" class="btn btn-primary">Cancelar</a>