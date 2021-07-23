@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')


    <form action="{{ route('listadotasa.store') }}" method="POST">
        <br><br>
        <div class="card; card bg-light mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Agregar Nueva Tasa </h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
            <a class="btn btn-primary" href="{{ route('listadotasa.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
            </span>
            </div>
            <div class="container">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label>Valor</label>
                        <input type="text" value="{{ @old('value') }}" class="form-control @error('value') is-invalid @enderror " placeholder="Ingrese Cuantos Bolívares Cuesta un Dólar" name="value" required>
                        @error('value')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <p class="align-left">
                    <span class="d-inline-block align-left" tabindex="0" data-toggle="tooltip" title="Crear">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"><text> Guardar</text></i></button>
                    </span>
                    </p>
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
