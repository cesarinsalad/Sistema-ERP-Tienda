@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <style>
        #prediccion{
            max-height: 400px;
            max-width: 400px;
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
    </div>
    <br><br>
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem; border: 1px solid #E2E8F0;">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4" style="border-radius: 1.25rem 1.25rem 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold" style="color: #334155;">
                    <i class="fas fa-box-open mr-2 text-purple" style="color: #7D266E;"></i> Detalles del Producto
                </h5>
                <a class="btn-premium-return" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <hr class="mt-3 mb-0" style="border-top: 1px dashed #E2E8F0;">
        </div>
        
        <div class="card-body px-4 pb-4 pt-3">
            <div class="row">
                <div class="col-md-6 border-right pr-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Código</p>
                            <h6 class="font-weight-bold text-dark m-0" style="font-size: 1.05rem;">{{ $articulo->codigo }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Nombre</p>
                            <h6 class="font-weight-bold text-dark m-0" style="font-size: 1.05rem;">{{ $articulo->nombre }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Cantidad</p>
                            <span class="badge badge-primary px-3 py-2" style="font-size: 0.95rem; background-color: #EEE1ED; color: #7D266E;">
                                {{ $articulo->cantidad }} Uds.
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Precio</p>
                            <h6 class="font-weight-bold text-success m-0" style="font-size: 1.1rem;">${{ number_format($articulo->precio, 2) }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Marca</p>
                            <h6 class="font-weight-bold text-dark m-0" style="font-size: 1.05rem;">
                                <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px;">
                                    {{ $articulo->brand->name ?? 'N/A' }}
                                </span>
                            </h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Categorías</p>
                            <div class="d-flex flex-wrap" style="gap: 5px;">
                                @foreach ($articulo->category as $category)
                                    <a href="{{route('categories.show', $category->id)}}" class="badge badge-light border px-2 py-1" style="font-size: 0.85rem; color: #475569;">
                                        {{$category->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Descripción</p>
                            <p class="font-weight-normal text-muted m-0" style="font-size: 0.95rem;">{{ $articulo->descripcion ?: 'No hay descripción disponible' }}</p>
                        </div>
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
                    const data = {
                        labels: {!! $comprasPorDia['listaFechas'] !!},
                        datasets: [{
                            label: 'Cantidad Restante',
                            data: {!! $comprasPorDia['cantidadPorDia'] !!},
                            backgroundColor: [
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                                'rgba(119, 185, 229)',
                            ],
                            borderColor: [
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                                'rgba(81, 94, 253)',
                            ],
                            borderWidth: 1
                        }]
                    };
                    //Graficar
                    var ctx = document.getElementById('prediccion').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Predicción de Cantidad Restante para 15 Días'
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: '#Días',
                                        color: '#000',
                                        font: {
                                            family: 'Source Sans Pro',
                                            size: 12,
                                            weight: 'normal'
                                        },
                                        padding: {top: 10, left: 0, right: 0, bottom: 0}
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: '#Cantidad',
                                        color: '#000',
                                        font: {
                                            family: 'Source Sans Pro',
                                            size: 12,
                                            style: 'normal'
                                        },
                                        padding: {top: 0, left: 0, right: 0, bottom: 10}
                                    }
                                }
                            }
                        }
                    });
                })
            </script>
@stop
