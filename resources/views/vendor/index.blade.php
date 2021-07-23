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
            <h4> Lista de Proveedores</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Proveedor">
            <a class="btn btn-success" href="{{ route('vendors.create') }}" style="position:relative;"><i
                    class="fas fa-plus"><text> Agregar Proveedor</text></i></a>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered ">
            <tr>
                <th width="40px">Nombre</th>
                <th width="40px">Tipo de Documento</th>
                <th width="40px">Documento</th>
                <th width="50px">Descripción</th>
                <th width="45px">Acciones</th>
            </tr>
            @foreach ($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->type_document }}</td>
                    <td>{{ $vendor->document }}</td>
                    <td>{{ $vendor->description }}</td>

                    <td>
                        <form action="{{ route('vendors.destroy',$vendor->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Ver">
                        <a class="btn btn-info" href="{{ route('vendors.show', $vendor->id) }}"><i
                                class="fas fa-eye"></i></a>
                    </span>
                            <span class="d-inline-block mr-2" tabindex="0" data-toggle="tooltip" title="Editar">
                        <a class="btn btn-primary" href="{{ route('vendors.edit', $vendor->id) }}"><i
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

        {!! $vendors->links() !!}
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

