@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Agregar Nuevo Producto</h2>
        </div>
        <div style="text-align: right;">
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
            <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-caret-square-left"></i></a>
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
   
<form action="{{ route('articulo.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Codigo:</strong>
                <input type="text" name="codigo" class="form-control" placeholder="Codigo">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Descripcion:</strong>
                <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripcion"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Cantidad:</strong>
                <input type="text" name="cantidad" class="form-control" placeholder="Cantidad">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Precio:</strong>
                <input type="text" name="precio" class="form-control" placeholder="Precio">
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