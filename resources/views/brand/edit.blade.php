@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <form action="{{ route('brands.update',$brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <br><br>
        <div class="card; card bg-light mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos de la Marca</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('brands.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Nombre</label>
                        <input type="string" value="{{ $brand->name }}" class="form-control @error('name') is-invalid @enderror " value="{{ $brand->name }}" name="name" placeholder="Nombre" required>
                        @error('name')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
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
