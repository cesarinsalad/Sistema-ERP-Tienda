@extends('adminlte::page')

@section('title', 'Marcas')

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
            <h4> Lista de Marcas</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nueva Marca">
            <a class="btn btn-success" href="{{ route('brands.create') }}" style="position:relative;"><i
                    class="fas fa-plus"><text> Agregar Marca</text></i></a>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered ">
            <tr>
                <th >ID</th>
                <th >Nombre</th>
                <th >Cantidad de productos</th>
                <th >Acciones</th>
            </tr>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->products_count }}</td>
                    <td>
                        <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Ver">
                            <a class="btn btn-info" href="{{ route('brands.show', $brand->id) }}"><i
                                    class="fas fa-eye"></i></a>
                        </span>
                        <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                            <a class="btn btn-primary" href="{{ route('brands.edit', $brand->id) }}"><i
                                    class="fas fa-pencil-alt"></i></a>
                        </span>
                        @if($brand->deleted_at == null)
                            <form action="{{ route('brands.destroy',$brand->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <span class="d-inline-block mt-2" tabindex="0" data-toggle="tooltip" title="Desactivar">
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </span>
                            </form>
                        @else
                            <form action="{{ route('brands.restore',$brand->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <span class="d-inline-block mt-2" tabindex="0" data-toggle="tooltip" title="Reactivar">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-undo"></i></button>
                            </span>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $brands->links() !!}
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

