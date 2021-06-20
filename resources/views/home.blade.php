@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

 <!-- @section('plugins.Sweetalert2', true) ventana emergente, te será muy util -->
 

@section('content_header')
    <h1>PANEL DE CONTROL</h1>
@stop

@section('content')
    <p>Bienvenido</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
  /*   Swal.fire(
  'Good job!',
  'You clicked the button!',
  'success'
) */
    </script>
@stop

<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inicio') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Haz iniciado secion!') }}
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
 -->
