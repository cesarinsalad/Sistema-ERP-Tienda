@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
        </div>
    <br><br>
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem; border: 1px solid #E2E8F0;">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4" style="border-radius: 1.25rem 1.25rem 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold" style="color: #334155;">
                    <i class="fas fa-user-circle mr-2 text-purple" style="color: #7D266E;"></i> Detalles del Cliente
                </h5>
                <a class="btn-premium-return" href="{{ route('client.customer') }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <hr class="mt-3 mb-0" style="border-top: 1px dashed #E2E8F0;">
        </div>
        
        <div class="card-body px-4 pb-4 pt-3">
            <div class="row">
                <div class="col-md-6 border-right pr-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-id-card mr-1"></i> Información General</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Cédula</p>
                            <h6 class="font-weight-bold text-dark m-0">{{ $client->cedula }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Nombre Completo</p>
                            <h6 class="font-weight-bold text-dark m-0">{{ $client->nombres }} {{ $client->apellidos }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Estado</p>
                            @if($client->deleted_at)
                                <span class="badge badge-danger px-3 py-2">Baneado desde: {{ \Carbon\Carbon::parse($client->deleted_at)->format('d/m/Y') }}</span>
                            @else
                                <span class="badge badge-success px-3 py-2">Activo</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Teléfono</p>
                            <h6 class="font-weight-normal text-dark m-0">{{ $client->telefono ?: 'No especificado' }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Dirección</p>
                            <h6 class="font-weight-normal text-dark m-0">{{ $client->direccion ?: 'No especificada' }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-star mr-1"></i> Productos Preferidos</p>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover" id="table-sold-categories" style="border: 1px solid #E2E8F0; border-radius: 0.75rem; overflow: hidden;">
                            <thead style="background: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                <tr>
                                    <th class="text-muted font-weight-bold text-uppercase small" style="letter-spacing: 0.05em;">Producto</th>
                                    <th class="text-muted font-weight-bold text-uppercase small text-center" style="letter-spacing: 0.05em;" width="100px">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($preferedProducts as $product)
                                    <tr>
                                        <td class="align-middle"><a href="{{ route('articulo.show', $product['id']) }}" class="text-primary font-weight-bold">{{ ucfirst($product['name']) }}</a></td>
                                        <td class="align-middle text-center"><span class="badge badge-light px-2 py-1 font-weight-bold" style="font-size: 0.9rem;">{{ $product['total'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No hay historial de compras</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>
@stop
