{{-- Plantilla blade para mostrar la vista de listado de operaciones en la consulta --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')
<div class="container-fluid">

    <h1 class="text-center">CONSULTAS</h1>

    {{-- seccion para mensajes de error --}}
    @if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error)

            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- boton para mostrar/ocultar los filtros --}}
    <button class="btn btn-outline-danger mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
        Mostrar/Ocultar Filtros
    </button>
    <div class="collapse show" id="collapseFilters">
        <div class="card card-body">

            {{-- formularios de filtros --}}
            <form method="GET">
                {{ csrf_field() }}
                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" id="cod_interno" name="cod_interno" placeholder="Cod. Interno" class="form-control" value="{{Request::capture()->get('cod_interno')!=null ? Request::capture()->get('cod_interno') : ''}}">
                            <button class="btn btn-outline-secondary" type="button" id="reset_cod_interno"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div id="cod_interno_list"></div>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select" name="tecnico" id="tecnico">
                            <option value="">-- Técnico --</option>
                            @foreach ($tecnicos as $tecnico)
                            <option value="{{$tecnico->id}}" {{old('tecnico') == $tecnico->id ? 'selected' : (Request::capture()->get('tecnico') == $tecnico->id ? 'selected' : '')}}>
                                {{$tecnico->username}}
                            </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="persona" id="persona">
                            <option value="">-- Persona --</option>
                            @foreach ($personas as $persona)
                            <option value="{{$persona->id}}" {{old('persona') == $persona->id ? 'selected' : (Request::capture()->get('persona') == $persona->id ? 'selected' : '')}}>
                                {{$persona->apellidos.", ".$persona->nombre}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" id="f_oper_ini" name="f_oper_ini" placeholder="Desde fecha operación..." class="form-control campo_fecha" value="{{Request::capture()->get('f_oper_ini')!=null ? Request::capture()->get('f_oper_ini') : ''}}">
                            <button class="btn btn-outline-secondary" type="button" id="reset_f_oper_ini"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipo_operacion" id="tipo_operacion">
                            <option value="">-- Tipo de Operación --</option>
                            <option value="instalacion" {{old('tipo_operacion') == 'instalacion' ? 'selected' : (Request::capture()->get('tipo_operacion') == 'instalacion' ? 'selected' : '')}}>instalación</option>
                            <option value="reparacion" {{old('tipo_operacion') == 'reparacion' ? 'selected' : (Request::capture()->get('tipo_operacion') == 'reparacion' ? 'selected' : '')}}>reparación</option>
                            <option value="almacenaje" {{old('tipo_operacion') == 'almacenaje' ? 'selected' : (Request::capture()->get('tipo_operacion') == 'almacenaje' ? 'selected' : '')}}>almacenaje</option>
                            <option value="baja" {{old('tipo_operacion') == 'baja' ? 'selected' : (Request::capture()->get('tipo_operacion') == 'baja' ? 'selected' : '')}}>baja</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="ubicacion" id="ubicacion">
                            <option value="">-- Ubicación --</option>
                            @foreach ($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id}}" {{old('ubicacion') == $ubicacion->id ? 'selected' : (Request::capture()->get('ubicacion') == $ubicacion->id ? 'selected' : '')}}>{{$ubicacion->servicio." - ".$ubicacion->dependencia}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" id="f_oper_fin" name="f_oper_fin" placeholder="Hasta fecha operación..." class="form-control campo_fecha" value="{{Request::capture()->get('f_oper_fin')!=null ? Request::capture()->get('f_oper_fin') : ''}}">
                            <button class="btn btn-outline-secondary" type="button" id="reset_f_oper_fin"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipo_equipo" id="tipo_equipo">
                            <option value="">-- Tipo de Equipo --</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}" {{old('tipo_equipo') == $tipo->id ? 'selected' : (Request::capture()->get('tipo_equipo') == $tipo->id ? 'selected' : '')}}>{{$tipo->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="contratacion" id="contratacion">
                            <option value="">-- Contratación --</option>
                            @foreach ($contrataciones as $contratacion)
                            <option value="{{$contratacion->id}}" {{old('contratacion') == $contratacion->id ? 'selected' : (Request::capture()->get('contratacion') == $contratacion->id ? 'selected' : '')}}>{{$contratacion->empresa . ": Desde ". $contratacion->fecha_inicio . " hasta " . $contratacion->fecha_fin}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <select class="form-select" name="marca" id="marca">
                            <option value="">-- Marca --</option>
                            @foreach ($marcas as $marca)
                            <option value="{{$marca}}" {{old('marca') == $marca ? 'selected' : (Request::capture()->get('marca') == $marca ? 'selected' : '')}}>{{$marca}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="modelo" id="modelo">
                            <option value="">-- Modelo --</option>
                            @foreach ($modelos as $modelo)
                            <option value="{{$modelo}}" {{old('modelo') == $modelo ? 'selected' : (Request::capture()->get('modelo') == $modelo ? 'selected' : '')}}>{{$modelo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" id="product_number" name="product_number" placeholder="Product Number" class="form-control" value="{{Request::capture()->get('product_number')!=null ? Request::capture()->get('product_number') : ''}}">
                            <button class="btn btn-outline-secondary" type="button" id="reset_product_number"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div id="product_number_list"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" id="num_serie" name="num_serie" placeholder="Número de Serie" class="form-control" value="{{Request::capture()->get('num_serie')!=null ? Request::capture()->get('num_serie') : ''}}">
                            <button class="btn btn-outline-secondary" type="button" id="reset_num_serie"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div id="num_serie_list"></div>
                    </div>

                </div>

                <div class="form-group row mb-2">


                    <div class="col-md-11">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activa" id="activa" {{old('activa') == 'on' ? 'checked' : (Request::capture()->get('activa') == 'on' ? 'checked' : '')}}>
                            <label class="form-check-label" for="activa">
                                Mostrar sólo operaciones activas
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex justify-content-end">
                        <input type="submit" class="btn btn-success" value="Filtrar">
                        <a href="{{ route('consulta.index') }}" class="btn btn-primary ms-2">Reset</a>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>

    <div class="card card-body">

        {{-- tabla para mostrar los resultados --}}
        <table class="table table-light table-wide">
            {{-- encabezado --}}
            <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo Oper.</th>
                    <th>Tipo Equ.</th>
                    <th>Cod.Interno</th>
                    <th>Persona</th>
                    <th>Ubicación</th>
                    <th>Empresa</th>
                    <th>Técnico</th>
                    <th class="action-column text-nowrap text-center">Acciones</th>
                </tr>
            </thead>
            {{-- cuerpo de la tabla --}}
            <tbody>
                {{-- recorremos las operaciones obtenidos desde el controlador para montar el contenido la tabla --}}
                @foreach( $operaciones as $operacion)
                <tr>
                    <td>{{ $operacion->fecha_operacion }}</td>
                    <td>{{ $operacion->tipo_operacion }}</td>
                    <td>{{ $operacion->equipo->tipoEquipo->tipo }}</td>
                    <td>{{ $operacion->equipo->cod_interno }}</td>
                    <td>{{ isset($operacion->id_persona) ? $operacion->persona->nombre .' '. $operacion->persona->apellidos :'' }}</td>
                    <td>{{ isset($operacion->id_ubicacion) ? $operacion->ubicacion->servicio .' - '. $operacion->ubicacion->dependencia : '' }}</td>
                    <td>{{ isset($operacion->equipo->contratacion) ? $operacion->equipo->contratacion->empresa : '' }}</td>
                    <td>{{ isset($operacion->id_user) ? $operacion->user->username : '' }}</td>
                    <td class="action-column text-nowrap text-center">
                        <a href="{{url('/consulta/'.$operacion->id) }}" class="btn btn-sm btn-outline-secondary">ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="form-group row mb-2">

            {{-- totales y paginacion --}}
            <div class="col-md-11">
                {!! $operaciones->links() !!}
                {{ 'Total registros: '. $operaciones->total() }}
            </div>
            <div class="col-md-1 text-right">
                {{--botón para exportar a pdf pasandole a la ruta toda la cadena del filtros incluidas en el QUERY STRING --}}
                <a href="{{ route('consulta.pdf').'?'.$_SERVER['QUERY_STRING'] }}" class="btn btn-warning">Exportar a PDF</a>
            </div>

        </div>
    </div>
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {
        initConsultaIndex();
    });
</script>


@endsection