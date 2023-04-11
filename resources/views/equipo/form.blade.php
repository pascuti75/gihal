<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE EQUIPO
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
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="id_tipo_equipo">Tipo de equipo:</label>
                    <select class="form-select" name="id_tipo_equipo" id="id_tipo_equipo">
                        <option value="option_select" disabled>Seleccionar</option>
                        @foreach ($tipos as $tipo)
                        <option value="{{$tipo->id}}" {{isset($equipo->id_tipo_equipo) ? (old('id_tipo_equipo',$equipo->id_tipo_equipo) == $tipo->id ? 'selected' : '') : (old('id_tipo_equipo') == $tipo->id ? 'selected' : '')}}>{{$tipo->tipo}}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="id_contratacion">Tipo de Contratación:</label>
                    <select class="form-select" name="id_contratacion" id="id_contratacion">
                        <option value="">Seleccionar</option>
                        @foreach ($contrataciones as $contratacion)
                        <option value="{{$contratacion->id}}" {{isset($equipo->id_contratacion) ? (old('id_contratacion',$equipo->id_contratacion) == $contratacion->id ? 'selected' : '') : (old('id_contratacion') == $contratacion->id ? 'selected' : '')}}>{{Str::limit($contratacion->titulo, 100)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <input type="text" class="form-control" name="marca" id="marca" value="{{ old('marca', isset($equipo->marca)?$equipo->marca:old('marca')) }}">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="modelo">Modelo:</label>
                    <input type="text" class="form-control" name="modelo" id="modelo" value="{{ old('modelo', isset($equipo->modelo)?$equipo->modelo:old('modelo')) }}">

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="product_number">Product Number:</label>
                    <input type="text" class="form-control" name="product_number" id="product_number" value="{{ old('product_number', isset($equipo->product_number)?$equipo->product_number:old('product_number')) }}">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="num_serie">Número de serie:</label>
                    <input type="text" class="form-control" name="num_serie" id="num_serie" value="{{ old('num_serie', isset($equipo->num_serie)?$equipo->num_serie:old('num_serie')) }}">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="cod_interno">Código interno:</label>
                    <input type="text" class="form-control" name="cod_interno" id="cod_interno" value="{{ old('cod_interno', isset($equipo->cod_interno)?$equipo->cod_interno:old('cod_interno')) }}">

                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="cod_externo">Código externo:</label>
                    <input type="text" class="form-control" name="cod_externo" id="cod_externo" value="{{ old('cod_externo', isset($equipo->cod_externo)?$equipo->cod_externo:old('cod_externo')) }}">
                </div>
            </div>
        </div>


    </div>

</fieldset>
<br>
{{-- Definimos los botones Aceptar y Cancelar --}}
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/equipo') }}" class="btn btn-primary">Cancelar</a>