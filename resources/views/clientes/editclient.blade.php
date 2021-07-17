@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div style="text-align:center">
                <h2>EDITAR CLIENTE</h2>
            </div>
            <div style="text-align: right;">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('client.customer') }}"><i class="fas fa-caret-square-left"></i></a>
            </span>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('client.update',$client->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cedula:</strong>
                    <input type="integer" name="cedula" value="{{ $client->cedula }}" class="form-control" placeholder="Cedula">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombres:</strong>
                    <input type="text" name="nombres" value="{{ $client->nombres }}" class="form-control" placeholder="Nombres">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Apellidos:</strong>
                    <input type="text" name="apellidos" value="{{ $client->apellidos }}" class="form-control" placeholder="Apellidos">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefono:</strong>
                    <input type="integer" name="telefono" value="{{ $client->telefono }}" class="form-control" placeholder="Telefono">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Direccion:</strong>
                    <input type="text" name="direccion" value="{{ $client->direccion }}" class="form-control" placeholder="Direccion">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear">
              <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
            </div>
            </span>
        </div>
       
   
    </form>
@endsection

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
