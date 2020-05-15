@extends ('layouts.layout')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado De Salida De Vehiculos <a href="salida_vehiculo/create">
                <button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Nuevo</button></a></h3>
            @include('Salida_Vehiculo.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Numero Ticket</th>
                        <th>Datos Del Ingreso</th>
                        <th>Datos Del Vehiculo</th> 
                        <th>Fecha Salida</th>
                        <th>Valor- Hora</th>
                        <th>Total</th>
                        <th>Opciones</th>
                    </thead>
                    @if($salidas->count())
                    @foreach ($salidas as $s)
                    <tr>
                        <td>{{$s->id_ticket}}</td>
                        <td>ID: {{$s->id_ingreso}} - Estado: {{$s->estado}}</td>
                        <td>Tipo: {{ $s->nombre}} - Placa: {{ $s->placa}}</td>
                        <td>{{ $s->fecha_salida}}</td>
                        <td>{{ $s->valor_hora}}</td>
                        <td>{{ $s->total}}</td>
                        <td>
                        <a href="" data-target="#modal-delete-{{$s->id_ticket}}" data-toggle="modal"><button class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button></a>
                        </td>
                    </tr>
                    @include('Salida_Vehiculo.modal')
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">No Hay Registro De Salida De Vehiculos !!</td>
                    </tr>
                    @endif
                </table>
            </div>
            {{$salidas->render()}}
        </div>
    </div>
@endsection