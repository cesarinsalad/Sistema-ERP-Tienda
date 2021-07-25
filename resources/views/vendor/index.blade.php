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
            <h4> Lista de Proveedores</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Producto">
            <a class="btn btn-success" href="{{ route('vendors.create') }}" style="position:relative;"><i
                    class="fas fa-plus"><text> Agregar Proveedor</text></i></a>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            <table class="table table-bordered table-sm " id="table_nice">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Cantidad de productos</th>
                    <th scope="col">Status</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                @foreach ($vendors as $vendor)
                    <tbody>
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->type_document }}.: {{ $vendor->document }}</td>
                        <td>{{ $vendor->description }}</td>
                        <td>{{ $vendor->products_count }}</td>
                        <td>
                            @if($vendor->deleted_at == null)
                                <form action="{{ route('vendors.destroy',$vendor->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Desactivar">
                                <button type="submit"  class="btn btn-success"><i class="fa fa-lightbulb"></i></button>
                            </span>
                                </form>
                            @else
                                <form action="{{ route('vendors.restore',$vendor->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Reactivar">
                                <button type="submit"  class="btn btn-danger"><i class="fas fa-lightbulb"></i></button>
                            </span>
                                </form>
                            @endif
                        </td>
                        <td>
                        <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Ver">
                            <a class="btn btn-info" href="{{ route('vendors.show', $vendor->id) }}"><i
                                    class="fas fa-eye"></i></a>
                        </span>
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                            <a class="btn btn-primary" href="{{ route('vendors.edit', $vendor->id) }}"><i
                                    class="fas fa-pencil-alt"></i></a>
                        </span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
        <div class="pagination-container">
            {!! $vendors->links() !!}
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

