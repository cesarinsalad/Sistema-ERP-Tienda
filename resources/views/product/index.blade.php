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
    <div class="card; card mb-3;">
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

        <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th width="5px">No</th>
                    <th width="5px">Codigo</th>
                    <th width="40px">Nombre</th>
                    <th width="15px">Cantidad</th>
                    <th width="10px">Precio</th>
                    <th width="5px">Referencia $</th>
                    <th width="10px">Marca</th>
                    <th width="10px">Status</th>
                    <th width="45px">Acciones</th>
                </tr>
            </thead>
            @foreach ($articulos as $articulo)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $articulo->codigo }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->cantidad }}</td>
                    <td>{{ number_format((floatval($articulo->precio) * floatval($tasaDolar)), 2, ',', '.') }}Bs</td>
                    <td>{{ $articulo->precio }}$</td>
                    <td>{{ $articulo->brand->name }}</td>
                    <td>
                        @if($articulo->deleted_at == null)
                            <form action="{{ route('articulo.destroy',$articulo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Desactivar">
                                        <button type="submit"  class="btn btn-success"><i class="fa fa-lightbulb"></i></button>
                                    </span>
                            </form>
                        @else
                            <form action="{{ route('products.restore',$articulo->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Reactivar">
                                <button type="submit"  class="btn btn-danger"><i class="fas fa-lightbulb"></i></button>
                            </span>
                            </form>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Ver">
                                <a class="btn btn-info" href="{{ route('articulo.show', $articulo->id) }}"><i
                                class="fas fa-eye"></i></a>
                            </span>
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                                <a class="btn btn-primary" href="{{ route('articulo.edit', $articulo->id) }}"><i
                                class="fas fa-pencil-alt"></i></a>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination-container">
            {!! $articulos->links() !!}
        </div>
        </div>
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

