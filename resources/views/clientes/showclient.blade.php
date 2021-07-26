@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
        </div>
    <br><br>
    <div class="card; card mb-3">

    <div class="py-3 px-3 border-bottom d-flex justify-content-between" ><h4> Detalles del cliente</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('client.customer') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
            </span>

</div>
<div class="card-body">
     <div class="row">
        <div class="col-md-6">
            <h5>
                <div class="form-group">
                    <strong>Cédula:</strong>
                    {{ $client->cedula }}
                </div>
            </h5>
            <h5>
                <div class="form-group">
                    <strong> Nombre:</strong>
                    {{ $client->nombres }} {{ $client->apellidos }}.
                </div>
            </h5>
            <h5>
                <div class="form-group">
                    <strong>Status:</strong>
                    @if($client->deleted_at)Baneado desde el: {{$client->deleted_at}}@else Activo @endif
                </div>
            </h5>
            <h5>
                <div class="form-group">
                    <strong>Telefono:</strong>
                    {{ $client->telefono }}
                </div>
            </h5>
            <h5>
                <div class="form-group">
                    <strong>Direccion:</strong>
                    {{ $client->direccion }}
                </div>
            </h5>
        </div>
         <div class="col-md-6">
             <h5><strong>Productos Preferidos:</strong></h5>
             <table class="table table-bordered table-sm " id="table-sold-categories">
                 <thead class="thead-dark">
                 <tr>
                     <th width="80px">Producto</th>
                     <th width="80px">Cantidad</th>
                 </tr>
                 </thead>
                 @foreach ($preferedProducts as $product)
                     <tr>
                         <td><a href="{{ route('articulo.show', $product['id']) }}">{{ ucfirst($product['name']) }}</a></td>
                         <td>{{ $product['total'] }}</td>
                     </tr>
                 @endforeach
             </table>
         </div>
    </div>
</div>
</div>
    <div class="col-md-6">
            <canvas id="fidelidad" width="200" height="200"></canvas>
        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>

//--validacion
<script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>

    </script>
@stop
