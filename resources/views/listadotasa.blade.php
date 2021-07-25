@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

<style>
    tr:hover {background-color:#FFC3D0;}
</style>

    <div class="row">
        <div class="col-lg-12 margin-tb">

        </div>
    </div>
            <br>
            <div class="card; card mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between" >
                <h4> Lista de Tasas</h4>

                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"  title="Agregar Nueva Tasa">
             <a class="btn btn-success" href="{{ route('listadotasa.create') }}" style="position:relative;"><i class="fas fa-plus"><text> Agregar Tasas</text></i></a>
            </span>
</div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card-body">
    <div class="row">
     <table class="table table-bordered table-sm ">
         <thead class="thead-dark">
            <tr>
                <th width="30px">Nr</th>
                <th width="45px">Valor</th>
                <th width="35px">Fecha</th>
            </tr>
         </thead>
        @foreach ($exchangerates as $exchangerate)
        <tr>
            <td>{{ $exchangerate->id }}</td>
            <td>{{ number_format($exchangerate->value,2,',','.') }}</td>
            <td>{{ $exchangerate->created_at }}</td>
        </tr>
        @endforeach
    </table>
    <div class="pagination-container">
        {!! $exchangerates->links() !!}
    </div>
</div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>


 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@stop

