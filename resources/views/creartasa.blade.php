@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-5 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Tasa del Día</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-coins mr-1"></i> Actualice el valor del dólar para conversiones</p>
                        </div>
                        <a class="btn-premium-return" href="{{ route('listadotasa.index') }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('listadotasa.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="mb-2">
                            <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Valor del Dólar (Bs.)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-exchange-alt text-muted"></i>
                                    </span>
                                </div>
                                <input type="number" step="0.01" name="value" value="{{ old('value') }}" 
                                       class="form-control border-0 bg-light @error('value') is-invalid @enderror" 
                                       placeholder="Ej: 36.50" required style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            @error('value')
                                <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-center">
                        <button type="submit" class="btn btn-block py-3 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 1rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> ACTUALIZAR TASA
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
