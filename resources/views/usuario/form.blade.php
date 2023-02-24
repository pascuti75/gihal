<fieldset class="border border-dark border-1 p-4 mt-4">
    <legend class="float-none w-auto px-3 legend-form">
        FICHA DE USUARIO
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
        <label for="username">Nombre de usuario:</label>
        <input type="text" class="form-control" name="username" id="username" value="{{ isset($user->username)?$user->username:old('username') }}" @if($modo=="editar" ) readonly @endif>
    </div>

    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" name="password" id="password" value="{{ '' }}">
    </div>

    <br>
    <h2>ROLES</h2>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="es_administrador" id="es_administrador" {{ (old('es_administrador')!=null || (isset($user->es_administrador) && $user->es_administrador==1))?'checked':'' }}>
        <label class="form-check-label" for="es_administrador">
            Administrador
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="es_gestor" id="es_gestor" {{ (old('es_gestor')!=null || (isset($user->es_gestor) && $user->es_gestor==1))?'checked':'' }}>
        <label class="form-check-label" for="es_gestor">
            Gestor
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="es_tecnico" id="es_tecnico" {{ (old('es_tecnico')!=null || (isset($user->es_tecnico) && $user->es_tecnico==1))?'checked':'' }}>
        <label class="form-check-label" for="es_tecnico">
            Técnico
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="es_consultor" id="es_consultor" {{ (old('es_consultor')!=null || (isset($user->es_consultor) && $user->es_consultor==1))?'checked':'' }}>
        <label class="form-check-label" for="es_consultor">
            Consultor
        </label>
    </div>

</fieldset>


<br>
<input type="submit" class="btn btn-success" value="Aceptar">
<a href="{{ url('/usuario') }}" class="btn btn-primary">Cancelar</a>