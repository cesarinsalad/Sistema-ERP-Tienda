@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-8 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Registrar Nuevo Cliente</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-user-plus mr-1"></i> Ingrese la información del cliente para el sistema</p>
                        </div>
                        <a class="btn-premium-return" href="{{ url()->previous() }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('client.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Cédula / Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="cedula" value="{{ old('cedula') }}" 
                                           class="form-control border-0 bg-light @error('cedula') is-invalid @enderror" 
                                           placeholder="Ej: 12345678" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('cedula')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Teléfono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}" 
                                           class="form-control border-0 bg-light @error('telefono') is-invalid @enderror" 
                                           placeholder="Ej: 04121234567" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('telefono')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nombres</label>
                                <input type="text" name="nombres" value="{{ old('nombres') }}" 
                                       class="form-control border-0 bg-light @error('nombres') is-invalid @enderror" 
                                       placeholder="Nombres del cliente" required style="border-radius: 10px; height: 45px;">
                                @error('nombres')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Apellidos</label>
                                <input type="text" name="apellidos" value="{{ old('apellidos') }}" 
                                       class="form-control border-0 bg-light @error('apellidos') is-invalid @enderror" 
                                       placeholder="Apellidos del cliente" required style="border-radius: 10px; height: 45px;">
                                @error('apellidos')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Dirección de Habitación</label>
                                <textarea name="direccion" class="form-control border-0 bg-light @error('direccion') is-invalid @enderror" 
                                          placeholder="Dirección completa..." required rows="3" style="border-radius: 12px;">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> GUARDAR CLIENTE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Error Modal (Premium Aesthetic) --}}
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
                <div class="modal-body text-center p-5">
                    <div class="warning-icon-container mb-4">
                        <div class="warning-icon-bg">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <h3 class="font-weight-bold mb-3" style="color: #1E293B;">Documento Duplicado</h3>
                    <p id="error-message" class="text-muted mb-4" style="font-size: 1.1rem;">
                        {{ session('error') }}
                    </p>
                    <button type="button" class="btn btn-block py-3 font-weight-bold" data-dismiss="modal" 
                            style="background: #7D266E; color: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);">
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
        .warning-icon-container { display: flex; justify-content: center; }
        .warning-icon-bg {
            width: 80px; height: 80px; background: #FEF3C7; color: #D97706;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; animation: pulseWarning 2s infinite;
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
        $(function () {
            @if(session('error'))
                $('#errorModal').modal('show');
            @endif
        });
    </script>
@stop
