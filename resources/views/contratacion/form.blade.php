<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE CONTRATACIÓN
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
        <label for="titulo">Título:</label>
        <input type="text" class="form-control" name="titulo" id="titulo" value="{{ isset($contratacion->titulo)?$contratacion->titulo:old('titulo') }}">
    </div>

    <div class="form-group">
        <label for="empresa">Empresa:</label>
        <input type="text" class="form-control" name="empresa" id="empresa" value="{{ isset($contratacion->empresa)?$contratacion->empresa:old('empresa') }}">
    </div>

    <div class="form-group">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" value="{{ isset($contratacion->fecha_inicio)?$contratacion->fecha_inicio:old('fecha_inicio') }}">
    </div>

    <div class="form-group">
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" value="{{ isset($contratacion->fecha_fin)?$contratacion->fecha_fin:old('fecha_fin') }}">
    </div>


</fieldset>


<br>
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/contratacion') }}" class="btn btn-primary">Cancelar</a>