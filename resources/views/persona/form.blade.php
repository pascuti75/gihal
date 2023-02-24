<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE PERSONA
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
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ isset($persona->nombre)?$persona->nombre:old('nombre') }}">
    </div>

    <div class="form-group">
        <label for="apellidos">Apellidos:</label>
        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ isset($persona->apellidos)?$persona->apellidos:old('apellidos') }}">
    </div>


    <div class="form-group">
        <label for="tipo_personal">Tipo:</label>
        <input type="text" class="form-control" name="tipo_personal" id="tipo_personal" value="{{ isset($persona->tipo_personal)?$persona->tipo_personal:old('tipo_personal') }}">
    </div>


</fieldset>


<br>
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/persona') }}" class="btn btn-primary">Cancelar</a>