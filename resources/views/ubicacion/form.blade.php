<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE UBICACIÓN
    </legend>

    {{-- Seccion para mostrar los errores de validacion --}}
    @if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error)
            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Cargamos todos los campos del formulario y su contenido en el caso de la edición o la validación--}}
    <div class="form-group">
        <label for="servicio">Servicio:</label>
        <input type="text" class="form-control" name="servicio" id="servicio" value="{{ old('servicio', isset($ubicacion->servicio)?$ubicacion->servicio:old('servicio')) }}">
    </div>

    <div class="form-group">
        <label for="dependencia">Dependencia:</label>
        <input type="text" class="form-control" name="dependencia" id="dependencia" value="{{ old('dependencia', isset($ubicacion->dependencia)?$ubicacion->dependencia:old('dependencia')) }}">
    </div>

    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', isset($ubicacion->direccion)?$ubicacion->direccion:old('direccion')) }}">
    </div>

    <div class="form-group">
        <label for="planta">Planta:</label>
        <input type="text" class="form-control" name="planta" id="planta" value="{{ old('planta', isset($ubicacion->planta)?$ubicacion->planta:old('planta')) }}">
    </div>


</fieldset>

<br>
{{-- Definimos los botones Aceptar y Cancelar --}}
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/ubicacion') }}" class="btn btn-primary">Cancelar</a>