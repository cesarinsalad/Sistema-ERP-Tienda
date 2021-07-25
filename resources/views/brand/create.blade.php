@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')

    <form action="{{ route('brands.store') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Agregar nueva marca</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('brands.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" value="{{ @old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" name="name" >
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
