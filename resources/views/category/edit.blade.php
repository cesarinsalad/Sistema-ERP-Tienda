@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <form action="{{ route('articulo.update',$articulo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <br><br>
        <div class="card; card bg-light mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos del Producto</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Codigo</label>
                        <input type="integer" class="form-control " value="{{ $articulo->codigo }}" placeholder="Cedula"
                               name="cedula" required>

                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Nombre</label>
                        <input type="string" class="form-control " value="{{ $articulo->nombre }}" name="nombres"
                               placeholder="Nombres" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Cantidad</label>
                        <input type="string" class="form-control " value="{{ $articulo->cantidad}}" name="apellidos"
                               placeholder="Apellidos" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Precio</label>
                        <input type="integer" class="form-control " value="{{ $articulo->precio }}" name="telefono"
                               placeholder="telefono" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Descripcion</label>
                        <textarea class="form-control " name="descripcion" placeholder="Detail"
                                  required>{{ $articulo->descripcion }} </textarea>
                    </div>
                </div>

                <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"><text> Guardar</text></i></button>
            </span>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
@endsection

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
