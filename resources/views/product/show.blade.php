@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

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
    <div class="card; card mb-3">

        <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <h4> Detalles del Producto</h4>
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                    <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-arrow-left "></i><text> Regresar</text></a>
                </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Codigo:</strong>
                                {{ $articulo->codigo }}
                            </div>
                        </h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Nombre:</strong>
                                {{ $articulo->nombre }}
                            </div>
                        </h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Descripcion:</strong>
                                {{ $articulo->descripcion }}
                            </div>
                        </h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Cantidad:</strong>
                                {{ $articulo->cantidad }}
                            </div>
                        </h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Precio:</strong>
                                {{ $articulo->precio }}
                                $
                            </div>
                        </h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Categorías:</strong>
                                @foreach ($articulo->category as $category)
                                    <a href="{{route('categories.show', $category->id)}}">{{$category->name}}</a>@if($loop->last).@else,@endif
                                @endforeach
                            </div>
                        </h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <canvas id="prediccion" width="200" height="200"></canvas>
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
