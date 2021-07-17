@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('plugins.Bootstrapselect', true)
 
@section('content_header')
<div style="text-align:center;">
    <h1>PANEL DE EMPLEADOS</h1>
    </div>
@stop

@section('content')
<div class="card">
  <div class="card-body">
<table class="table">
  <thead>
  <td colspan="4" >Empleados</td>
  <td colspan="1">Asistencia</td>
    <tr>
     
      <th scope="col">No</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Cargo</th>
      <th scope="col">Si  No  Justificado</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Emily luz</td>
      <td>Rojas Martinez</td>
      <td>Vendedora</td>
      <td>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
      
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      </td>
      </tr>
    
    <tr>
      <th scope="row">2</th>
      <td>Maria Alejandra</td>
      <td>villas Marcano</td>
      <td>Vendedora</td>
      <td>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      </td>
      </tr>
    
    <tr>
      <th scope="row">3</th>
      <td>Rosa Angelica</td>
      <td>Ramos Carvajal</td>
      <td>Gerente de Inventario</td>
      <td>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      </td>
      </tr>
    
    <tr>
      <th scope="row">4</th>
      <td>kelly Maria</td>
      <td>Brea Gomez</td>
      <td>Cajera</td>
      <td>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      <div class="form-check"  style = "float: left">
      <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 
      </div>
      </td>
      </tr>
  
  </tbody>
</table>

</div>
</div>
<button type="button" class="btn btn-success"><i class="fa fa-plus"></i>Añadir</button>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop