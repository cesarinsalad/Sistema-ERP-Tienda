@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row pt-4">
        <div class="col-md-11 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Lista de Ventas</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-list mr-1"></i> Histórico de transacciones y órdenes procesadas</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <button onclick="generatePDF()" class="btn px-3 py-2 font-weight-bold" 
                                    style="background: #EEE1ED; color: #7D266E; border-radius: 50rem; text-transform: uppercase; border: none;">
                                <i class="far fa-file-pdf mr-2"></i> GENERAR PDF
                            </button>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('home') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> NUEVA VENTA
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('listorden.index') }}" method="GET" class="form-inline mb-0" style="gap:1rem; flex-wrap:wrap;">
                            <div class="input-group" style="width: 250px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por cliente..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            
                            <div class="form-group d-flex align-items-center bg-light px-3" style="border-radius: 10px; height: 45px;">
                                <label class="mr-3 font-weight-bold text-muted small uppercase m-0" style="letter-spacing: 0.05em;">Desde:</label>
                                <input class="form-control border-0 bg-transparent p-0" type="date" name="fromDate" value="{{ request('fromDate', $defaultFrom) }}">
                            </div>
                            <div class="form-group d-flex align-items-center bg-light px-3" style="border-radius: 10px; height: 45px;">
                                <label class="mr-3 font-weight-bold text-muted small uppercase m-0" style="letter-spacing: 0.05em;">Hasta:</label>
                                <input class="form-control border-0 bg-transparent p-0" type="date" name="toDate" value="{{ request('toDate', $defaultTo) }}">
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="seller_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 150px;">
                                    <option value="">Todos los Vendedores</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                            {{ $seller->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="payment_method_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 160px;">
                                    <option value="">Todos los Métodos de Pago</option>
                                    @foreach($paymentMethods as $pm)
                                        <option value="{{ $pm->id }}" {{ request('payment_method_id') == $pm->id ? 'selected' : '' }}>
                                            {{ $pm->nombre_metodo }} ({{ $pm->moneda }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                FILTRAR
                            </button>
                            @if(request('search') || request('fromDate') || request('toDate') || request('seller_id') || request('payment_method_id'))
                                <a href="{{ route('listorden.index') }}" class="btn btn-link text-muted font-weight-bold">Limpiar</a>
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
                        <table id="ventas-table" class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th width="60px">ID</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha</th>
                                    <th class="text-right">Monto (Bs)</th>
                                    <th class="text-right">Monto ($)</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $order->id }}</td>
                                    <td>
                                        <a href="{{ route('client.show',$order->client->id) }}" class="font-weight-bold text-purple">
                                            {{ $order->client->nombres }} {{ $order->client->apellidos }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px; font-weight: 600;">
                                            {{ strtoupper($order->seller->name) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small font-weight-600">{{ $order->created_at->format('d/m/Y h:i A') }}</td>
                                    <td class="text-right font-weight-bold">{{ number_format($order->monto_orden * $order->tasa->value, 2, ',', '.') }}Bs</td>
                                    <td class="text-right font-weight-bold text-success" style="font-size: 1.1rem;">
                                        {{ number_format($order->monto_orden, 2, ',', '.') }}$
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('listorden.show',$order->id) }}" 
                                               style="border-radius: 8px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger shadow-sm ml-2 return-btn" 
                                               data-order-id="{{ $order->id }}"
                                               style="border-radius: 8px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Procesar Devolución">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $orders->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Warning Modal --}}
    <div class="modal fade" id="warningModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
                <div class="modal-body text-center p-5">
                    <div class="warning-icon-container mb-4">
                        <div class="warning-icon-bg">
                            <i class="fas fa-exclamation"></i>
                        </div>
                    </div>
                    <h3 class="font-weight-bold mb-3" style="color: #1E293B;">Atención</h3>
                    <p id="warning-message" class="text-muted mb-4" style="font-size: 1.1rem;">No hay datos para generar el PDF.</p>
                    <button type="button" class="btn btn-block py-3 font-weight-bold" data-dismiss="modal" 
                            style="background: #7D266E; color: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);">
                        ENTENDIDO
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Devoluciones -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 1.25rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header bg-white border-bottom-0 pt-4 pb-2 px-4" style="border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 font-weight-bold" style="color: #334155;">
                        <i class="fas fa-undo mr-2 text-danger"></i> Procesar Devolución
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div id="return-loading" class="text-center py-4">
                        <div class="spinner-border text-danger" role="status"></div>
                        <p class="mt-2 text-muted">Cargando datos de la orden...</p>
                    </div>
                    
                    <form id="returnForm" class="hidden">
                        @csrf
                        <input type="hidden" id="return_order_id">
                        
                        <div class="form-group mb-4">
                            <label class="text-muted small font-weight-bold text-uppercase mb-2">Seleccione el producto a devolver</label>
                            <select id="return_product_id" class="form-control bg-light border-0 font-weight-bold" style="height: 45px; border-radius: 10px;" required>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-2">Cantidad a Devolver</label>
                                <input type="number" id="return_quantity" class="form-control bg-light border-0 text-center font-weight-bold" style="height: 45px; border-radius: 10px;" min="1" required>
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-2">Tipo de Devolución</label>
                                <select id="return_type" class="form-control bg-light border-0 font-weight-bold" style="height: 45px; border-radius: 10px;" required>
                                    <option value="same_item">Cambio por el mismo ítem</option>
                                    <option value="money_back">Devolución de dinero</option>
                                    <option value="different_item">Cambio por otro ítem distinto</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4 bg-light p-3" style="border-radius: 10px; border-left: 4px solid #75226d;">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="return_to_stock" checked>
                                <label class="custom-control-label font-weight-bold text-dark" for="return_to_stock" style="padding-top: 2px;">
                                    Restablecer el producto devuelto al inventario (Stock)
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1">Desmarque esta opción si el producto devuelto está dañado o no es apto para la venta.</small>
                        </div>

                        <div id="different_item_container" class="hidden border p-3 mb-4 rounded" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                            <h6 class="font-weight-bold text-purple mb-3">Datos del Nuevo Ítem</h6>
                            
                            <div class="form-group position-relative">
                                <label class="small font-weight-bold text-uppercase text-muted">Buscar Nuevo Producto</label>
                                <div class="input-group">
                                    <input type="text" id="new_product_search" class="form-control bg-white border-0" placeholder="Escriba código o nombre..." style="height: 45px; border-radius: 10px 0 0 10px;">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white border-0" style="border-radius: 0 10px 10px 0;"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                </div>
                                <div id="product-results-dropdown" class="dropdown-menu w-100"></div>
                            </div>
                            
                            <input type="hidden" id="new_product_id">
                            <input type="hidden" id="new_product_price">

                            <div id="selected_new_product_info" class="alert alert-info hidden mb-3" style="background-color: #f0fdfa; border-color: #ccfbf1; color: #0f766e;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <strong id="selected_new_product_name"></strong>
                                    </div>
                                    <div class="font-weight-bold" id="selected_new_product_price_display"></div>
                                </div>
                            </div>

                            <div id="difference_container" class="hidden mt-3 pt-3 border-top">
                                <p class="font-weight-bold mb-1">Diferencia a Pagar: <span id="difference_amount" class="text-danger h5">0.00 $</span></p>
                                <div class="form-group mt-3 mb-0">
                                    <label class="small font-weight-bold text-uppercase text-muted">Método de Pago para Diferencia</label>
                                    <select id="return_payment_method" class="form-control bg-white border-0 font-weight-bold" style="height: 45px; border-radius: 10px;">
                                        <option value="">Seleccione...</option>
                                        @foreach($paymentMethods as $pm)
                                            <option value="{{ $pm->id }}">{{ $pm->nombre_metodo }} ({{ $pm->moneda }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="text-muted small font-weight-bold text-uppercase mb-2">Motivo / Notas Adicionales (Opcional)</label>
                            <textarea id="return_reason" class="form-control bg-light border-0" rows="2" style="border-radius: 10px;" placeholder="Detalle por qué se devuelve el producto..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-end" style="border-bottom-left-radius: 1.25rem; border-bottom-right-radius: 1.25rem;">
                    <button type="button" class="btn px-4 font-weight-bold btn-light" data-dismiss="modal" style="border-radius: 10px; height: 45px;">
                        Cancelar
                    </button>
                    <button type="button" class="btn px-4 font-weight-bold btn-danger shadow-sm hidden" id="btn-submit-return" style="border-radius: 10px; height: 45px;">
                        <i class="fas fa-check-circle mr-2"></i> Confirmar Devolución
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .warning-icon-container { display: flex; justify-content: center; }
        .warning-icon-bg {
            width: 80px; height: 80px; background: #FEF3C7; color: #D97706;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
        }
        #ventas-table_filter { display: none; }
        .hidden { display: none; }
        
        /* Dropdown Styles for Product Search */
        #product-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1050;
            max-height: 250px;
            overflow-y: auto;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: none;
            border: 1px solid #E2E8F0;
        }
        .product-result-item {
            padding: 10px 15px;
            border-bottom: 1px solid #F1F5F9;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .product-result-item:last-child {
            border-bottom: none;
        }
        .product-result-item:hover, .product-result-item:focus {
            background-color: #F8FAFC;
            outline: none;
        }
        .product-result-item .result-main {
            font-weight: 600;
            color: #1E293B;
            font-size: 0.95rem;
        }
        .product-result-item .result-sub {
            font-size: 0.8rem;
            color: #64748B;
            margin-top: 2px;
        }
        .product-result-item .result-price {
            font-weight: 700;
            color: #7D266E;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
            // Auto logo detection
            const imgLogo = document.createElement('img');
            imgLogo.src = "{{ asset('imagenes/logo-gigi.png') }}";
            imgLogo.id = 'img-logo';
            imgLogo.className = 'd-none';
            document.body.appendChild(imgLogo);

            // Return Logic
            let currentOrder = null;
            let currentProductPrice = 0;

            $('.return-btn').click(function(e) {
                e.preventDefault();
                const orderId = $(this).data('order-id');
                $('#return_order_id').val(orderId);
                
                $('#returnModal').modal('show');
                $('#return-loading').removeClass('hidden');
                $('#returnForm').addClass('hidden');
                $('#btn-submit-return').addClass('hidden');
                $('#return-error').addClass('hidden');
                
                $.ajax({
                    url: `/ordenes/${orderId}/devolucion-info`,
                    type: 'GET',
                    success: function(res) {
                        currentOrder = res.order;
                        $('#return-loading').addClass('hidden');
                        $('#returnForm').removeClass('hidden');
                        $('#btn-submit-return').removeClass('hidden');
                        
                        let productSelect = $('#return_product_id');
                        productSelect.empty();
                        productSelect.append('<option value="">Seleccione un producto...</option>');
                        currentOrder.products.forEach(p => {
                            const unitPrice = parseFloat(p.pivot.precio) / parseInt(p.pivot.quantity);
                            productSelect.append(`<option value="${p.id}" data-qty="${p.pivot.quantity}" data-price="${unitPrice}">${p.nombre} (Disp: ${p.pivot.quantity})</option>`);
                        });
                    },
                    error: function(err) {
                        $('#returnModal').modal('hide');
                        $('#return-loading').addClass('hidden');
                        Swal.fire({
                            icon: 'error',
                            title: 'Devolución no permitida',
                            text: err.responseJSON?.error || 'Error al cargar la orden.',
                            confirmButtonColor: '#7D266E'
                        });
                    }
                });
            });

            $('#return_product_id').change(function() {
                const selected = $(this).find('option:selected');
                if (selected.val()) {
                    const maxQty = selected.data('qty');
                    currentProductPrice = parseFloat(selected.data('price'));
                    $('#return_quantity').attr('max', maxQty).val(1);
                    calculateDifference();
                } else {
                    $('#return_quantity').val('');
                }
            });

            $('#return_type').change(function() {
                const type = $(this).val();
                if (type === 'different_item') {
                    $('#different_item_container').removeClass('hidden');
                } else {
                    $('#different_item_container').addClass('hidden');
                }
                calculateDifference();
            });

            let searchTimeout;
            $('#new_product_search').on('keyup focus', function() {
                const q = $(this).val();
                clearTimeout(searchTimeout);
                
                if (!q || q.length < 2) {
                    $('#product-results-dropdown').hide();
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    $.ajax({
                        url: '{{ route("product.search") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            codigo: q
                        },
                        success: function(res) {
                            let dropdown = $('#product-results-dropdown');
                            dropdown.empty();
                            
                            if (res && res.length > 0) {
                                res.forEach(p => {
                                    let isOut = p.cantidad <= 0;
                                    let html = `
                                        <div class="dropdown-item d-flex justify-content-between align-items-center product-result-item" 
                                             data-id="${p.id}" data-name="${p.nombre}" data-price="${p.precio}" 
                                             style="${isOut ? 'opacity: 0.55; cursor: not-allowed; background-color: #F8FAFC;' : ''}">
                                            <div>
                                                <span class="result-main">${p.nombre}</span> ${isOut ? '<span class="badge badge-danger ml-2" style="font-size: 0.75rem;">Agotado</span>' : ''}
                                                <span class="result-sub d-block">${p.codigo} • Disp: <strong>${p.cantidad}</strong></span>
                                            </div>
                                            <div class="result-price text-right">$${parseFloat(p.precio).toFixed(2)}</div>
                                        </div>
                                    `;
                                    dropdown.append(html);
                                });
                                dropdown.show();
                            } else {
                                dropdown.html('<div class="dropdown-item text-muted">No se encontraron productos...</div>');
                                dropdown.show();
                            }
                        }
                    });
                }, 400);
            });

            // Handle selection
            $(document).on('click', '.product-result-item', function() {
                if ($(this).css('cursor') === 'not-allowed') return; // Cannot select out of stock
                
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = parseFloat($(this).data('price'));
                
                $('#new_product_id').val(id);
                $('#new_product_price').val(price);
                
                $('#selected_new_product_name').text(name);
                $('#selected_new_product_price_display').text(`$${price.toFixed(2)}`);
                $('#selected_new_product_info').removeClass('hidden');
                
                $('#new_product_search').val('');
                $('#product-results-dropdown').hide();
                
                calculateDifference();
            });

            // Close dropdown if clicked outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#new_product_search, #product-results-dropdown').length) {
                    $('#product-results-dropdown').hide();
                }
            });

            $('#return_quantity').change(function() {
                calculateDifference();
            });

            function calculateDifference() {
                if ($('#return_type').val() !== 'different_item') {
                    $('#difference_container').addClass('hidden');
                    return;
                }
                
                const newProductId = $('#new_product_id').val();
                const qty = parseInt($('#return_quantity').val()) || 1;
                
                if (newProductId && currentProductPrice) {
                    const newPrice = parseFloat($('#new_product_price').val());
                    const diff = (newPrice * qty) - (currentProductPrice * qty);
                    
                    $('#difference_container').removeClass('hidden');
                    if (diff < 0) {
                        $('#difference_amount').text(`-${Math.abs(diff).toFixed(2)} $ (No permitido, el monto debe ser igual o mayor)`).removeClass('text-success').addClass('text-danger');
                        $('#return_payment_method').val('').prop('required', false);
                    } else if (diff > 0) {
                        $('#difference_amount').text(`${diff.toFixed(2)} $`).removeClass('text-success').addClass('text-danger');
                        $('#return_payment_method').prop('required', true);
                    } else {
                        $('#difference_amount').text('0.00 $').removeClass('text-danger').addClass('text-success');
                        $('#return_payment_method').val('').prop('required', false);
                    }
                }
            }

            $('#btn-submit-return').click(function() {
                const orderId = $('#return_order_id').val();
                
                if (!$('#returnForm')[0].checkValidity()) {
                    $('#returnForm')[0].reportValidity();
                    return;
                }

                const data = {
                    _token: '{{ csrf_token() }}',
                    return_type: $('#return_type').val(),
                    product_id: $('#return_product_id').val(),
                    quantity: $('#return_quantity').val(),
                    return_to_stock: $('#return_to_stock').is(':checked') ? 1 : 0,
                    reason: $('#return_reason').val()
                };

                if (data.return_type === 'different_item') {
                    data.new_product_id = $('#new_product_id').val();
                    data.payment_method_id = $('#return_payment_method').val();
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Esta acción ajustará los inventarios y cajas de forma irreversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, confirmar devolución',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const btn = $('#btn-submit-return');
                        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Procesando...');
                        
                        $.ajax({
                            url: `/ordenes/${orderId}/procesar-devolucion`,
                            type: 'POST',
                            data: data,
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Devolución Exitosa!',
                                    text: res.message,
                                    confirmButtonColor: '#7D266E'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(err) {
                                btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-2"></i> Confirmar Devolución');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió un error',
                                    text: err.responseJSON?.error || 'Error al procesar la devolución.',
                                    confirmButtonColor: '#7D266E'
                                });
                            }
                        });
                    }
                });
            });
        });

        function generatePDF() {
            const fromDate = $('input[name="fromDate"]').val();
            const toDate = $('input[name="toDate"]').val();
            const search = $('input[name="search"]').val();
            const seller_id = $('select[name="seller_id"]').val();
            const payment_method_id = $('select[name="payment_method_id"]').val();

            $.ajax({
                url: "{{ route('listorden.pdfData') }}",
                method: 'GET',
                data: { fromDate, toDate, search, seller_id, payment_method_id },
                success: function(data) {
                    if (!data || data.length === 0) {
                        $('#warning-message').text('No hay datos para generar el PDF en este rango/búsqueda.');
                        $('#warningModal').modal('show');
                        return;
                    }
                    renderPDF(data, fromDate, toDate);
                },
                error: function() {
                    alert('Error al obtener los datos.');
                }
            });
        }

        function renderPDF(data, fromDate, toDate) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            const pageWidth = doc.internal.pageSize.getWidth();
            var x = 14, y = 20;

            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.text('GIGI FASHION IMPORT C.A.', x, y);
            
            const logo = document.getElementById('img-logo');
            if (logo) doc.addImage(logo, 'PNG', pageWidth - 42, y-10, 28, 28);

            doc.setFontSize(12);
            doc.setFont('helvetica', 'normal');
            doc.text("RIF: J-40270897-1", x, y+=7);
            
            doc.setFontSize(8);
            var addressText = "CALLE SAN NICOLAS ENTRE EL BOULEVAR GOMEZ Y GUEVARA LOCAL S/N NRO 7 SECTOR CENTRO PORLAMAR NUEVA ESPARTA, ZONA POSTAL 6301";
            var splitAddress = doc.splitTextToSize(addressText, pageWidth - 60);
            doc.text(splitAddress, x, y+=5);
            
            doc.setFontSize(10);
            y += (splitAddress.length * 4) + 2;
            doc.text('Periodo: ' + (fromDate || 'N/A') + ' al ' + (toDate || 'N/A'), x, y);
            doc.text('Fecha y hora de emisión: ' + new Date().toLocaleString('es-VE'), x, y+=5);

            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            y += 15;
            doc.text("REPORTE DE VENTAS", pageWidth / 2, y, { align: "center" });

            const headers = [['No', 'Cliente', 'Vendedor', 'Fecha', 'Monto ($)', 'Tasa', 'Monto (Bs)']];
            const rows = [];
            let totalUSD = 0;

            data.forEach(order => {
                const clientName = order.client ? (order.client.nombres + ' ' + (order.client.apellidos || '')) : 'N/A';
                const sellerName = order.seller ? order.seller.name : 'N/A';
                const montoUSD = parseFloat(order.monto_orden) || 0;
                const tasaValue = order.tasa ? parseFloat(order.tasa.value) : 0;
                totalUSD += montoUSD;

                rows.push([
                    order.id, clientName, sellerName,
                    new Date(order.created_at).toLocaleDateString(),
                    montoUSD.toFixed(2).replace('.', ',') + '$',
                    tasaValue.toFixed(2).replace('.', ',') + 'Bs',
                    (montoUSD * tasaValue).toFixed(2).replace('.', ',') + 'Bs'
                ]);
            });

            doc.autoTable({
                head: headers, body: rows, startY: y + 10, theme: 'grid',
                styles: { fontSize: 8, cellPadding: 3 },
                headStyles: { fillColor: [117, 34, 109], textColor: 255 },
                alternateRowStyles: { fillColor: [248, 250, 252] }
            });

            doc.text('Total en Ventas: ' + totalUSD.toFixed(2).replace('.', ',') + '$', 14, doc.lastAutoTable.finalY + 10);

            // Add page numbers
            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(120);
                const pWidth = doc.internal.pageSize.getWidth();
                const pHeight = doc.internal.pageSize.getHeight();
                const pageText = `Pág. ${i} de ${totalPages}`;
                doc.text(pageText, pWidth - 14, pHeight - 10, { align: 'right' });
            }

            doc.save('ventas_' + (fromDate || 'all') + '.pdf');
        }
    </script>
@stop
