@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')

@section('content')

    <form action="{{ route('vendors.update',$vendor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos del Proveedor</h4>
                <a class="btn-premium-return" href="{{ route('vendors.index') }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>

            <div class="container pt-3">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $vendor->name }}" name="name" placeholder="Nombre" required>
                        @error('name')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Tipo de Documento</label>
                        <select class="form-control @error('type_document') is-invalid @enderror" name="type_document" required>
                            <option value="CI" {{ $vendor->type_document == 'CI' ? 'selected' : '' }}>CI</option>
                            <option value="RIF" {{ $vendor->type_document == 'RIF' ? 'selected' : '' }}>RIF</option>
                        </select>
                        @error('type_document')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Documento</label>
                        <input type="text" class="form-control @error('document') is-invalid @enderror" name="document" placeholder="Documento" value="{{ $vendor->document }}" required>
                        @error('document')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $vendor->email }}" name="email" placeholder="Correo electrónico">
                        @error('email')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ $vendor->phone }}" name="phone" placeholder="Número telefónico">
                        @error('phone')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Descripción</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripción" required>{{ $vendor->description }}</textarea>
                        @error('description')
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
