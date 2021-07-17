@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('plugins.Bootstrapselect', true)
 
@section('content_header')
<div style="text-align:center;">
    <h1>PAGO EMPLEADOS</h1>
    </div>
@stop

@section('content')
<br><br><br><br>
<div class="card" >
  <div class="card-body" >
<table class="table ">

  <thead>
  
    <tr>
   
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Cargo</th>
      <th scope="col">Detalles</th>
      <th scope="col">Pago</th>

    </tr>
  </thead>
  <tbody>
    <tr>
     <td>Emily luz</td>
      <td>Rojas Martinez</td>
      <td>Vendedora</td>
      <td>laboró semana completa</td>
      <td>10$</td>
    </tr>
    <tr>
    <td>Maria Alejandra</td>
      <td>villas Marcano</td>
      <td>Vendedora</td>
      <td>laboró 5 días</td>
      <td>7.15$</td>
      </tr>

      <tr>
      <td>Rosa Angelica</td>
      <td>Ramos Carvajal</td>
      <td>Gerente de Inventario</td>
      <td>laboró semana completa</td>
      <td>15$</td>
      <tr>

      <tr>
      <td>kelly Maria</td>
      <td>Brea Gomez</td>
      <td>Cajera</td>
      <td>laboró semana completa</td>
      <td>20$</td>
      </tr>

  </tbody>
</table>
</div>
</div> 

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop