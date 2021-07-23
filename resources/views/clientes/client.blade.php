@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')
    <style>

tr:hover {background-color:#C3E7FF;}
    </style>


    <div class="row">
            <div class="col-lg-12 margin-tb">

            </div>
        </div>
            <br>
            <div class="card; card bg-light mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between" >
                <h4> Lista de Clientes</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Añadir Nuevo Cliente">
            <a class="btn btn-success" href="{{ route('client.create') }}"style="position:relative"><i class="fas fa-plus"><text> Crear Cliente</text></i></a>
            </span>

            </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered ">
        <tr>
            <th width="2px">No</th>
            <th width="5px">Cédula</th>
            <th width="80px">Nombres</th>
            <th width="80px">Apellidos</th>
            <th width="5px">Teléfono</th>
            <th width="110px">Dirección</th>
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
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
    //--validacion
    <script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>

 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@stop
