@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')

@section('content')

    <form action="{{ route('brands.update',$brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos de la Marca</h4>
                <a class="btn-premium-return" href="{{ route('brands.index') }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <div class="container pt-3">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" value="{{ $brand->name }}" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nombre" required>
                        @error('name')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row border-top pt-3">
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Guardar</button>
                    </div>
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
