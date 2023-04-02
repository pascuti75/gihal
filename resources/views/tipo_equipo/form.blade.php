<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE TIPO DE EQUIPO
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
        <label for="cod_tipo_equipo">Código:</label>
        <input type="text" class="form-control" name="cod_tipo_equipo" id="cod_tipo_equipo" value="{{ old('cod_tipo_equipo', isset($tipo_equipo->cod_tipo_equipo)?$tipo_equipo->cod_tipo_equipo:old('cod_tipo_equipo')) }} " @if($modo=="editar" ) readonly @endif>    
    </div>

    <div class="form-group">
        <label for="tipo">Tipo:</label>
        <input type="text" class="form-control" name="tipo" id="tipo" value="{{ old('tipo', isset($tipo_equipo->tipo)?$tipo_equipo->tipo:old('tipo')) }}"> 
    </div>


</fieldset>


<br>
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/tipo_equipo') }}" class="btn btn-primary">Cancelar</a>