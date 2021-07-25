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
            <div class="card; card mb-3;">
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

        <div class="card-body">
            <table class="table table-bordered table-sm ">
                <thead class="thead-dark">
                <tr>
                    <th width="2px">No</th>
                    <th width="5px">Cédula</th>
                    <th width="80px">Nombres</th>
                    <th width="80px">Apellidos</th>
                    <th width="5px">Teléfono</th>
                    <th width="5px">Status</th>
                    <th width="50px">Acciones</th>
                </tr>
                </thead>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $client->cedula }}</td>
                        <td>{{ $client->nombres }}</td>
                        <td>{{ $client->apellidos}}</td>
                        <td>{{ $client->telefono }}</td>
                        <td>
                            @if($client->deleted_at == null)
                                <form action="{{ route('client.destroy',$client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Desactivar">
                                <button type="submit"  class="btn btn-success"><i class="fa fa-lightbulb"></i></button>
                            </span>
                                </form>
                            @else
                                <form action="{{ route('client.restore',$client->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Reactivar">
                                <button type="submit"  class="btn btn-danger"><i class="fas fa-lightbulb"></i></button>
                            </span>
                                </form>
                            @endif
                        </td>
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
        </div>
        <div class="pagination-container">
            {!! $clients->links() !!}
        </div>
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
