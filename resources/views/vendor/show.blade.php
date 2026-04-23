@extends('adminlte::page')
@section('plugins.Chartjs', true)
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
                    <i class="fas fa-truck mr-2 text-purple"></i> Detalles del Proveedor
                </h5>
                <a class="btn-premium-return" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> REGRESAR</a>
            </div>
            <hr class="mt-3 mb-0" style="border-top: 1px dashed #E2E8F0;">
        </div>

        <div class="card-body px-4 pb-4 pt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Nombre</p>
                    <h6 class="font-weight-bold text-dark m-0" style="font-size: 1.1rem;">{{ $vendor->name }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Documento</p>
                    <h6 class="font-weight-normal text-dark m-0" style="font-size: 1.1rem;">{{ $vendor->type_document }}-{{ $vendor->document }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Email</p>
                    <h6 class="font-weight-normal text-dark m-0" style="font-size: 1.1rem;">{{ $vendor->email ?? 'N/A' }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Teléfono</p>
                    <h6 class="font-weight-normal text-dark m-0" style="font-size: 1.1rem;">{{ $vendor->phone ?? 'N/A' }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <p class="text-muted small font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.05em;">Descripción</p>
                    <h6 class="font-weight-normal text-dark m-0" style="font-size: 1rem; line-height:1.5;">{{ $vendor->description }}</h6>
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
