@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <style>
        tr:hover {
            background-color: #FFC3D0;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
    </div>
    <br>
    <div class="card; card bg-light mb-3;">
        <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <h4> Lista de Ordenes</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Producto">
             <a class="btn btn-success" href="{{ route('home') }}" style="position:relative;"><i class="fas fa-plus"><text> Generar orden</text></i></a>
            </span>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                <table  class="table table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th width="30px">No</th>
                            <th width="45px">Cliente</th>
                            <th width="70px">Fecha</th>
                            <th width="35px">Monto</th>
                            <th width="35px">Referencia</th>
                            <th width="35px">Tasa de Cambio</th>
                            <th width="15px">Acciones</th>
                        </tr>
                    </thead>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->client->nombres }} {{ $order->client->apellidos }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ number_format($order->monto_orden * $order->tasa->value, 2, ',', '.') }}Bs</td>
                            <td>{{ number_format($order->monto_orden, 2, ',', '.') }}$</td>
                            <td>{{ number_format($order->tasa->value, 2, ',', '.') }}Bs</td>
                            <td>

                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Ver">
                    <a class="btn btn-info" href="{{ route('listorden.show',$order->id) }}"><i
                            class="fas fa-eye"></i></a>
                </span>
                                @csrf
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="pagination-container">
                    {!! $orders->links() !!}
                </div>
            </div>
        </div>

        @stop

        @section('css')
            <link rel="stylesheet" href="/css/admin_custom.css">
        @stop

        @section('js')
            <script>


                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>
@stop

