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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Clientes Inactivos</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-archive mr-1"></i> Directorio de clientes fuera de servicio</p>
                        </div>
                        <a class="btn-premium-return" href="{{ route('client.customer') }}">
                            <i class="fas fa-arrow-left mr-2"></i> VOLVER A ACTIVOS
                        </a>
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
                                        <span class="badge badge-danger px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">INACTIVO</span>
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
