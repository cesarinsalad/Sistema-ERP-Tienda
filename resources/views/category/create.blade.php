@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')

    <form action="{{ route('articulo.store') }}" method="POST">
        @csrf

        <div class="card bg-light mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Agregar Nuevo Producto</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Codigo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Código" name="codigo" >
                        @error('codigo')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Cantidad</label>
                        <input type="text" class="form-control" name="cantidad" placeholder="Cantidad" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Precio</label>
                        <input type="text" class="form-control" name="precio" placeholder="Precio" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationServer05">Descripcion</label>
                        <textarea class="form-control" id="validationServer05" name="descripcion"
                                  placeholder="Descripcion" ></textarea>
                    </div>
                </div>
                <div class="py-3 px-3 border-bottom d-flex justify-content-between">
               <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"><text> Guardar</text></i></button>
                </span>
                </div>
            </div>
        </div>
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
