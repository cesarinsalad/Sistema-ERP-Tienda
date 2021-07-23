@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <div class="">
        <div class="d-flex justify-content-between py-2">
            <h2>Metricas</h2>
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="PDF">
        <button onclick="pdf()" class="btn btn-danger"><i class="far fa-file-pdf"></i></button>
     </span>
        </div>
        <div class="col-12 col-md-8">
            <div class="d-flex">
                <div class="flex-grow-1 col-12 col-md-6">
                    <canvas id="prediccion" width="200" height="200" class="graphics px-4"></canvas>
                </div>
                <dv class="card" style="width: 40rem;background:#EFF4F4 ">
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de ordenes por dia</h5>
                        <table class="table table-bordered " style="border-color:black;">
                            <thead>
                            <tr>
                                <th scope="col">Eje X</th>
                                <th scope="col">Eje Y</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>El tiempo</td>
                                <td>Cantidad de ordenes efectuadas por día</td>
                            </tbody>
                        </table>

                    </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="d-flex">
            <div class="flex-grow-1 col-12 col-md-6">
                <canvas id="products" width="200" height="200" class="graphics px-4"></canvas>
            </div>

            <div class="card" style="width: 40 rem;background:#EFF4F4  ">
                <div class="card-body">
                    <h5 class="card-title">Cantidad de productos vendidos por dia</h5>

                    <table class="table table-bordered " style="border-color:black;">
                        <thead>
                        <tr>
                            <th scope="col">Eje X</th>
                            <th scope="col">Eje Y</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>El tiempo</td>
                            <td>Cantidad de productos vendidos por día</td>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="d-flex">
            <div class="flex-grow-1 col-12 col-md-6">
                <canvas id="ganancia" width="200" height="200" class="graphics px-4"></canvas>
            </div>
            <div class="card" style="width: 40rem;background:#EFF4F4  ">
                <div class="card-body">
                    <h5 class="card-title">Ganancia Diaria</h5>
                    <table class="table table-bordered " style="border-color:black;">
                        <thead>
                        <tr>
                            <th scope="col">Eje X</th>
                            <th scope="col">Eje Y</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>El tiempo</td>
                            <td>La ganancia día</td>
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
    <script src="/js/jspdf/dist/jspdf.umd.min.js" defer></script>

    <script>


        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            //-------primer grafico
            let data = {
                labels: {!! $listaFechasOrders !!},
                datasets: [{
                    label: 'Cantidad de ordenes por dia',
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
                            text: 'Chart.js Line Chart - Logarithmic'
                        },
                    },
                    scales: {
                        x: {
                            display: true,
                        },
                        y: {
                            display: true,
                            type: 'logarithmic',
                        }
                    }
                },
            });

            //-------segundo grafico
            data = {
                labels: {!! $listaFechasProducts !!},
                datasets: [{
                    label: 'Cantidad de productos vendidos por dia',
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
                            text: 'Chart.js Line Chart - Logarithmic'
                        },
                    },
                    scales: {
                        x: {
                            display: true,
                        },
                        y: {
                            display: true,
                            type: 'logarithmic',
                        }
                    }
                },
            });

//--------tercer diagrama
            data = {
                labels: {!! $listaFechasWins !!},
                datasets: [{
                    label: 'Ganancia Diaria',
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
                            text: 'Chart.js Line Chart - Logarithmic'
                        },
                    },
                    scales: {
                        x: {
                            display: true,
                        },
                        y: {
                            display: true,
                            type: 'logarithmic',
                        }
                    }
                },
            });
        })

        function pdf() {
            const {jsPDF} = window.jspdf
            let graphics = document.querySelectorAll('.graphics');
            const doc = new jsPDF('landscape', 'mm')
            graphics.forEach((el, i) => {
                const width = (150 / (el.height / el.width))
                doc.addImage(el, 'JPEG', 10, 10, width, 150)
                //if(graphics.lenght > (i + 1)){
                //}
                doc.addPage()
            })
            doc.save()
        }

    </script>
@stop
