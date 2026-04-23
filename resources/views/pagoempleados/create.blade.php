@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')
@section('plugins.Bootstrapselect', true)

@section('content')
    <div class="row pt-4">
        <div class="col-md-7 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Emitir Pago a Empleado</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-hand-holding-usd mr-1"></i> Registro oficial de remuneraciones y honorarios</p>
                        </div>
                        <a class="btn-premium-return" href="{{ url()->previous() }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('pagoempleados.store') }}" method="POST" id="paymentForm">
                    @csrf
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Seleccione el Empleado</label>
                            <select name="empleado_id" class="form-control selectpicker border-0 bg-light" required id="empleadoSelect" data-live-search="true" title="Buscar empleado...">
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id }}" data-salary="{{ $empleado->salary }}" data-tokens="{{ $empleado->user->name ?? '' }} {{ $empleado->document }}">
                                        {{ $empleado->user->name ?? 'Desconocido' }} ({{ $empleado->document }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Monto a Pagar ($)</label>
                                <div class="d-flex align-items-center">
                                    <div class="input-group" style="flex: 1;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                                <i class="fas fa-dollar-sign text-muted"></i>
                                            </span>
                                        </div>
                                        <input type="number" step="0.01" name="amount" id="amountInput" class="form-control border-0 bg-light" 
                                               placeholder="0.00" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                    </div>
                                    <button class="btn ml-2 d-flex align-items-center justify-content-center" type="button" id="btnSueldoBase" 
                                            title="Usar sueldo base" style="border-radius: 10px; background: #EEE1ED; color: #7D266E; height: 45px; width: 45px; flex-shrink: 0;">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Fecha de Operación</label>
                                <input type="date" name="payment_date" class="form-control border-0 bg-light" 
                                       value="{{ date('Y-m-d') }}" required style="border-radius: 10px; height: 45px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Método de Pago</label>
                                <select name="payment_method" id="payment_method" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px;" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Pago Movil">Pago Móvil</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4" id="reference_group" style="display: none;">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Referencia / Nro. Confirmación</label>
                                <input type="text" name="reference" id="referenceInput" class="form-control border-0 bg-light" 
                                       placeholder="Nro. de referencia" style="border-radius: 10px; height: 45px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-check-circle mr-2"></i> REGISTRAR PAGO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Premium Warning Modal --}}
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
                <div class="modal-body text-center p-5">
                    <div class="warning-icon-container mb-4">
                        <div class="warning-icon-bg">
                            <i class="fas fa-exclamation" style="font-size: 3.5rem;"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bold mb-3" style="color: #1E293B;">Atención</h2>
                    <p id="warning-message" class="text-muted mb-4" style="font-size: 1.15rem;"></p>
                    <button type="button" class="btn btn-block py-3 font-weight-bold" data-dismiss="modal" 
                            style="background: #7D266E; color: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2); font-size: 1.1rem; text-transform: uppercase;">
                        ENTENDIDO
                    </button>
                </div>
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
        }
        .warning-icon-container { display: flex; justify-content: center; }
        .warning-icon-bg {
            width: 100px; height: 100px; background: #FEF3C7; color: #D97706;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            animation: pulseWarning 2s infinite;
        }
        @keyframes pulseWarning {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(217, 119, 6, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
        }
    </style>
@stop

@section('js')
    <script>
        $(function() {
            $('.selectpicker').selectpicker();

            // Error reporting
            @if($errors->any())
                let errors = '';
                @foreach($errors->all() as $error)
                    errors += '{{ $error }}\n';
                @endforeach
                $('#warning-message').text(errors);
                $('#warningModal').modal('show');
            @endif

            // Autofill salary
            $('#btnSueldoBase').on('click', function() {
                const salary = $('#empleadoSelect').find(':selected').data('salary');
                if (salary) $('#amountInput').val(salary);
                else {
                    $('#warning-message').text('Seleccione un empleado para cargar su sueldo.');
                    $('#warningModal').modal('show');
                }
            });

            // Payment logic
            $('#payment_method').on('change', function() {
                if($(this).val() === 'Efectivo') $('#reference_group').hide();
                else $('#reference_group').show();
            }).trigger('change');

            $('#paymentForm').on('submit', function(e) {
                if(!$('#empleadoSelect').val() || !$('#amountInput').val()) {
                    e.preventDefault();
                    $('#warning-message').text('Por favor complete todos los campos obligatorios.');
                    $('#warningModal').modal('show');
                }
            });
        });
    </script>
@stop
