@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-9 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: #EEE1ED; color: #7D266E; border-radius: 15px; font-size: 1.5rem;">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Editar Perfil</h3>
                                <p class="text-muted small m-0 mt-1">Empleado: <b>{{ $empleado->user->name ?? 'N/A' }}</b></p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <span class="badge {{ $empleado->is_active ? 'badge-success' : 'badge-danger' }} px-3 py-2" style="border-radius: 8px;">
                                {{ $empleado->is_active ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                            <a class="btn-premium-return" href="{{ url()->previous() }}">
                                <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><small class="font-weight-bold">{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nombre Completo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $empleado->user->name ?? '') }}" 
                                           class="form-control border-0 bg-light" required style="border-radius: 0 10px 10px 0; height: 45px;">
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
                                    <input type="email" name="email" value="{{ old('email', $empleado->user->email ?? '') }}" 
                                           class="form-control border-0 bg-light" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Documento de Identidad</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="document" value="{{ old('document', $empleado->document) }}" 
                                           class="form-control border-0 bg-light" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Teléfono de Contacto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="phone" value="{{ old('phone', $empleado->phone) }}" 
                                           class="form-control border-0 bg-light" style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Cargo / Posición</label>
                                <input type="text" name="position" value="{{ old('position', $empleado->position) }}" 
                                       class="form-control border-0 bg-light" required style="border-radius: 10px; height: 45px;">
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Sueldo Mensual ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-dollar-sign text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.01" name="salary" value="{{ old('salary', $empleado->salary) }}" 
                                           class="form-control border-0 bg-light" required style="border-radius: 0 10px 10px 0; height: 45px;">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nivel de Acceso</label>
                                @php($isSelf = auth()->id() === $empleado->user_id)
                                <select name="role" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px;" required {{ $isSelf || ($empleado->user->role ?? '') === 'super_admin' ? 'disabled' : '' }}>
                                    <option value="empleado" {{ old('role', $empleado->user->role ?? '') === 'empleado' ? 'selected' : '' }}>Empleado</option>
                                    <option value="admin" {{ old('role', $empleado->user->role ?? '') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    @if(($empleado->user->role ?? '') === 'super_admin')
                                        <option value="super_admin" selected>Super Admin</option>
                                    @endif
                                </select>
                                @if($isSelf)
                                    <input type="hidden" name="role" value="{{ $empleado->user->role }}">
                                    <small class="text-muted d-block mt-1"><i class="fas fa-lock mr-1"></i> No puedes cambiar tu propio rol.</small>
                                @endif
                            </div>
                        </div>

                        <div class="mt-2 p-3 bg-light rounded-lg">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isActiveSwitch" name="is_active" {{ $empleado->is_active ? 'checked' : '' }} {{ $isSelf ? 'disabled' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark" for="isActiveSwitch" style="cursor: pointer;">
                                    {{ $empleado->is_active ? 'Empleado Activo (Acceso habilitado)' : 'Empleado Suspendido (Acceso bloqueado)' }}
                                </label>
                            </div>
                            @if($isSelf)
                                <input type="hidden" name="is_active" value="on">
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-save mr-2"></i> ACTUALIZAR PERFIL
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
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #7D266E;
            border-color: #7D266E;
        }
    </style>
@stop
