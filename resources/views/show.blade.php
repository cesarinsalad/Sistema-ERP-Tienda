@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
          
        </div>
    </div>
    <br><br>
    <div class="card; card bg-light mb-3">
     
    <div class="py-3 px-3 border-bottom d-flex justify-content-between" >
        <h4> Detalles del Producto</h4>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
            <a class="btn btn-primary" href="{{ route('articulo.index') }}"><i class="fas fa-arrow-left "></i><text> Regresar</text></a>
        </span>
 </div>
  <div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
           <h5> <div class="form-group">
                <strong>Codigo:</strong>
                {{ $articulo->codigo }}
            </div></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5><div class="form-group">
                <strong>Nombre:</strong>
                {{ $articulo->nombre }}
            </div></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5><div class="form-group">
                <strong>Descripcion:</strong>
                {{ $articulo->descripcion }}
            </div></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5><div class="form-group">
                <strong>Cantidad:</strong>
                {{ $articulo->cantidad }}
            </div></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <h5><div class="form-group">
                <strong>Precio:</strong>
                {{ $articulo->precio }}
           $ </div></h5>
        </div>
        </div>
        </div>
        </div>
        <div class="col-md-6">
            <canvas id="prediccion" width="200" height="200"></canvas>
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
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };
    //Graficar 
    var ctx = document.getElementById('prediccion').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
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
</script>
@stop
