@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="text-center">CONSULTAS</h1>


    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
        <i class="fa fa-chevron-down"></i> Mostrar/Ocultar Filtros
    </button>
    <div class="collapse" id="collapseFilters">
        <div class="card card-body">
            <form method="GET">
                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <input type="text" id="cod_interno" name="cod_interno" placeholder="Cod. Interno" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tecnico" id="tecnico">
                            <option value="">-- Técnico --</option>
                            @foreach ($tecnicos as $tecnico)
                            <option value="{{$tecnico->id}}">{{$tecnico->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="persona" id="persona">
                            <option value="">-- Persona --</option>
                            @foreach ($personas as $persona)
                            <option value="{{$persona->id}}">{{$persona->apellidos.", ".$persona->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <input type="text" id="f_oper_ini" name="f_oper_ini" placeholder="Fecha Ini. Operación" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipo_operacion" id="tipo_operacion">
                            <option value="">-- Tipo de Operación --</option>
                            <option value="instalacion">instalación</option>
                            <option value="reparacion">reparación</option>
                            <option value="almacenaje">almacenaje</option>
                            <option value="baja">baja</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="ubicacion" id="ubicacion">
                            <option value="">-- Ubicación --</option>
                            @foreach ($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id}}">{{$ubicacion->servicio." - ".$ubicacion->dependencia}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <input type="text" id="f_oper_fin" name="f_oper_fin" placeholder="Fecha Fin Operación" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipo_equipo" id="tipo_equipo">
                            <option value="">-- Tipo de Equipo --</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="contratacion" id="contratacion">
                            <option value="">-- Contratación --</option>
                            @foreach ($contrataciones as $contratacion)
                            <option value="{{$contratacion->id}}">{{$contratacion->empresa . ": Desde ". $contratacion->fecha_inicio . " hasta " . $contratacion->fecha_fin}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-2">

                    <div class="col-md-2">
                        <input type="text" id="marca" name="marca" placeholder="Marca" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="modelo" name="modelo" placeholder="Modelo" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="product_number" name="product_number" placeholder="Product Number" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="num_serie" name="num_serie" placeholder="Número de Serie" class="form-control">
                    </div>
                </div>

                <div class="form-group row mb-2">


                    <div class="col-md-11">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activa" id="activa">
                            <label class="form-check-label" for="activa">
                                Mostrar sólo operación activa
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-success" value="Filtrar">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>

    <div class="card card-body">
        <table class="table table-light" style="font-size:13px;">

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
            <tbody>
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

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $operaciones->links() !!}
        {{ 'Total registros: '. $operaciones->total() }}
    </div>

</div>


@endsection