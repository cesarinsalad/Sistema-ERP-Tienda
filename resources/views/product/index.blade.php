@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-11 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Inventario de Productos</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-boxes mr-1"></i> Gestión de existencias, precios y catálogo</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <a class="btn-premium-return" href="{{ route('articulo.inactivos') }}">
                                <i class="fas fa-archive"></i> VER INACTIVOS
                            </a>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('articulo.create') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> AGREGAR PRODUCTO
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('articulo.index') }}" method="GET" class="form-inline mb-0" style="gap:1rem; flex-wrap:wrap;">
                            <div class="input-group" style="width: 250px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por nombre o código..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="category_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 160px;">
                                    <option value="">Todas las Categorías</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="brand_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 160px;">
                                    <option value="">Todas las Marcas</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="stock" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 160px;">
                                    <option value="">Cualquier Stock</option>
                                    <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stock Bajo (≤ 5)</option>
                                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Agotado (≤ 0)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                FILTRAR
                            </button>
                            @if(request('search') || request('category_id') || request('brand_id') || request('stock'))
                                <a href="{{ route('articulo.index') }}" class="btn btn-link text-muted font-weight-bold">Limpiar</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <i class="fas fa-check-circle mr-2"></i> {{ $message }}
                </div>
            @endif

            {{-- Table Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th width="60px">No</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-right">Precio (Bs)</th>
                                    <th class="text-right">Precio ($)</th>
                                    <th>Marca</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articulos as $articulo)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ ++$i }}</td>
                                    <td class="font-weight-600 text-purple">{{ $articulo->codigo }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $articulo->nombre }}</div>
                                        <span class="badge {{ $articulo->is_active ? 'badge-success' : 'badge-danger' }} mt-1" style="font-size: 0.65rem;">
                                            {{ $articulo->is_active ? 'ACTIVO' : 'INACTIVO' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                         @if($articulo->cantidad <= 0)
                                             <span class="badge px-3 py-2" style="background: #FEE2E2; color: #991B1B; border-radius: 8px; font-weight: 700; font-size: 0.9rem;" data-toggle="tooltip" title="Agotado">
                                                 <i class="fas fa-times-circle mr-1"></i> Agotado
                                             </span>
                                         @elseif($articulo->cantidad <= 5)
                                             <span class="badge px-3 py-2" style="background: #FEF3C7; color: #92400E; border-radius: 8px; font-weight: 700; font-size: 0.9rem;" data-toggle="tooltip" title="Stock Bajo">
                                                 <i class="fas fa-exclamation-triangle mr-1"></i> {{ $articulo->cantidad }}
                                             </span>
                                         @else
                                             <span class="badge px-3 py-2" style="background: #DCFCE7; color: #166534; border-radius: 8px; font-weight: 700; font-size: 0.9rem;">
                                                 {{ $articulo->cantidad }}
                                             </span>
                                         @endif
                                     </td>
                                    <td class="text-right font-weight-bold">{{ number_format((floatval($articulo->precio) * floatval($tasaDolar)), 2, ',', '.') }}Bs</td>
                                    <td class="text-right font-weight-bold text-success" style="font-size: 1.1rem;">{{ number_format($articulo->precio, 2, ',', '.') }}$</td>
                                    <td>
                                         <span class="text-muted small font-weight-bold text-uppercase">{{ $articulo->brand->name }}</span>
                                     </td>
                                    <td>
                                         <div class="d-flex justify-content-center" style="gap: 8px;">
                                            <button type="button" class="btn btn-sm text-white shadow-sm btn-add-stock"
                                                    style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #10B981; border-color: #10B981;"
                                                    data-toggle="modal" 
                                                    data-target="#addStockModal"
                                                    data-id="{{ $articulo->id }}"
                                                    data-nombre="{{ $articulo->nombre }}"
                                                    data-stock="{{ $articulo->cantidad }}"
                                                    data-url="{{ route('articulo.addStock', $articulo->id) }}"
                                                    title="Agregar Stock">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('articulo.show', $articulo->id) }}" 
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{ route('articulo.edit', $articulo->id) }}"
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('articulo.destroy', $articulo->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm {{ $articulo->is_active ? 'btn-danger' : 'btn-success' }} shadow-sm"
                                                        style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                        data-toggle="tooltip" title="{{ $articulo->is_active ? 'Desactivar' : 'Reactivar' }}">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </form>
                                         </div>
                                     </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($articulos->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $articulos->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Agregar Stock --}}
    <div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #7D266E 0%, #5b1b50 100%); border-top-left-radius: 1.25rem; border-top-right-radius: 1.25rem;">
                    <h5 class="modal-title font-weight-bold" id="addStockModalLabel">
                        <i class="fas fa-boxes mr-2"></i> Agregar Stock
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addStockForm" method="POST" action="">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">Producto</label>
                            <input type="text" id="modalProductName" class="form-control border-0 bg-light font-weight-bold text-dark" readonly style="border-radius: 10px; height: 45px;">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Stock Actual</label>
                                <input type="text" id="modalCurrentStock" class="form-control border-0 bg-light font-weight-bold text-dark text-center" readonly style="border-radius: 10px; height: 45px;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Cantidad a Agregar</label>
                                <input type="number" name="cantidad_adicional" min="1" required class="form-control border-0 bg-light font-weight-bold text-purple text-center" style="border-radius: 10px; height: 45px; border: 2px solid #e2e8f0;" placeholder="Ej: 10">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">Proveedor</label>
                            <select name="vendor_id" required class="form-control border-0 bg-light font-weight-bold text-dark" style="border-radius: 10px; height: 45px; border: 2px solid #e2e8f0;">
                                <option value="">Seleccione un Proveedor...</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Costo Unitario ($)</label>
                                <input type="number" step="0.01" min="0" name="costo_unitario" required class="form-control border-0 bg-light font-weight-bold text-dark text-center" style="border-radius: 10px; height: 45px; border: 2px solid #e2e8f0;" placeholder="Ej: 5.50">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Fecha de Compra</label>
                                <input type="date" name="fecha_compra" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required class="form-control border-0 bg-light font-weight-bold text-dark text-center" style="border-radius: 10px; height: 45px; border: 2px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-end" style="border-bottom-left-radius: 1.25rem; border-bottom-right-radius: 1.25rem; gap: 10px;">
                        <button type="button" class="btn px-4 font-weight-bold btn-light" data-dismiss="modal" style="border-radius: 10px; height: 45px;">
                            Cancelar
                        </button>
                        <button type="submit" class="btn px-4 font-weight-bold text-white shadow-sm" style="background: #7D266E; border-radius: 10px; height: 45px;">
                            Agregar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.btn-add-stock').on('click', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var stock = $(this).data('stock');
                var url = $(this).data('url');

                $('#modalProductName').val(nombre);
                $('#modalCurrentStock').val(stock);
                $('#addStockForm').attr('action', url);
                
                // Limpiar/resetear los campos del modal al abrirlo
                $('#addStockForm').find('input[name="cantidad_adicional"]').val('');
                $('#addStockForm').find('select[name="vendor_id"]').val('');
                $('#addStockForm').find('input[name="costo_unitario"]').val('');
                
                var today = new Date().toISOString().split('T')[0];
                $('#addStockForm').find('input[name="fecha_compra"]').val(today);
            });
        });
    </script>
@stop
