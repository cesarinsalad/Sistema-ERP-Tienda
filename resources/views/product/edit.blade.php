@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')
@section('plugins.Bootstrapselect', true)

@section('content')

    <form action="{{ route('articulo.update',$articulo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-3">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos del Producto</h4>
                <a class="btn-premium-return" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <div class="container pt-3">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Código</label>
                        <input type="text" value="@if(@old('codigo')){{ @old('codigo') }}@else{{ $articulo->codigo }}@endif"
                               class="form-control @error('codigo') is-invalid @enderror"
                               name="codigo">
                        @error('codigo')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" value="@if(@old('nombre')){{ @old('nombre') }}@else{{ $articulo->nombre }}@endif"
                               class="form-control @error('nombre') is-invalid @enderror" name="nombre">
                        @error('nombre')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Cantidad</label>
                        <input type="text" value="@if(@old('cantidad')){{ @old('cantidad') }}@else{{ $articulo->cantidad }}@endif"
                               class="form-control @error('cantidad') is-invalid @enderror" name="cantidad">
                        @error('cantidad')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Precio ($)</label>
                        <input type="text" value="@if(@old('precio')){{ @old('precio') }}@else{{ $articulo->precio }}@endif"
                               class="form-control @error('precio') is-invalid @enderror" name="precio">
                        @error('precio')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Categoría</label>
                        <select class="form-control selectpicker @error('category_id') is-invalid @enderror" multiple name="category_id[]" id="select-category" data-live-search="true" data-size="5" title="Seleccionar categoría">
                            @foreach($categories as $category)
                                <option data-tokens="{{ $category->name }}"
                                        value="{{ $category->id }}"
                                        @if(@old('category_id') == $category->id)
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
                        <select class="form-control selectpicker @error('brand_id') is-invalid @enderror" name="brand_id" data-live-search="true" data-size="5" title="Seleccionar marca">
                            @foreach($brands as $brand)
                                <option data-tokens="{{ $brand->name }}"
                                        value="{{ $brand->id }}"
                                        @if(@old('brand_id') == $brand->id || $articulo->brand_id == $brand->id)
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
                        <select class="form-control selectpicker @error('vendor_id') is-invalid @enderror" name="vendor_id" data-live-search="true" data-size="5" title="Seleccionar proveedor">
                            @foreach($vendors as $vendor)
                                <option data-tokens="{{ $vendor->name }}"
                                        value="{{ $vendor->id }}"
                                        @if(@old('vendor_id') == $vendor->id || $articulo->vendor_id == $vendor->id)
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
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Descripción">{{ $articulo->descripcion }}</textarea>
                        @error('descripcion')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
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
            $('.selectpicker').selectpicker({ language: 'ES' });
            $('#select-category').selectpicker('val', {{$selectedCategories}});
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@stop
