@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')


@section('content')
<form action="{{ route('client.update',$client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
<br><br>
   <div class="card; card bg-light mb-3;">
         <div class="py-3 px-3 border-bottom d-flex justify-content-between" >
                <h4> Actualizar Datos del Cliente</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('client.customer') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
          </div> 
       <div class="container">
        <div class="form-row">
           <div class="col-md-3 mb-3">
                    <label>Cedula</label>
                    <input type="integer" class="form-control " value="{{ $client->cedula }}" placeholder="Cedula" name="cedula"  required>
             </div>

        <div class="col-md-3 mb-3">
                    <label >Nombres</label>
                    <input type="string" class="form-control " value="{{ $client->nombres }}"  name="nombres" placeholder="Nombres" required>
        </div>
    </div>
   @if ($errors->any())
         <div class="alert alert-danger">
                 <strong>Whoops!</strong> There were some problems with your input.<br><br>
                         <ul>
                        @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                        @endforeach
                                 </ul>
                            </div>
                        @endif
                                
                      

    <div class="form-row">
        <div class="col-md-3 mb-3">
                 <label>Apellidos</label>
                 <input type="string" class="form-control " value="{{ $client->apellidos }}"  name="apellidos" placeholder="Apellidos" required>
       </div> 
                                   
       <div class="col-md-3 mb-3">
                <label >Telefono</label>
                <input type="integer" class="form-control " value="{{ $client->telefono }}" name="telefono"   placeholder="telefono" required>
        </div>
    </div>

    <div class="form-row">
         <div class="col-md-6 mb-3">
                  <label >Dirección</label>
                  <textarea type="text" class="form-control" value="{{ $client->direccion }}"  name="direccion" placeholder="Direccion" required></textarea>
             
         </div>
    </div>  
   
       <div class="py-3 px-3 border-bottom d-flex justify-content-between" >     
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Crear">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"><text> Guardar</text></i></button>
            </span>
      </div>
  </div>
</div>
</form>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> 
//--validacion
<script src="jquery.js"></script>
    <script src="dist/jquery.inputmask.js"></script>
    <script src="dist/bindings/inputmask.binding.js"></script>
    
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

    </script>
@stop
