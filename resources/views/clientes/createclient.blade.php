@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Añadir Nuevo Cliente</h2>
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
   
<form action="{{ route('client.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Cedula:</strong>
                <input type="integer" name="cedula" class="form-control" placeholder="Cedula">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombres:</strong>
                <input type="string" class="form-control" name="nombres" placeholder="Nombres">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellidos:</strong>
                <input type="string" class="form-control" name="apellidos" placeholder="Apellidos">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Telefono:</strong>
                <input type="integer" name="telefono" class="form-control" placeholder="telefono">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Direccion:</strong>
                <input type="text" class="form-control" name="direccion" placeholder="direccion">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button>
                </span>
               
        </div>
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