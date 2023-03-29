@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="text-center">CONSULTAS</h1>

    <div class="container">
        <form method="GET">
            <div class="form-group row mb-2">

                <div class="col-md-2">
                    <input type="text" id="cod_interno" name="cod_interno" placeholder="Cod. Interno" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" id="tecnico" name="tecnico" placeholder="Técnico" class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" id="persona" name="persona" placeholder="Persona" class="form-control">
                </div>
            </div>
            <div class="form-group row mb-2">

                <div class="col-md-2">
                    <input type="text" id="f_oper_ini" name="f_oper_ini" placeholder="Fecha Ini. Operación" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" id="tipo_operacion" name="tipo_operacion" placeholder="Tipo de Operación" class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" id="ubicación" name="ubicación" placeholder="Ubicación" class="form-control">
                </div>
            </div>

            <div class="form-group row mb-2">

                <div class="col-md-2">
                    <input type="text" id="f_oper_fin" name="f_oper_fin" placeholder="Fecha Fin Operación" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" id="tipo_equipo" name="tipo_equipo" placeholder="Tipo de Equipo" class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" id="contratacion" name="contratacion" placeholder="Contratación" class="form-control">
                </div>
            </div>

            <div class="form-group row mb-2">

                <div class="col-md-2">
                    <input type="text" id="marca" name="marca" placeholder="Marca" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" id="modelo" name="modelo" placeholder="Modelo" class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" id="product_number" name="product_number" placeholder="Product Number" class="form-control">
                </div>
            </div>

            <div class="form-group row mb-2">

                <div class="col-md-2">
                    <input type="text" id="num_serie" name="num_serie" placeholder="Número de Serie" class="form-control">
                </div>
                <div class="col-md-9">
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



    <table class="table table-light" style="font-size:13px">

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


@endsection