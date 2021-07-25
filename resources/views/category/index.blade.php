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
            <h4> Lista de Categorías</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Producto">
            <a class="btn btn-success" href="{{ route('categories.create') }}" style="position:relative;"><i
                    class="fas fa-plus"><text> Agregar categoría</text></i></a>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            <table class="table table-sm " id="table_nice">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad de productos</th>
                    <th scope="col">Status</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                @foreach ($categories as $category)
                    <tbody>
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            @if($category->deleted_at == null)
                                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Desactivar">
                                        <button type="submit"  class="btn btn-success"><i class="fa fa-lightbulb"></i></button>
                                    </span>
                                </form>
                            @else
                                <form action="{{ route('categories.restore',$category->id) }}" method="POST">
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
                            <a class="btn btn-info" href="{{ route('categories.show', $category->id) }}"><i
                                    class="fas fa-eye"></i></a>
                        </span>
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                            <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}"><i
                                    class="fas fa-pencil-alt"></i></a>
                        </span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
        <div class="pagination-container">
            {!! $categories->links() !!}
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

