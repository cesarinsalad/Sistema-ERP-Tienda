@extends('adminlte::page')

@section('title', 'Panel de Ventas | GIGI FASHION')

@section('plugins.Bootstrapselect', true)

@section('content')
<div class="container-fluid pt-3">
    <form action="{{ route('home.guardarorden') }}" id="order-form" method="POST">
        @csrf
        {{-- Main Row for Split Panel --}}
        <div class="row">
        
        {{-- CENTRAL COLUMN: Interaction (col-lg-8) --}}
        <div class="col-lg-8 pr-lg-4">
            
            {{-- 1. IDENTIFICAR CLIENTE --}}
            <div class="card border-0 shadow-sm mb-2" style="border-radius: 1rem; border: 1px solid #E2E8F0;">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold mb-3 text-dark"><i class="fas fa-user-circle mr-2 text-purple"></i> 1. Identificar Cliente</h6>
                    
                    <div id="client-search-section">
                        <div class="d-flex align-items-center" style="gap: 0.5rem;">
                            <div class="input-group shadow-sm" style="border-radius: 0.75rem; overflow: hidden; border: 1px solid #E2E8F0; flex: 1;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-white text-muted px-3"><i class="fas fa-search"></i></span>
                                </div>
                                <input id="busqueda" type="text" name="cedula_name" class="form-control border-0 px-2" placeholder="Ingrese Cédula para buscar..." style="font-size: 0.95rem; height: 40px;">
                            </div>
                            <button id="crear-cliente-btn" class="btn d-flex align-items-center justify-content-center" 
                                    style="background: #7D266E; color: white; width: 40px; height: 40px; border-radius: 0.75rem;" 
                                    title="Crear Cliente Nuevo">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Client Summary Card (Identified) --}}
                    <div id="resultado-cliente" class="mt-3" style="display: none;">
                        <div class="d-flex align-items-center p-3" style="background: #F8FAFC; border-radius: 1rem; border: 1px solid #E2E8F0;">
                            <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: #EEE1ED; color: #7D266E; border-radius: 50%;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div style="flex: 1;">
                                <p class="mb-0 text-muted small font-weight-bold uppercase" style="letter-spacing: 0.05em;">Cliente Identificado</p>
                                <h6 class="mb-0 font-weight-bold text-dark" id="client-display-name">---</h6>
                            </div>
                            <button type="button" id="editar-cliente-btn" class="btn-remove-item">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    {{-- New Client Form (Shown if not found) --}}
                    <div id="nuevo-cliente-form" class="mt-3" style="display: none;">
                        <p class="text-purple font-weight-bold small uppercase mb-3"><i class="fas fa-user-plus mr-1"></i> Nuevo Cliente: Ingrese Datos</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold uppercase mb-1">Cédula</label>
                                <input type="text" id="view-cedula" class="form-control border-0 bg-light rounded-lg" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold uppercase mb-1">Nombres</label>
                                <input type="text" name="client_nom" id="client_nom" class="form-control border-0 bg-light rounded-lg" placeholder="Nombres del cliente" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold uppercase mb-1">Apellidos</label>
                                <input type="text" name="client_ape" id="client_ape" class="form-control border-0 bg-light rounded-lg" placeholder="Apellidos del cliente" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold uppercase mb-1">Teléfono</label>
                                <input type="text" name="client_tel" id="client_tel" class="form-control border-0 bg-light rounded-lg" placeholder="Número de contacto">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="text-muted small font-weight-bold uppercase mb-1">Dirección</label>
                                <textarea name="client_dir" id="client_dir" class="form-control border-0 bg-light rounded-lg" placeholder="Dirección de habitación" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="button" id="registrar-cliente-ajax" class="btn btn-block py-2 font-weight-bold" 
                                        style="background: #EEE1ED; color: #7D266E; border-radius: 0.75rem;">
                                    <i class="fas fa-save mr-1"></i> REGISTRAR Y VALIDAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. SELECCIONAR PRODUCTOS --}}
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 1rem; border: 1px solid #E2E8F0;">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold mb-3 text-dark"><i class="fas fa-shopping-bag mr-2 text-purple"></i> 2. Seleccionar Producto(s)</h6>
                    
                    <div class="mb-3 position-relative">
                        <div class="input-group shadow-sm" style="border-radius: 0.75rem; overflow: hidden; border: 1px solid #E2E8F0;">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-0 bg-white text-muted px-3"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="product-search-input" class="form-control border-0 px-2" placeholder="Escriba el nombre o código del producto..." autocomplete="off" style="font-size: 0.95rem; height: 40px;">
                        </div>
                        {{-- Custom Dropdown for Results --}}
                        <div id="product-results-dropdown" class="dropdown-menu shadow-lg border-0 w-100 mt-1" style="border-radius: 1rem; max-height: 350px; overflow-y: auto; display: none; z-index: 1050;">
                            {{-- Results populated via JS --}}
                        </div>
                    </div>

                    {{-- Products Table / Empty State --}}
                    <div id="product-list-container">
                        {{-- Empty State --}}
                        <div id="empty-state" class="text-center py-5">
                            <i class="fas fa-boxes text-muted mb-3" style="font-size: 5rem; opacity: 0.3;"></i>
                            <h6 class="text-muted font-weight-bold">Aún no hay productos en la venta</h6>
                            <p class="text-muted small">Busca un producto arriba</p>
                        </div>

                        {{-- Table (Hidden if empty) --}}
                        <div id="product-table-wrapper" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="product-table">
                                    <thead class="text-muted small font-weight-bold uppercase" style="border-bottom: 2px solid #F1F5F9;">
                                        <tr>
                                            <th class="py-3">COD</th>
                                            <th class="py-3">NOMBRE</th>
                                            <th class="py-3 text-center" style="width: 120px;">CANTIDAD</th>
                                            <th class="py-3 text-right">MONTO</th>
                                            <th class="py-3 text-center">ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Rows added via JS --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Sticky Checkout Card (col-lg-4) --}}
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px; z-index: 1020;">
                <div class="card border-0 shadow-md" style="border-radius: 1.5rem; overflow: hidden; border: 1px solid #E2E8F0;">
                    <input id="client-id" name="client_id_name" type="hidden"/>
                    {{-- Hidden inputs for form submission --}}
                    <div id="form-hidden-data"></div>

                    <div class="card-body p-3">
                            <div class="text-center mb-2">
                                <p class="text-muted small font-weight-bold uppercase mb-0">Total a Pagar</p>
                                <h3 class="font-weight-bold mb-0" style="color: #7D266E; letter-spacing: -0.5px;" id="total-display">$0.00</h3>
                                <p class="text-muted small" id="total-bs-display" style="font-weight: 500;">(0.00 Bs)</p>
                            </div>

                            <hr class="my-3" style="border-top: 2px dashed #E2E8F0;">

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal ($)</span>
                                    <span class="font-weight-bold text-dark" id="subtotal-display">0.00 $</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" id="balance-row" style="display: none !important;">
                                    <span class="text-muted font-weight-bold" id="balance-label">Pendiente</span>
                                    <span class="font-weight-bold text-danger" id="balance-display">0.00 $</span>
                                </div>
                            </div>

                        <div class="mb-3">
                            <p class="text-muted small font-weight-bold uppercase mb-2">Seleccionar Método de Pago</p>
                            <div class="payment-methods-grid" style="display: grid; gap: 8px;">
                                    @foreach ($paymentMethods as $method)
                                        <div class="payment-item-wrapper mb-2">
                                            <button type="button" class="btn btn-payment-method d-flex align-items-center p-2" 
                                                    data-id="{{ $method->id }}" 
                                                    data-name="{{ $method->nombre_metodo }}"
                                                    data-currency="{{ $method->moneda }}"
                                                    style="width: 100%; border-radius: 0.75rem; border: 1px solid #E2E8F0; background: white; transition: all 0.2s;">
                                                <div class="d-flex align-items-center w-100">
                                                    <div class="mr-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #F1F5F9; color: #475569; border-radius: 50%;">
                                                        @if(Str::contains(strtoupper($method->nombre_metodo), 'EFECTIVO'))
                                                            <i class="fas fa-money-bill-alt small" style="font-size: 0.75rem;"></i>
                                                        @elseif(Str::contains(strtoupper($method->nombre_metodo), 'PAGO MOVIL') || Str::contains(strtoupper($method->nombre_metodo), 'PAGO MÓVIL'))
                                                            <i class="fas fa-mobile-alt small" style="font-size: 0.75rem;"></i>
                                                        @elseif(Str::contains(strtoupper($method->nombre_metodo), 'ZELLE'))
                                                            <span style="font-weight: 800; font-family: monospace; font-size: 0.9rem; line-height: 1;">Z</span>
                                                        @else
                                                            <i class="fas fa-credit-card small" style="font-size: 0.75rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div style="flex: 1; display: flex; align-items: center;">
                                                        <span class="font-weight-bold text-dark small" style="font-size: 0.8rem; margin: 0;">{{ $method->nombre_metodo }}</span>
                                                    </div>
                                                </div>
                                                <div class="check-icon invisible" style="color: #7D266E;">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </button>
                                            
                                            {{-- Amount/Ref Input Panel (Hidden when not active) --}}
                                            @php
                                                $methodName = strtoupper($method->nombre_metodo);
                                                $noRefNeeded = Str::contains($methodName, 'EFECTIVO') || Str::contains($methodName, 'TARJETA');
                                            @endphp
                                            <div class="payment-details-panel p-2 shadow-sm" style="display: none; background: #FDF4FB; border: 1px solid #7D266E; border-radius: 0 0 0.75rem 0.75rem; border-top: none;">
                                                <div class="row no-gutters" style="gap: 8px;">
                                                    <div class="{{ $noRefNeeded ? 'col-12' : 'col' }}">
                                                        <label class="small font-weight-bold text-purple uppercase mb-0" style="font-size: 0.65rem;">Monto ({{ $method->moneda }})</label>
                                                        <input type="number" step="0.01" class="form-control form-control-sm method-amount-input" 
                                                               data-id="{{ $method->id }}" placeholder="0.00" style="border-radius: 0.4rem; height: 28px; font-size: 0.8rem;">
                                                    </div>
                                                    @if(!$noRefNeeded)
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-purple uppercase mb-0" style="font-size: 0.65rem;">Referencia</label>
                                                        <input type="text" class="form-control form-control-sm method-ref-input" 
                                                               data-id="{{ $method->id }}" placeholder="Ref" style="border-radius: 0.4rem; height: 28px; font-size: 0.8rem;">
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" id="generateOrderBtn" class="btn btn-block py-2 mt-2" 
                                    style="background: #7D266E; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.3);">
                                PROCESAR VENTA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Success Modal --}}
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
            <div class="modal-body text-center p-5">
                <div class="success-icon-container mb-4">
                    <div class="success-icon-bg">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <h3 class="font-weight-bold mb-3" style="color: #1E293B;">¡Venta Exitosa!</h3>
                <p class="text-muted mb-4" style="font-size: 1.1rem;">{{ session('success') }}</p>
                
                <div class="d-flex flex-column" style="gap: 10px;">
                    <button type="button" class="btn btn-block py-3 font-weight-bold" data-dismiss="modal" 
                            style="background: #7D266E; color: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);">
                        NUEVA VENTA
                    </button>
                    <a href="{{ route('listorden.index') }}" class="btn btn-link text-muted font-weight-bold py-2">
                        Ver listado de ventas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Error Modal --}}
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-body text-center p-5">
                <i class="fas fa-exclamation-circle text-danger mb-4" style="font-size: 4rem;"></i>
                <h4 class="font-weight-bold mb-3">Atención</h4>
                <p id="err-description" class="text-muted mb-4"></p>
                <button type="button" class="btn btn-danger btn-block py-2" data-dismiss="modal" style="border-radius: 0.75rem; font-weight: 600;">Entendido</button>
            </div>
        </div>
    </div>
</div>

{{-- Footer script is handled by AdminLTE, but custom JS stays here --}}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    body { background-color: #F1F5F9; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    
    .rounded-2xl { border-radius: 1rem !important; }
    
    /* Custom Selectpicker Styling */
    .bootstrap-select .btn { 
        background: white !important; 
        border: none !important; 
        box-shadow: none !important;
        font-weight: 600;
        color: #475569 !important;
    }
    .bootstrap-select .dropdown-menu { border-radius: 1rem; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    
    /* Payment Method Button Styling */
    .btn-payment-method:hover { border-color: #7D266E !important; background: #FDF4FB !important; }
    .btn-payment-method.active { border-color: #7D266E !important; background: #7D266E !important; color: white !important; border-radius: 1rem 1rem 0 0 !important; }
    .btn-payment-method.active .text-dark, .btn-payment-method.active .text-muted { color: white !important; }
    .btn-payment-method.active .method-icon { background: rgba(255,255,255,0.2) !important; color: white !important; }
    .btn-payment-method.active .check-icon { visibility: visible !important; color: white !important; }
    
    .text-purple { color: #7D266E !important; }

    /* Table Styling */
    .metrics-table td { padding: 1.25rem 0.75rem; vertical-align: middle; }
    .quantity-input { width: 70px; text-align: center; border-radius: 0.75rem; border: 1px solid #E2E8F0; padding: 5px; font-weight: 600; }
    
    .btn-remove-item { width: 32px; height: 32px; border-radius: 10px; background: #FEE2E2; color: #EF4444; border: none; transition: all 0.2s; }
    .btn-remove-item:hover { background: #EF4444; color: white; }

    /* Success Icon Animation */
    .success-icon-container { display: flex; justify-content: center; }
    .success-icon-bg {
        width: 100px; height: 100px; background: #DCFCE7; color: #16A34A;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 3rem; animation: scaleUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes scaleUp {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Autocomplete Styling */
    .product-result-item { cursor: pointer; padding: 12px 20px; border-bottom: 1px solid #F1F5F9; transition: background 0.2s; }
    .product-result-item:hover { background: #FDF4FB; }
    .product-result-item:last-child { border-bottom: none; }
    .result-main { display: block; font-weight: 700; color: #1E293B; font-size: 1rem; }
    .result-sub { display: block; font-size: 0.8rem; color: #64748B; margin-top: 2px; }
    .result-price { font-weight: 800; color: #7D266E; font-size: 1.1rem; }
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    const _token = '{{ csrf_token() }}';
    const tasa = {{ $tasaDolar }};
    let productList = [];
    let selectedPaymentMethods = [];
    let totalOrder = 0;

    // Initialization
    $('.selectpicker').selectpicker();

    // Show Success Modal if session exists
    @if(session('success'))
        $('#successModal').modal('show');
    @endif

    // 1. CLIENT IDENTIFICATION
    $('#busqueda').on('keypress', function(e) {
        if(e.which == 13) {
            buscarCliente($(this).val());
        }
    });

    $('#busqueda').on('blur', function() {
        if($(this).val() != '') buscarCliente($(this).val());
    });

    function buscarCliente(cedula) {
        $.ajax({
            url: '{{ route("client.search") }}',
            method: 'POST',
            data: { cedula: cedula, _token: _token },
            success: function (data) {
                if (data.client) {
                    if(!data.client.is_active){
                        showError('El cliente se encuentra Inactivo.');
                        return;
                    }
                    $('#client-id').val(data.client.id);
                    $('#client-display-name').text(data.client.nombres + ' ' + (data.client.apellidos || ''));
                    $('#resultado-cliente').fadeIn();
                    $('#nuevo-cliente-form').hide();
                    $('#client-search-section').hide();
                } else {
                    // Not found: Show Quick Add Form
                    $('#client-id').val('');
                    $('#view-cedula').val(cedula);
                    $('#resultado-cliente').hide();
                    $('#nuevo-cliente-form').fadeIn();
                    $('#client-search-section').hide();
                }
            }
        });
    }

    // Reset client
    $('#editar-cliente-btn').on('click', function() {
        $('#resultado-cliente').hide();
        $('#nuevo-cliente-form').hide();
        $('#client-search-section').fadeIn();
        $('#client-id').val('');
        $('#busqueda').val('').focus();
    });

    // Also trigger form show on "+" button click for clarity
    $('#crear-cliente-btn').on('click', function() {
        const cedula = $('#busqueda').val();
        if(cedula) {
            buscarCliente(cedula);
        } else {
            showError('Escriba una cédula primero.');
        }
    });

    // AJAX Client Registration
    $('#registrar-cliente-ajax').on('click', function() {
        const cedula = $('#busqueda').val();
        const nombres = $('#client_nom').val();
        const apellidos = $('#client_ape').val();
        const telefono = $('#client_tel').val();
        const direccion = $('#client_dir').val();

        if(!nombres) { showError('El nombre es obligatorio.'); return; }

        $.ajax({
            url: '{{ route("client.store") }}',
            method: 'POST',
            data: {
                cedula: cedula,
                nombres: nombres,
                apellidos: apellidos,
                telefono: telefono,
                direccion: direccion,
                _token: _token,
                is_active: 1
            },
            success: function(response) {
                // If success, we just search again to identify him properly and get the ID
                buscarCliente(cedula);
            },
            error: function(xhr) {
                const msg = xhr.responseJSON && xhr.responseJSON.error 
                            ? xhr.responseJSON.error 
                            : 'Error al registrar cliente. Verifique los datos.';
                showError(msg);
            }
        });
    });

    // 2. PRODUCT SELECTION (REFACTORED AUTOCOMPLETE)
    let searchTimeout = null;

    $('#product-search-input').on('keyup', function() {
        const query = $(this).val();
        
        clearTimeout(searchTimeout);
        if(query.length < 2) {
            $('#product-results-dropdown').hide();
            return;
        }

        searchTimeout = setTimeout(() => {
            $.ajax({
                url: '{{ route("product.search") }}',
                method: 'POST',
                data: { codigo: query, _token: _token },
                success: function (data) {
                    let html = '';
                    if (data && data.length > 0) {
                        data.forEach(p => {
                            html += `
                                <div class="dropdown-item d-flex justify-content-between align-items-center product-result-item" 
                                     data-id="${p.id}" data-name="${p.nombre}" data-price="${p.precio}" 
                                     data-stock="${p.cantidad}" data-code="${p.codigo}">
                                    <div>
                                        <span class="result-main">${p.nombre}</span>
                                        <span class="result-sub">${p.codigo} • Stock: ${p.cantidad}</span>
                                    </div>
                                    <div class="result-price text-right">$${p.precio}</div>
                                </div>
                            `;
                        });
                        $('#product-results-dropdown').html(html).show();
                    } else {
                        $('#product-results-dropdown').html('<div class="dropdown-item text-muted text-center py-3">No se encontraron productos</div>').show();
                    }
                }
            });
        }, 200);
    });

    // Handle Selection from dropdown
    $(document).on('click', '.product-result-item', function() {
        const p = $(this).data();
        
        const newProduct = {
            id: p.id,
            name: p.name,
            code: p.code,
            precio: parseFloat(p.price),
            stockQuantity: parseInt(p.stock),
            quantity: 1
        };

        const existing = productList.find(item => item.id == newProduct.id);
        if (existing) {
            if(existing.quantity < existing.stockQuantity) {
                existing.quantity++;
            } else {
                showError('Stock insuficiente para este producto.');
            }
        } else {
            productList.push(newProduct);
        }
        
        $('#product-search-input').val('');
        $('#product-results-dropdown').hide();
        refreshUI();
    });

    // Close dropdown on click outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.position-relative').length) {
            $('#product-results-dropdown').hide();
        }
    });

    // 3. PAYMENT METHODS
    $('.btn-payment-method').on('click', function(e) {
        if($(e.target).closest('input').length) return;
        
        const id = $(this).data('id');
        const name = $(this).data('name');
        const currency = $(this).data('currency');
        const panel = $(this).siblings('.payment-details-panel');
        
        const index = selectedPaymentMethods.findIndex(m => m.id == id);
        if(index > -1) {
            selectedPaymentMethods.splice(index, 1);
            $(this).removeClass('active');
            panel.slideUp(200);
        } else {
            // Calculate current paid amount to find the remainder
            let currentPaidUSD = 0;
            selectedPaymentMethods.forEach(m => {
                if(m.currency == '$') currentPaidUSD += m.monto;
                else currentPaidUSD += (m.monto / tasa);
            });

            let remainingUSD = Math.max(0, totalOrder - currentPaidUSD);
            let autoAmount = (currency == '$') ? remainingUSD : (remainingUSD * tasa);

            selectedPaymentMethods.push({ id, name, currency, monto: autoAmount, ref: '' });
            $(this).addClass('active');
            panel.slideDown(200);
            
            // Pre-fill with the remaining amount
            panel.find('.method-amount-input').val(autoAmount.toFixed(2));
        }
        refreshUI();
    });

    $(document).on('change', '.method-amount-input', function() {
        const id = $(this).data('id');
        const val = parseFloat($(this).val()) || 0;
        const method = selectedPaymentMethods.find(m => m.id == id);
        if(method) method.monto = val;
        refreshUI();
    });

    $(document).on('input', '.method-ref-input', function() {
        const id = $(this).data('id');
        const val = $(this).val();
        const method = selectedPaymentMethods.find(m => m.id == id);
        if(method) method.ref = val;
        updateHiddenInputs();
    });

    // 4. UI REFRESH & CALCULATIONS
    function refreshUI() {
        const table = $('#product-table tbody');
        if(productList.length === 0) {
            $('#empty-state').show();
            $('#product-table-wrapper').hide();
        } else {
            $('#empty-state').hide();
            $('#product-table-wrapper').show();
            
            let html = '';
            totalOrder = 0;
            productList.forEach((p, idx) => {
                const subtotal = p.precio * p.quantity;
                totalOrder += subtotal;
                html += `
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td class="font-weight-bold" style="color: #64748B;">${p.code}</td>
                        <td class="font-weight-bold text-dark">${p.name}</td>
                        <td class="text-center">
                            <input type="number" class="quantity-input" data-idx="${idx}" value="${p.quantity}" min="1" max="${p.stockQuantity}">
                        </td>
                        <td class="text-right font-weight-bold text-dark">$${subtotal.toFixed(2)}</td>
                        <td class="text-center">
                            <button type="button" class="btn-remove-item" data-idx="${idx}"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                `;
            });
            table.html(html);
        }

        let paidUSD = 0;
        selectedPaymentMethods.forEach(m => {
            if(m.currency == '$') paidUSD += m.monto;
            else paidUSD += (m.monto / tasa);
        });

        const balanceUSD = totalOrder - paidUSD;

        $('#total-display').text('$' + totalOrder.toLocaleString('en-US', { minimumFractionDigits: 2 }));
        $('#total-bs-display').text((totalOrder * tasa).toLocaleString('es-VE', { minimumFractionDigits: 2 }) + ' Bs');
        $('#subtotal-display').text(totalOrder.toFixed(2) + ' $');

        if(Math.abs(balanceUSD) > 0.009 && totalOrder > 0) {
            $('#balance-row').attr('style', 'display: flex !important;');
            const label = balanceUSD > 0 ? 'Faltante' : 'Sobrante';
            const colorClass = balanceUSD > 0 ? 'text-danger' : 'text-success';
            $('#balance-label').text(label);
            
            // Show breakdown in both currencies for clarity
            const absBal = Math.abs(balanceUSD);
            const balanceText = '$' + absBal.toFixed(2) + ' / ' + (absBal * tasa).toLocaleString('es-VE', { minimumFractionDigits: 2 }) + ' Bs';
            $('#balance-display').text(balanceText).attr('class', 'font-weight-bold ' + colorClass);
        } else {
            $('#balance-row').attr('style', 'display: none !important;');
        }

        updateHiddenInputs();
    }

    function updateHiddenInputs() {
        let inputs = '';
        productList.forEach((p, i) => {
            inputs += `<input type="hidden" name="plist[${i}][id]" value="${p.id}">`;
            inputs += `<input type="hidden" name="plist[${i}][cantidad]" value="${p.quantity}">`;
        });
        
        selectedPaymentMethods.forEach((m, i) => {
            inputs += `<input type="hidden" name="mlist[${i}][id]" value="${m.id}">`;
            inputs += `<input type="hidden" name="mlist[${i}][monto]" value="${m.monto.toFixed(2)}">`;
            inputs += `<input type="hidden" name="mlist[${i}][ref]" value="${m.ref}">`;
        });
        $('#form-hidden-data').html(inputs);
    }

    // EVENT DELEGATION
    $(document).on('change', '.quantity-input', function() {
        const idx = $(this).data('idx');
        const val = parseInt($(this).val());
        const max = parseInt($(this).attr('max'));
        
        if(val > max) {
            showError('Stock insuficiente.');
            $(this).val(max);
            productList[idx].quantity = max;
        } else if(val < 1) {
            $(this).val(1);
            productList[idx].quantity = 1;
        } else {
            productList[idx].quantity = val;
        }
        refreshUI();
    });

    $(document).on('click', '.btn-remove-item', function() {
        const idx = $(this).data('idx');
        productList.splice(idx, 1);
        refreshUI();
    });

    function showError(msg) {
        $('#err-description').text(msg);
        $('#errorModal').modal('show');
    }

    $('#generateOrderBtn').on('click', function(e) {
        e.preventDefault();
        
        if(productList.length === 0) {
            showError('Añada al menos un producto.');
            return;
        }
        if(!$('#client-id').val()) {
            // Check if we are filling the new client form
            if(!$('#client_nom').val() || !$('#client_ape').val()) {
                showError('Por favor identifique un cliente o complete los datos del nuevo cliente (Nombre y Apellido).');
                return;
            }
        }
        if(selectedPaymentMethods.length === 0) {
            showError('Seleccione al menos un método de pago.');
            return;
        }

        // Verify total balance
        let paidUSD = 0;
        selectedPaymentMethods.forEach(m => {
            if(m.currency == '$') paidUSD += m.monto;
            else paidUSD += (m.monto / tasa);
        });

        if(Math.abs(totalOrder - paidUSD) > 0.05) {
            showError('El total pagado no coincide con el total de la venta. Diferencia: $' + Math.abs(totalOrder - paidUSD).toFixed(2));
            return;
        }
        
        $('#order-form').submit();
    });

});
</script>
@stop
