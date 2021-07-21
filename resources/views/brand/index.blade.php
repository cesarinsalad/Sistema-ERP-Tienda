@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <style>
        tr:hover {
            background-color: #FFF9C3;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>
    <br>
    <div class="card; card bg-light mb-3;">
        <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <h4> Lista de Productos</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Producto">
            <a class="btn btn-success" href="{{ route('articulo.create') }}" style="position:relative;"><i
                    class="fas fa-plus"><text> Agregar Producto</text></i></a>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered ">
            <tr>
                <th width="5px">No</th>
                <th width="5px">Codigo</th>
                <th width="40px">Nombre</th>
                <th width="50px">Descripcion</th>
                <th width="15px">Cantidad</th>
                <th width="10px">Precio</th>
                <th width="5px">Referencia $</th>
                <th width="45px">Acciones</th>
            </tr>
            @foreach ($articulos as $articulo)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $articulo->codigo }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->descripcion }}</td>
                    <td>{{ $articulo->cantidad }}</td>
                    <td>{{ number_format((floatval($articulo->precio) * floatval($tasaDolar)), 2, ',', '.') }}Bs</td>
                    <td>{{ $articulo->precio }}$</td>
                    <td>
                        <form action="{{ route('articulo.destroy',$articulo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Ver">
                        <a class="btn btn-info" href="{{ route('articulo.show', $articulo->id) }}"><i
                                class="fas fa-eye"></i></a>
                    </span>
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                        <a class="btn btn-primary" href="{{ route('articulo.edit', $articulo->id) }}"><i
                                class="fas fa-pencil-alt"></i></a>
                    </span>
                            <span class="d-inline-block mt-2" tabindex="0" data-toggle="tooltip" title="Eliminar">
                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </span>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $articulos->links() !!}
    </div>
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

