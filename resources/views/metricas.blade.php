@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <style>
        .graphics{
            max-width: 400px;
            width: 100% !important;
            max-height: 400px;
        }
        .submit-btn{
            float: right;
        }
        .hidden{
            display: none;
        }
    </style>
    <img src="{{asset('imagenes\logo-trucupey.png')}}" class="hidden" id="img-logo" width="64">
    <div class="">
        <div class="d-flex justify-content-between py-2">
            <h2>Metricas</h2>
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="PDF">
                <button onclick="pdf()" class="btn btn-danger"><i class="far fa-file-pdf"></i></button>
            </span>
        </div>
    </div>

    @if (Session::get('errors'))
        <div class="alert alert-danger">
            @foreach($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Opciones</h5>
                    <form action="{{ route('metrics.query') }}" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date-from">Desde:</label>
                                    <input class="form-control" type="date" id="date-from" name="fromDate" value="{{$fromDate}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date-to">Hasta:</label>
                                    <input class="form-control" type="date" id="date-to" name="toDate" value="{{$toDate}}">
                                </div>
                            </div>
                        </div>
                        @csrf
                        <button type="submit" class="btn submit-btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <canvas id="prediccion" width="400" height="400" class="graphics px-4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <canvas id="products" width="400" height="400" class="graphics px-4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <canvas id="ganancia" width="400" height="400" class="graphics px-4"></canvas>
                        </div>
                    </div>
                    <p><b>Ganancia Neta Total:</b> {{$totalGain}}$</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Productos Más Vendidos:</h5>
                    <table class="table table-bordered table-sm " id="table-sold-products">
                        <thead class="thead-dark">
                        <tr>
                            <th width="80px">Producto</th>
                            <th width="80px">Cantidad</th>
                            <th width="80px">Ganancia</th>
                        </tr>
                        </thead>
                        @foreach ($top10Products as $product)
                            <tr>
                                <td><a href="{{ route('articulo.show', $product['id']) }}">{{ ucfirst($product['name']) }}</a></td>
                                <td>{{ $product['total'] }}</td>
                                <td>{{ $product['gain'] }}$</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Categorías Más Vendidas</h5>
                    <table class="table table-bordered table-sm " id="table-sold-categories">
                        <thead class="thead-dark">
                        <tr>
                            <th width="80px">Producto</th>
                            <th width="80px">Cantidad</th>
                            <th width="80px">Ganancia</th>
                        </tr>
                        </thead>
                        @foreach ($top10Categories as $category)
                            <tr>
                                <td><a href="{{ route('categories.show', $category['id']) }}">{{ ucfirst($category['name']) }}</a></td>
                                <td>{{ $category['total'] }}</td>
                                <td>{{ $category['gain'] }}$</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Mejores Clientes</h5>
                    <table class="table table-bordered table-sm " id="table-best-clients">
                        <thead class="thead-dark">
                        <tr>
                            <th width="80px">Nombre</th>
                            <th width="80px">Cantidad</th>
                            <th width="80px">Ganancia</th>
                        </tr>
                        </thead>
                        @foreach ($top10Clients as $client)
                            <tr>
                                <td><a href="{{ route('client.show', $client['id']) }}">{{ ucfirst($client['name']) }}</a></td>
                                <td>{{ $client['total'] }}</td>
                                <td>{{ $client['gain'] }}$</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>



@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop


@section('js')
    <script src="/js/jspdf/dist/jspdf.umd.min.js" defer></script>
    <script src="/js/jspdf/dist/jspdf.plugin.autotable.min.js" defer></script>
    <script>


        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            //-------primer grafico
            let data = {
                labels: {!! $listaFechasOrders !!},
                datasets: [{
                    label: 'Cantidad de ordenes',
                    data: {!! $cantidadPorDiaOrders !!},
                    backgroundColor: [
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',

                    ],
                    borderColor: [
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
                        'rgba(0, 23, 153 )',
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
                            text: 'Cantidad de Ordenes por Día'
                        },
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
                },
            });

            //-------segundo grafico
            data = {
                labels: {!! $listaFechasProducts !!},
                datasets: [{
                    label: 'Cantidad de productos',
                    data: {!! $cantidadPorDiaProducts !!},
                    backgroundColor: [
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                    ],
                    borderColor: [
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                        'rgba(0, 155, 7 )',
                    ],
                    borderWidth: 2
                }]
            };
            //Graficar
            ctx = document.getElementById('products').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Cantidad de Productos Vendidos por Día'
                        },
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
                },
            });

//--------tercer diagrama
            data = {
                labels: {!! $listaFechasWins !!},
                datasets: [{
                    label: 'Ganancia',
                    data: {!! $cantidadPorDiaWins !!},
                    backgroundColor: [
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                        'rgba(250, 68, 0 )',
                    ],
                    borderColor: [
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                        'rgba250, 68, 0 )',
                    ],
                    borderWidth: 1
                }]
            };
            //Graficar
            ctx = document.getElementById('ganancia').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Cantidad de Ingresos por Día'
                        },
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
                },
            });
        })

        function pdf() {
            const {jsPDF} = window.jspdf
            let graphics = document.querySelectorAll('.graphics');
            const doc = new jsPDF('mm');
            var x = 30;
            var y = 30;
            var from= document.getElementById('date-from').value;
            var to= document.getElementById('date-to').value;
            doc.setFontSize(12);
            doc.text("TRUCUPEY C.A.", x, y);
            let logo = document.querySelectorAll('#img-logo');
            doc.addImage(logo[0], 'PNG', x+120, y-10, 28, 28);
            doc.text("RIF:. J-40855270-1", x, y+=5);
            doc.text("Desde: "+from, x, y+=5);
            doc.text("Hasta: "+to, x, y+=5);
            doc.setFontSize(20);
            doc.text("INFORME", x+55, y+=20);
            doc.setFontSize(12);
            y+=10;
            graphics.forEach((el, i) => {
                const width = (100 / (el.height / el.width))
                doc.addImage(el, 'PNG', x, y, width, 100)
                y =  y + 110;
                if(y > 200){
                    y = 30;
                    doc.addPage()
                }
            })
            y = 135;
            doc.text("Ganancia Neta Total: {{$totalGain}}$", x, y+=5);

            doc.setFontSize(14);
            doc.text("-Productos Más Vendidos:", x, y+=15);
            doc.setFontSize(12);
            doc.autoTable({ html: '#table-sold-products', startY: y += 10});

            y = 30;
            doc.addPage()

            doc.setFontSize(14);
            doc.text("-Categorías Más Vendidas:", x, y+=15);
            doc.setFontSize(12);
            doc.autoTable({ html: '#table-sold-categories', startY: y += 10});

            doc.setFontSize(14);
            doc.text("-Mejores Clientes:", x, y+=100);
            doc.setFontSize(12);
            doc.autoTable({ html: '#table-best-clients', startY: y += 10});
            doc.save()
        }
    </script>
@stop
