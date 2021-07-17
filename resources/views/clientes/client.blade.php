@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content_header')
     <div style="text-align:center">
     <h1>PANEL DE CLIENTES</h1>
     </div>
           
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Clientes</h2>
            </div>
            <div style="text-align: right;">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Añadir Nuevo Cliente">
            <a class="btn btn-success" href="{{ route('client.create') }}"style="position:relative"><i class="fas fa-plus-square"></i></a>
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
            <th width="2px">No</th>
            <th width="5px">Cedula</th>
            <th width="80px">Nombres</th>
            <th width="80px">Apellidos</th>
            <th width="5px">Telefono</th>
            <th width="110px">Direccion</th>
            <th width="50px">Acciones</th>
        </tr>
        @foreach ($clients as $client)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $client->cedula }}</td>
            <td>{{ $client->nombres }}</td>
            <td>{{ $client->apellidos}}</td>
            <td>{{ $client->telefono }}</td>
            <td>{{ $client->direccion}}</td>
            <td>
                <form action="{{ route('client.destroy',$client->id) }}" method="POST">
   
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Ver">
                    <a class="btn btn-info" href="{{ route('client.show',$client->id) }}"><i class="fas fa-eye"></i></a>
                </span>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Editar">
                    <a class="btn btn-primary" href="{{ route('client.edit',$client->id) }}"><i class="fas fa-pencil-alt"></i></a>
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

    {!! $clients->links() !!}
      
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
