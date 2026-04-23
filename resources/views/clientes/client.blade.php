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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Directorio de Clientes</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-users mr-1"></i> Base de datos de clientes y contactos registrados</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <a class="btn-premium-return" href="{{ route('client.inactivos') }}">
                                <i class="fas fa-archive"></i> VER INACTIVOS
                            </a>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('client.create') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> CREAR CLIENTE
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('client.customer') }}" method="GET" class="form-inline mb-0">
                            <div class="input-group" style="width: 450px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por cédula, nombre o apellido..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            <button type="submit" class="btn ml-3 px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                BUSCAR
                            </button>
                            @if(request('search'))
                                <a href="{{ route('client.customer') }}" class="btn btn-link text-muted ml-2 font-weight-bold">Limpiar</a>
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
                                    <th>Cédula</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th width="100px">Estado</th>
                                    <th width="150px" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ ++$i }}</td>
                                    <td class="font-weight-600 text-purple">{{ $client->cedula }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $client->nombres }} {{ $client->apellidos }}</div>
                                    </td>
                                    <td class="text-muted font-weight-600">{{ $client->telefono }}</td>
                                    <td>
                                        <span class="badge {{ $client->is_active ? 'badge-success' : 'badge-danger' }} px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">
                                            {{ $client->is_active ? 'ACTIVO' : 'INACTIVO' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap: 8px;">
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('client.show',$client->id) }}" 
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Perfil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{ route('client.edit',$client->id) }}"
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('client.destroy',$client->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm {{ $client->is_active ? 'btn-danger' : 'btn-success' }} shadow-sm"
                                                        style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                        data-toggle="tooltip" title="{{ $client->is_active ? 'Desactivar' : 'Reactivar' }}">
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
                @if($clients->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $clients->links() !!}
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
