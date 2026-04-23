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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Registrar Nuevo Empleado</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-user-tie mr-1"></i> Cree el perfil de acceso y datos laborales del personal</p>
                        </div>
                        <a class="btn-premium-return" href="{{ url()->previous() }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nombre Completo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="form-control border-0 bg-light @error('name') is-invalid @enderror" 
                                           placeholder="Ej: Maria Gonzalez" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Correo Electrónico (Acceso)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror" 
                                           placeholder="maria@gigifashion.com" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Cédula de Identidad</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="document" value="{{ old('document') }}" 
                                           class="form-control border-0 bg-light @error('document') is-invalid @enderror" 
                                           placeholder="Ej: V-25123456" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                                <small class="text-muted mt-2 d-block px-1"><i class="fas fa-info-circle mr-1"></i> Este documento será la <b>contraseña inicial</b>.</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Teléfono Móvil</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-mobile-alt text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="phone" value="{{ old('phone') }}" 
                                           class="form-control border-0 bg-light @error('phone') is-invalid @enderror" 
                                           placeholder="Ej: 0412-1234567" style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Cargo / Posición</label>
                                <input type="text" name="position" value="{{ old('position') }}" 
                                       class="form-control border-0 bg-light @error('position') is-invalid @enderror" 
                                       placeholder="Ej: Cajera" required style="border-radius: 10px; height: 45px;">
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Sueldo Mensual ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-dollar-sign text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" 
                                           class="form-control border-0 bg-light @error('salary') is-invalid @enderror" 
                                           placeholder="150.00" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Permisos</label>
                                <select name="role" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px;" required>
                                    <option value="empleado">Empleado</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> CREAR PERFIL
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
