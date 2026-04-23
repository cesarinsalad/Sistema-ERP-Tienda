@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')
@section('plugins.Bootstrapselect', true)

@section('content')
    <div class="row pt-4">
        <div class="col-md-10 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Agregar Nuevo Producto</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-box-open mr-1"></i> Ingrese los detalles técnicos y comerciales del artículo</p>
                        </div>
                        <a class="btn-premium-return" href="{{ url()->previous() }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('articulo.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Código de Producto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-barcode text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="codigo" value="{{ old('codigo') }}" 
                                           class="form-control border-0 bg-light @error('codigo') is-invalid @enderror" 
                                           placeholder="Ej: ART-001" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('codigo')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nombre del Producto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-tag text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nombre" value="{{ old('nombre') }}" 
                                           class="form-control border-0 bg-light @error('nombre') is-invalid @enderror" 
                                           placeholder="Nombre descriptivo" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('nombre')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Existencia Inicial</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-cubes text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="number" name="cantidad" value="{{ old('cantidad') }}" 
                                           class="form-control border-0 bg-light @error('cantidad') is-invalid @enderror" 
                                           placeholder="0" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('cantidad')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Precio Unitario ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-dollar-sign text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="precio" value="{{ old('precio') }}" 
                                           class="form-control border-0 bg-light @error('precio') is-invalid @enderror" 
                                           placeholder="0.00" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('precio')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Marca</label>
                                <select class="form-control selectpicker border-0 bg-light" name="brand_id" data-live-search="true" title="Seleccionar...">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Categorías</label>
                                <select class="form-control selectpicker border-0 bg-light" multiple name="category_id[]" data-live-search="true" title="Seleccionar categorías...">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (is_array(old('category_id')) && in_array($category->id, old('category_id'))) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Proveedor Principal</label>
                                <select class="form-control selectpicker border-0 bg-light" name="vendor_id" data-live-search="true" title="Seleccionar proveedor...">
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Descripción Detallada</label>
                                <textarea name="descripcion" class="form-control border-0 bg-light" 
                                          placeholder="Detalles adicionales del producto..." rows="3" style="border-radius: 12px;">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> GUARDAR PRODUCTO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .bootstrap-select .btn {
            background-color: #f8f9fa !important;
            border: none !important;
            height: 45px !important;
            border-radius: 10px !important;
            padding-left: 15px !important;
        }
        .bootstrap-select .dropdown-toggle:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('.selectpicker').selectpicker();
        })
    </script>
@stop
