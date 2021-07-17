@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content_header')

<div style="text-align:center;">
    <h1>LISTADO DE ORDENES </h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Ordenes</h2>
            </div>
            <div style="text-align:right;">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"  title="Regresar">
            <a class="btn btn-success" href="{{ route('listorden.index') }}"style="position:relative;"><i class="fas fa-plus-square"></i></a>
            </span>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
     <table class="table table-bordered">
        <tr>
            <th width="30px">No</th>
            <th width="45px">Cliente</th>
            <th width="35px">Fecha</th>
            <th width="35px">Tasa de Cambio</th>
            <th width="45px">Acciones</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->client->nombres }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->tasa_cambio }}</td>
            <td>
   
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Ver">
                    <a class="btn btn-info" href="{{ route('listorden.show',$order->id) }}"><i class="fas fa-eye"></i></a>
                </span>
                    @csrf
            </td>
        </tr>
        @endforeach
    </table>

    {!! $orders->links() !!} 
      
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

