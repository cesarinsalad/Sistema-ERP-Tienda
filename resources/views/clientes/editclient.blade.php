@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')


@section('content')
<form action="{{ route('client.update',$client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
<br><br>
        <div class="card mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos del Cliente</h4>
                <a class="btn-premium-return" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <div class="container pt-3">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Cédula</label>
                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ $client->cedula }}" placeholder="Cédula" name="cedula" required>
                        @error('cedula')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Nombres</label>
                        <input type="text" class="form-control @error('nombres') is-invalid @enderror" value="{{ $client->nombres }}" name="nombres" placeholder="Nombres" required>
                        @error('nombres')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror" value="{{ $client->apellidos }}" name="apellidos" placeholder="Apellidos" required>
                        @error('apellidos')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{ $client->telefono }}" name="telefono" placeholder="Teléfono" required>
                        @error('telefono')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Dirección</label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" name="direccion" placeholder="Dirección" required>{{ $client->direccion }}</textarea>
                        @error('direccion')
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
    <script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
