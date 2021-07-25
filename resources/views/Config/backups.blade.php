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
            <h4> Lista de backups</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear Nuevo Producto">
                <form action="{{ route('backups.store') }}" method="post">
                    @csrf
                    <button class="btn btn-success" type="submit" style="position:relative;">
                        <i class="fas fa-plus"><text> Backup</text></i>
                    </button>
                </form>
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
                    <th width="5px">ID</th>
                    <th width="40px">Nombre</th>
                    <th width="45px">Acciones</th>
                </tr>
                </thead>
                @foreach ($backups as $backup)
                    <tr>
                        <td>{{ $backup->id }}</td>
                        <td>{{ $backup->file_name }}</td>
                        <td>
{{--                            <form action="{{ route('articulo.destroy',$articulo->id) }}" method="POST">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Desactivar">--}}
{{--                                    <button type="submit"  class="btn btn-success"><i class="fa fa-lightbulb"></i></button>--}}
{{--                                </span>--}}
{{--                            </form>--}}
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination-container">
                {!! $backups->links() !!}
            </div>
        </div>
    </div>
@stop

