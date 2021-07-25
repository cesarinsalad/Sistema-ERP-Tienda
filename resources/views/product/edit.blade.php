@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')
@section('plugins.Bootstrapselect', true)

@section('content')

    <form action="{{ route('articulo.update',$articulo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <br><br>
        <div class="card; card mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos del Producto</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Código</label>
                        <input type="integer"  value="@if(@old('codigo')){{ @old('codigo') }}@else{{ $articulo->codigo }}@endif" class="form-control @error('codigo') is-invalid @enderror "   placeholder="Código"  name="codigo" required>
                        @error('codigo')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nombre</label>
                        <input type="string" value="@if(@old('nombre')){{ @old('nombre') }}@else{{ $articulo->nombre }}@endif" class="form-control  @error('nombre') is-invalid @enderror " name="nombre"  placeholder="Nombre" required>
                        @error('nombre')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Cantidad</label>
                        <input type="string" value="@if(@old('cantidad')){{ @old('cantidad') }}@else{{ $articulo->cantidad }}@endif" class="form-control  @error('cantidad') is-invalid @enderror" name="cantidad"  placeholder="Cantidad" required>
                        @error('cantidad')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Precio ($)</label>
                        <input type="integer" value="@if(@old('precio')){{ @old('precio') }}@else{{ $articulo->precio }}@endif" class="form-control @error('precio') is-invalid @enderror " name="precio" placeholder="Precio" required>
                        @error('precio')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label>Categoría</label>
                    <div class="bs-container">
                        <select class="form-control selectpicker  @error('category_id') is-invalid @enderror" multiple name="category_id[]" id="select-category" data-live-search="true" data-size="5">
                            @foreach($categories as $category)
                                <option data-tokens="{{ $category->name }}"
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
                </div>

                <div class="col-md-6 mb-3">
                    <label>Marca</label>
                    <select class="form-control @error('brand') is-invalid @enderror" name="brand_id">
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
                </div>

                <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label>Proveedores</label>
                    <select class="form-control @error('vendor') is-invalid @enderror" name="vendor_id">
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

                    <div class="col-md-6 mb-3">
                        <label>Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror "  name="descripcion" placeholder="Descripción" required>{{ $articulo->descripcion }} </textarea>
                        @error('descripcion')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
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
            $('.selectpicker').selectpicker({ language: 'ES' });
            $('#select-category').selectpicker('val', {{$selectedCategories}});
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@stop
