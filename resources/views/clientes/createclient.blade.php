@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')
@section('content')

    <form action="{{ route('client.store') }}" method="POST">
        @csrf

        <br><br>
        <div class="card; card mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Agregar Nuevo Cliente</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('client.customer') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Cédula</label>
                        <input type="integer" value="{{ @old('cedula') }}" class="form-control  @error('cedula') is-invalid @enderror " placeholder="Cédula" name="cedula" required>
                        @error('cedula')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Nombres</label>
                        <input type="string" value="{{ @old('nombres') }}" class="form-control  @error('nombres') is-invalid @enderror " name="nombres" placeholder="Nombres" required>
                        @error('nombres')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Apellidos</label>
                        <input type="string" value="{{ @old('apellidos') }}" class="form-control  @error('apellidos') is-invalid @enderror " name="apellidos" placeholder="Apellidos" required>
                        @error('apellidos')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Teléfono</label>
                        <input type="integer" value="{{ @old('telefono') }}" class="form-control  @error('telefono') is-invalid @enderror " name="telefono" placeholder="Teléfono" required>
                        @error('telefono')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Dirección</label>
                        <textarea type="text" value="{{ @old('direccion') }}" class="form-control  @error('direccion') is-invalid @enderror " name="direccion" placeholder="Direccion" required></textarea>
                        @error('direccion')
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
        //--validacion
        <script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>

    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })

    </script>
@stop
