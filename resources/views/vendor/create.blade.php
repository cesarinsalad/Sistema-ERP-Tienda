@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')

    <form action="{{ route('vendors.store') }}" method="POST">
        @csrf

        <div class="card bg-light mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Agregar Nuevo Proveedor</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('vendors.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
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


                    <div class="col-md-4 mb-3">
                        <label>Tipo de Documento</label>
                        <select  value="{{ @old('type_document') }}" class="form-control @error('type_document') is-invalid @enderror" name="type_document" placeholder="Seleccionar">
                            <option value="CI">CI</option>
                            <option value="RIF">RIF</option>
                        @error('type_document')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Documento</label>
                        <input type="text" value="{{ @old('document') }}" class="form-control  @error('document') is-invalid @enderror " name="document" placeholder="Documento" >
                        @error('document')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label >Descripción</label>
                        <textarea  value="{{ @old('document') }}" class="form-control  @error('description') is-invalid @enderror "  name="description" placeholder="Descripción" ></textarea>
                        @error('description')
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
