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
                        <label>Código</label>
                        <input type="text" value="{{ @old('codigo') }}"
                               class="form-control @error('codigo') is-invalid @enderror" placeholder="Código"
                               name="codigo">
                        @error('codigo')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" value="{{ @old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror " name="nombre"
                               placeholder="Nombre">
                        @error('nombre')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Cantidad</label>
                        <input type="text" value="{{ @old('cantidad') }}"
                               class="form-control @error('cantidad') is-invalid @enderror  " name="cantidad"
                               placeholder="Cantidad">
                        @error('cantidad')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Precio</label>
                        <input type="text" value="{{ @old('precio') }}"
                               class="form-control @error('precio') is-invalid @enderror " name="precio"
                               placeholder="Precio">
                        @error('precio')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Categoría</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @if(@old('çategory_id') == $category->id)
                                        selected
                                    @endif
                                >{{ $category->name }}</option>
                            @endforeach
                            @error('category_id')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Marca</label>
                        <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id">
                            @foreach($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    @if(@old('brand_id') == $brand->id)
                                    selected
                                    @endif
                                >{{ $brand->name }}</option>
                            @endforeach
                            @error('brand_id')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Proveedores</label>
                        <select class="form-control @error('vendor_id') is-invalid @enderror" name="vendor_id">
                            @foreach($vendors as $vendor)
                                <option
                                    value="{{ $vendor->id }}"
                                    @if(@old('vendor_id') == $vendor->id)
                                    selected
                                    @endif
                                >{{ $vendor->name }}</option>
                            @endforeach
                            @error('vendor_id')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Descripción</label>
                        <textarea value="{{ @old('descripcion') }}"
                                  class="form-control @error('descripcion') is-invalid @enderror " name="descripcion"
                                  placeholder="Descripción"></textarea>
                        @error('descripcion')
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
