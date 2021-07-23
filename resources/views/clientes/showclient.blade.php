@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
       
        </div>
        </div>
    <br><br>
    <div class="card; card bg-light mb-3">
     
    <div class="py-3 px-3 border-bottom d-flex justify-content-between" ><h4> Detalles del cliente</h4>
    
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('client.customer') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
            </span>
            
</div>
<div class="card-body">
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5> <div class="form-group">
                <strong>Cedula:</strong>
                {{ $client->cedula }}
            </div> </h5>
        </div>
        
        
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5> <div class="form-group">
                <strong> Nombres:</strong>
                {{ $client->nombres }}
            </div> </h5>
        </div>
        
        
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5> <div class="form-group">
                <strong>Apellidos:</strong>
                {{ $client->apellidos }}
            </div> </h5>
        </div>
        
        
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5> <div class="form-group">
                <strong>Telefono:</strong>
                {{ $client->telefono }}
            </div> </h5>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5> <div class="form-group">
                <strong>Direccion:</strong>
                {{ $client->direccion }}
            </div> </h5>
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
