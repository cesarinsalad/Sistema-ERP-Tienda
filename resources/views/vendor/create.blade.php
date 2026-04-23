@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-9 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Agregar Nuevo Proveedor</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-truck mr-1"></i> Registre los datos de contacto y facturación del proveedor</p>
                        </div>
                        <a class="btn-premium-return" href="{{ route('vendors.index') }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Razón Social / Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-building text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="form-control border-0 bg-light @error('name') is-invalid @enderror" 
                                           placeholder="Nombre de la empresa" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('name')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Tipo Doc.</label>
                                <select name="type_document" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px;">
                                    <option value="RIF" {{ old('type_document') == 'RIF' ? 'selected' : '' }}>RIF</option>
                                    <option value="CI" {{ old('type_document') == 'CI' ? 'selected' : '' }}>CI</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Número de Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="document" value="{{ old('document') }}" 
                                           class="form-control border-0 bg-light @error('document') is-invalid @enderror" 
                                           placeholder="Ej: J-12345678-9" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('document')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Teléfono de Contacto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="phone" value="{{ old('phone') }}" 
                                           class="form-control border-0 bg-light @error('phone') is-invalid @enderror" 
                                           placeholder="Ej: 02121234567" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('phone')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Correo Electrónico</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror" 
                                           placeholder="proveedor@empresa.com" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                @error('email')
                                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Descripción / Observaciones</label>
                                <textarea name="description" class="form-control border-0 bg-light" 
                                          placeholder="Breve descripción del proveedor..." rows="3" style="border-radius: 12px;">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> GUARDAR PROVEEDOR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
