@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <style>
        #basic-detail {
            margin-bottom: 30px;
        }

        #basic-detail > div, #order-detail > div {
            padding: 20px;
        }

        tbody tr:hover {
            background-color: #f8fafc !important;
            border-left: 4px solid #75226d !important;
            transition: all 0.2s ease;
        }
        
        tfoot tr:hover {
            background-color: transparent !important;
        }
    </style>
    <div class="row pt-2">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem; border: 1px solid #E2E8F0;">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4" style="border-radius: 1.25rem 1.25rem 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold" style="color: #334155;">
                    <i class="fas fa-file-invoice-dollar mr-2 text-purple" style="color: #7D266E;"></i> Resumen de Venta
                </h5>
                <a class="btn-premium-return" href="{{ route('listorden.index') }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <hr class="mt-3 mb-0" style="border-top: 1px dashed #E2E8F0;">
        </div>

        <div class="card-body px-4 pb-4 pt-4">
            <div class="row mb-5">
                <!-- Detalle de Orden -->
                <div class="col-md-6 border-right pr-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-receipt mr-1"></i> Detalle de Orden</p>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Número de Orden</p>
                            <span class="badge px-3 py-2" style="font-size: 1rem; background-color: #F8FAFC; color: #334155; border: 1px solid #E2E8F0;">#{{ $order->id }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Fecha de Realización</p>
                            <h6 class="font-weight-normal text-dark m-0">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</h6>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Tasa de Cambio</p>
                            <h6 class="font-weight-bold text-success m-0">{{ number_format($order->tasa->value,2,',','.') }} Bs/$</h6>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Vendedor Asignado</p>
                            @if($order->seller && $order->seller->empleado)
                                <a href="{{ route('empleados.show', $order->seller->empleado->id) }}" class="badge badge-info px-2 py-1" style="text-decoration: none;">
                                    <i class="fas fa-user-tie mr-1"></i> {{ $order->seller->name }}
                                </a>
                            @else
                                <span class="badge badge-secondary px-2 py-1">{{ $order->seller->name ?? 'Desconocido' }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detalle de Cliente -->
                <div class="col-md-6 pl-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-user mr-1"></i> Detalle de Cliente</p>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Nombre del Cliente</p>
                            <h6 class="font-weight-bold m-0">
                                <a href="{{ route('client.show', $order->client->id) }}" style="color: #7D266E; text-decoration: underline;">
                                    {{ $order->client->nombres }} {{$order->client->apellidos}}
                                </a>
                            </h6>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Cédula</p>
                            <h6 class="font-weight-normal text-dark m-0">{{ $order->client->cedula }}</h6>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Teléfono</p>
                            <h6 class="font-weight-normal text-dark m-0">{{ $order->client->telefono }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Listado de Productos -->
                <div class="col-md-6 pr-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-box-open mr-1"></i> Listado de Productos</p>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mb-0" style="border: 1px solid #E2E8F0; border-radius: 0.75rem; overflow: hidden;">
                            <thead style="background: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                <tr>
                                    <th class="text-muted font-weight-bold text-uppercase small" style="letter-spacing: 0.05em;">Producto</th>
                                    <th class="text-muted font-weight-bold text-uppercase small text-center" style="letter-spacing: 0.05em;">Cantidad</th>
                                    <th class="text-muted font-weight-bold text-uppercase small text-right" style="letter-spacing: 0.05em;">Monto (Bs)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td class="align-middle"><a href="{{ route('articulo.show',$product->id) }}" class="text-primary font-weight-bold">{{ $product->nombre }}</a></td>
                                        <td class="align-middle text-center"><span class="badge badge-light px-2 py-1 font-weight-bold" style="font-size: 0.9rem;">{{ $product->pivot->quantity }}</span></td>
                                        <td class="align-middle text-right font-weight-normal">{{ number_format($product->pivot->precio * $order->tasa->value,2,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagos Realizados -->
                <div class="col-md-6 pl-4">
                    <p class="text-purple font-weight-bold small text-uppercase mb-3"><i class="fas fa-money-check-alt mr-1"></i> Pago(s) Realizados</p>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mb-0" style="border: 1px solid #E2E8F0; border-radius: 0.75rem; overflow: hidden;">
                            <thead style="background: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                <tr>
                                    <th class="text-muted font-weight-bold text-uppercase small" style="letter-spacing: 0.05em;">Método de Pago</th>
                                    <th class="text-muted font-weight-bold text-uppercase small text-right" style="letter-spacing: 0.05em;">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->paymentMethods as $pMethod)
                                    <tr>
                                        <td class="align-middle font-weight-bold text-secondary">
                                            {{ $pMethod->nombre_metodo }}
                                            @if(!empty($pMethod->pivot->reference))
                                                <br><span class="text-muted font-weight-normal" style="font-size: 0.8rem;">Ref: {{ $pMethod->pivot->reference }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-right font-weight-bold text-success">
                                            @if($pMethod->moneda == '$')
                                                $&nbsp;{{ number_format($pMethod->pivot->monto_pago_orden,2,',','.') }}
                                            @else
                                                Bs&nbsp;{{ number_format($pMethod->pivot->monto_pago_orden,2,',','.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background: #FAFAFA; border-top: 2px solid #E2E8F0;">
                                <tr>
                                    <td class="font-weight-bold text-right pt-3">TOTAL (Bs):</td>
                                    <td class="font-weight-bold text-right text-dark pt-3" style="font-size: 1.1rem;">{{ number_format($order->monto_orden * $order->tasa->value,2,',','.') }} Bs</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-right pb-3 text-muted">REFERENCIA ($):</td>
                                    <td class="font-weight-bold text-right text-muted pb-3">{{ number_format($order->monto_orden,2,',','.') }} $</td>
                                </tr>
                            </tfoot>
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

    <script>


        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@stop
