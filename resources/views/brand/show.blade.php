@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'TRUCUPEY,C.A.')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
    </div>
    <br><br>
    <div class="card; card mb-3">

        <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <h4> Detalles de la Marca</h4>
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                    <a class="btn btn-primary" href="{{ route('brands.index') }}"><i class="fas fa-arrow-left "></i><text> Regresar</text></a>
                </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>
                            <div class="form-group">
                                <strong>Nombre:</strong>
                                {{ $brand->name }}
                            </div>
                        </h5>
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
