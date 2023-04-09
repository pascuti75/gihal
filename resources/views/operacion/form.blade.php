<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE OPERACIÓN
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

    {{-- Cargamos todos los campos del formulario y su contenido --}}
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="tipo_operacion">Tipo de operación:</label>
                <input type="text" class="form-control" name="tipo_operacion" id="tipo_operacion" value="{{ $tipo==='instalacion' ? 'instalacion' : $operacion->tipo_operacion }}" readonly>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                @if($tipo!=='instalacion')
                <label for="fecha_operacion">Fecha de operación:</label>
                <input type="text" class="form-control" name="fecha_operacion" id="fecha_operacion" value="{{ $operacion->fecha_operacion }}" readonly>
                @endif
            </div>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="id_equipo">Equipo:</label>
            <select class="form-select" name="id_equipo" id="id_equipo" disabled>
                <option value="option_select" disabled selected>Seleccionar</option>
                @foreach ($equipos as $equipo)
                <option value="{{$equipo->id}}" {{old('id') == $equipo->id ? 'selected' : ($operacion->id_equipo == $equipo->id ? 'selected' : '')}}>{{$equipo->cod_interno . 
                    ' - ' . $equipo->marca . ' '. $equipo->modelo.' ('.$equipo->tipoEquipo->tipo.')'}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="id_persona">Persona:</label>
            <select class="form-select" name="id_persona" id="id_persona">
                <option value="">Seleccionar</option>
                @foreach ($personas as $persona)
                <option value="{{$persona->id}}" {{isset($operacion->id_persona ) ? (old('id_persona',$operacion->id_persona) == $persona->id ? 'selected' : '') : (old('id_persona') == $persona->id ? 'selected' : '')}}>
                    {{$persona->apellidos .', '. $persona->nombre}}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="id_ubicacion">Ubicación:</label>
            <select class="form-select" name="id_ubicacion" id="id_ubicacion">
                <option value="option_select" disabled selected>Seleccionar</option>
                @foreach ($ubicaciones as $ubicacion)
                <option value="{{$ubicacion->id}}" {{isset($operacion->id_ubicacion ) ? (old('id_ubicacion',$operacion->id_ubicacion) == $ubicacion->id ? 'selected' : '') : (old('id_ubicacion') == $ubicacion->id ? 'selected' : '')}}>{{$ubicacion->servicio .' - '. 
                    $ubicacion->dependencia .' - '. $ubicacion->direccion .' - ' . ' Planta ' . $ubicacion->planta }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="id_user">Técnico:</label>
            <select class="form-select" name="id_user" id="id_user" disabled>
                <option value="option_select" disabled selected>Seleccionar</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" {{old('id') == $user->id ? 'selected' : (auth()->user()->id == $user->id ? 'selected' : '')}}>{{$user->username}}</option>
                @endforeach
            </select>
        </div>
    </div>

</fieldset>

<br>
{{-- Definimos los botones Aceptar y Cancelar --}}
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/operacion') }}" class="btn btn-primary">Cancelar</a>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initOperacionForm();
    });
</script>