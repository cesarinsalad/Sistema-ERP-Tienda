@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content_header')

<div style="text-align:center;">
    <h1>PANEL DE PRODUCTOS</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Productos</h2>
            </div>
            <div style="text-align:right;">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"  title="Crear Nuevo Producto">
            <a class="btn btn-success" href="{{ route('articulo.create') }}"style="position:relative;"><i class="fas fa-plus-square"></i></a>
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
            <th width="45px">Codigo</th>
            <th width="150px">Nombre</th>
            <th width="150px">Descripcion</th>
            <th width="35px">Cantidad</th>
            <th width="35px">Precio</th>
            <th width="45px">Acciones</th>
        </tr>
        @foreach ($articulos as $articulo)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $articulo->codigo }}</td>
            <td>{{ $articulo->nombre }}</td>
            <td>{{ $articulo->descripcion }}</td>
            <td>{{ $articulo->cantidad }}</td>
            <td>{{ $articulo->precio }}</td>
            <td>
                <form action="{{ route('articulo.destroy',$articulo->id) }}" method="POST">
   
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Ver">
                    <a class="btn btn-info" href="{{ route('articulo.show',$articulo->id) }}"><i class="fas fa-eye"></i></a>
                </span>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Editar">
                    <a class="btn btn-primary" href="{{ route('articulo.edit',$articulo->id) }}"><i class="fas fa-pencil-alt"></i></a>
                </span>
                    @csrf
                    @method('DELETE')
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eliminar">
                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </span>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $articulos->links() !!}
      
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

