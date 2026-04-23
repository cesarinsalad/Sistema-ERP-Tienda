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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Empleados Inactivos</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-archive mr-1"></i> Archivo de personal fuera de servicio</p>
                        </div>
                        <a class="btn-premium-return" href="{{ route('empleados.index') }}">
                            <i class="fas fa-arrow-left mr-2"></i> VOLVER A ACTIVOS
                        </a>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('empleados.inactivos') }}" method="GET" class="form-inline mb-0">
                            <div class="input-group" style="width: 350px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por cédula o nombre..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            <button type="submit" class="btn ml-3 px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                BUSCAR
                            </button>
                            @if(request('search'))
                                <a href="{{ route('empleados.inactivos') }}" class="btn btn-link text-muted ml-2 font-weight-bold">Limpiar</a>
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
                                    <th width="60px">ID</th>
                                    <th>Nombre</th>
                                    <th>Email Acceso</th>
                                    <th>Documento</th>
                                    <th>Cargo</th>
                                    <th>Sueldo</th>
                                    <th width="100px">Estado</th>
                                    <th width="120px" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empleados as $empleado)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $empleado->id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $empleado->user->name ?? 'Usuario N/A' }}</div>
                                    </td>
                                    <td class="text-muted small">{{ $empleado->user->email ?? 'N/A' }}</td>
                                    <td class="font-weight-600 text-purple">{{ $empleado->document }}</td>
                                    <td>
                                        <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px;">
                                            {{ strtoupper($empleado->position) }}
                                        </span>
                                    </td>
                                    <td class="font-weight-bold text-success">${{ number_format($empleado->salary, 2) }}</td>
                                    <td>
                                        <span class="badge badge-danger px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">INACTIVO</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap: 8px;">
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{ route('empleados.edit', $empleado->id) }}"
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-success shadow-sm"
                                                        style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                        data-toggle="tooltip" title="Reactivar">
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
                @if($empleados->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $empleados->links() !!}
                    </div>
                @endif
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
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
