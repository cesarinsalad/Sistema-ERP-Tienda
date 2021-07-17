@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

@section('content')
<style>
    #basic-detail {
        margin-bottom: 30px;
    }
    #basic-detail > div,  #order-detail > div{
        padding: 20px;
    }
</style>
    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>
    <br><br>
    <div class="card bg-light mb-3">
        <div class="py-3 px-3 border-bottom d-flex justify-content-between" >
            <h4>Orden</h4>
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('listorden.index') }}"><i class="fas fa-arrow-left "></i><text> Regresar</text></a>
            </span>
        </div>
        <div class="card-body">
            <div class="row" id="basic-detail">
                <div class="col-md-6">
                    <h5>Detalle de Orden</h5>
                    <p><strong>Número de Orden:</strong> #{{ $order->id }}</p>
                    <p><strong>Fecha de Realización:</strong> {{ $order->created_at }}</p>
                    <p><strong>Tasa:</strong> {{ $order->tasa_cambio }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Detalle de Cliente</h5>
                    <p><strong>Nombre:</strong> <a href="{{ route('client.show', $order->client->id) }}">{{ $order->client->nombres }} {{$order->client->apellidos}}</a></p>
                    <p><strong>Cedula:</strong> {{ $order->client->cedula }}</p>
                    <p><strong>Teléfono:</strong> {{ $order->client->telefono }}</p>
                </div>
            </div>
            <div class="row" id="order-detail">
                <div class="col-md-6">
                    <h5>Listado de Productos</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="45px">Producto</th>
                            <th width="35px">Cantidad</th>
                            <th width="35px">Monto</th>
                        </tr>
                        @foreach ($order->products as $product)
                        <tr>
                            <td><a href="{{ route('articulo.show',$product->id) }}">{{ $product->nombre }}</a></td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>{{ $product->pivot->precio * $order->tasa_cambio }} Bs</td>
                        </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <td colspan="2"><b>Total:</b></td>
                            <td>{{ $order->monto_orden * $order->tasa_cambio }} Bs</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Referencia:</b></td>
                            <td>{{ $order->monto_orden }} $</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Pago(s) Realizados</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="45px">Método de Pago</th>
                            <th width="35px">Moneda</th>
                            <th width="35px">Monto</th>
                        </tr>
                        @foreach ($order->paymentMethods as $pMethod)
                        <tr>
                            <td>{{ $pMethod->nombre_metodo }}</td>
                            <td>{{ $pMethod->moneda }}</td>
                            <td>
                            @if($pMethod->moneda == '$')
                            {{ $pMethod->pivot->monto_pago_orden * $order->tasa_cambio }}
                            @else
                            {{ $pMethod->pivot->monto_pago_orden}}
                            @endif
                             Bs
                            </td>
                           
                        </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <td colspan="2"><b>Total:</b></td>
                            <td>{{ $order->monto_orden * $order->tasa_cambio }} Bs</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
</script>
@stop
