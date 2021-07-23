@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('plugins.Bootstrapselect', true)

@section('content_header')
<div style="text-align:center;">
    <h1>PANEL DE VENTAS</h1>
    </div>
@stop

@section('content')
<script src="/js/jspdf/dist/jspdf.es.min.js" defer></script>
<style>

  #resultado-cliente{
	display: none;
  }
  #select-container{
	display: flex;
    align-items: flex-start;
  }
  #select-container2{
	display: flex;
    align-items: flex-start;
  }
  .dropdown.bootstrap-select{
	  width: 85% !important;
	  border-radius: 5px;
      border: 1px solid #ced4da;
  }
  #add-product{
	width: 15%;
  }
  #scroll{
        border:1px ;
        height:150px;
        /* width:700px; */
        overflow-y:scroll;
        overflow-x:hidden;
    }
</style>



<form action="{{ route('home.guardarorden') }}" method="POST">
	@csrf
<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="card">
			<div class="card-body">
				<div>
					<h2>Cliente</h2>
					<br>
				</div>

		 <div class="input-group mb-3">
				<input id="busqueda" type="text" name="cedula_name" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button id="busqueda_cliente_bttm" class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i>Buscar</button>
				</div>
			</div>

				<div id="resultado-cliente">
					<div class="row">
						<input id="client-id" name="client_id_name" type="hidden" />
						<div class="col-md-6 col-xs-12">
							<label for="client-nom">Nombres </label>
							<input type="text" value="{{ @old('client_nom') }}" id="client-nom" name="client_nom" class="form-control @error('client_nom') is-invalid @enderror " disabled />
                            @error('client_nom')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
						<div class="col-md-6 col-xs-12">
							<label for="client-ape">Apellidos</label>
							<input type="text" value="{{ @old('client_ape') }}" id="client-ape" name="client_ape" class="form-control @error('client_ape') is-invalid @enderror " disabled />
                            @error('client_ape')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
						<div class="col-md-6 col-xs-12">
							<label for="client-tel">Teléfono</label>
							<input type="text" value="{{ @old('client_tel') }}" id="client-tel" name="client_tel" class="form-control @error('client_tel') is-invalid @enderror " disabled />
                            @error('client_tel')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
						<div class="col-md-6 col-xs-12">
							<label for="client-dir">Dirección</label>
							<textarea  value="{{ @old('client_dir') }}" id="client-dir" name="client_dir" class="form-control @error('client_dir') is-invalid @enderror " disabled > </textarea>
                            @error('client_dir')
                            <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="card">
			<div class="card-body">
				<div>
					<h2>Productos</h2>
					<br>
				</div>

				<div id="select-container">
					<select class="selectpicker" data-live-search="true" id="product-select">
						<option data-tokens="">Escriba el Código de Producto Deseado</option>
					</select>
					<button id="add-product" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Añadir</button>
				</div>

                <div id="scroll">
				<table class="table" id="product-table">
					<thead>
						<tr>
							<th scope="col">Cod</th>
							<th scope="col">Nombre</th>
							<th scope="col">Cantidad</th>
							<th scope="col">Monto</th>
							<th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>


 <div class="row">
 <div class="col-md-6 col-xs-12">
		<div class="card">
			<div class="card-body">
				<div>
					<h2>Seleccionar Método de Pago</h2>
					<br>
				</div>
				<div id="select-container2">
					<select class="selectpicker" data-live-search="true" id="payment-select">
					<option>Elija el  Método de Pago</option>
						@foreach ($paymentMethods as $method)
							<option data-tokens="{{$method->nombre_metodo}}" value="{{$method->id}}">{{$method->nombre_metodo}}</option>
						@endforeach
					</select>
					<button id="add-orden" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Añadir</button>
				</div>
				<table class="table" id="orden-table">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Monto</th>
							<th scope="col">Acción</th>
						</tr>
					    </thead>
					   <tbody>
					</tbody>
				</table>
			</div>
		</div>

</div>

<div class="col-md-6 col-xs-12">
		<div class="card" >
		<div class="card-body" >
		<button type="submit" class="btn btn-success">Generar Orden</button>
		</div>
		</div>
		</div>
      </div>
    </div>



</div>
</div>
</form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>


$(document).ready(function() {
	var _token = '{{ csrf_token() }}';

	$('.selectpicker').selectpicker();   //Cargo todos los registros
	function cargar_datos_cliente(datos) {
		var cedula = $('#busqueda').val();
		$.ajax({
			url:'{{ route("client.search") }}',
			method:'POST',
			data:{
				cedula: cedula,
				_token: _token
			},
			success:function(data)
			{
				$('#resultado-cliente').show();
				if(data.client){
					$('#resultado-cliente .form-control').attr("disabled", true);
					$('#client-id').val(data.client.id);
					$('#client-nom').val(data.client.nombres);
					$('#client-ape').val(data.client.apellidos);
					$('#client-tel').val(data.client.telefono);
					$('#client-dir').val(data.client.direccion);
				}else{
					$('#resultado-cliente .form-control').attr("disabled", false);
					$('#client-id').val('');
					$('#client-nom').val('');
					$('#client-ape').val('');
					$('#client-tel').val('');
					$('#client-dir').val('');

				}
			}
		});
	}
	function cargar_datos_productos(codigo) {
		$.ajax({
			url:'{{ route("product.search") }}',
			method:'POST',
			data:{
				codigo: codigo,
				_token: _token
			},
			success:function(data)
			{
				if(data){
					var newOptions = "";
					data.forEach((currentValue, index, arr)=>{
						newOptions = newOptions + '<option value="'+currentValue.id+'" data-amount="'+currentValue.precio+'" data-name="'+currentValue.nombre+'" data-tokens="'+currentValue.codigo+'">'+currentValue.nombre+'</option>';
					});
					$('#product-select').html(newOptions);
				}
				$('.selectpicker').selectpicker('refresh');
			}
		});
	}

$('#busqueda_cliente_bttm').on( "click", function() {
	var busqueda = $('#busqueda').val();
	if (busqueda !='') {
		cargar_datos_cliente(busqueda);
	}
});

$(document).on('keyup', '#select-container .bs-searchbox input', function (e) {
    var searchData = e.target.value;
    cargar_datos_productos(searchData);
});

//Tabla de Productos
//Listado de productos
var productList = [];
Array.prototype.inArray = function(comparer) {
    for(var i=0; i < this.length; i++) {
        if(comparer(this[i])) return true;
    }
    return false;
};
Array.prototype.pushIfNotExist = function(element, comparer) {
    if (!this.inArray(comparer)) {
        this.push(element);
    }
};
//Refrescar tabla de productos
function refreshProductTable(){
	console.log(productList);
	var table = $('#product-table tbody');
	var html = "";
	//Recorrer listado de productos, para crear una fila en la tabla por cada uno
	productList.forEach((currentValue, index, arr)=>{
		html = html + '<tr>';
		html = html + '<th scope="row">' + currentValue.code + '</th>';
		html = html + '<td>' + currentValue.name + '</td>';
		html = html + '<td><input type="hidden" name="plist['+index+'][id]" value="' + currentValue.id + '" /><input class="form-control quantity-product"  data-id="' + currentValue.id + '" type="number" name="plist['+index+'][cantidad]" value="' + currentValue.quantity + '" /></td>';
		html = html + '<td>'+ (currentValue.precio * parseInt(currentValue.quantity)) +'$ </td>';
		html = html + '<td><button data-id="' + currentValue.id + '" class="btn btn-sm btn-danger btn-delete-product"><i class="far fa-trash-alt"></i></button></td>';
		html = html + '</tr>';
	});
	//Insertar el nuevo html en el contenedor, reemplazando el contenido anterior
	table.html(html);
}
//0Hacer click a añadir producto
$('#add-product').on( "click", function(e) {
	e.preventDefault();
	//Tomar la opcion seleccionada al hacer click en agregar producto
	var selectedProduct =  $('#product-select option:selected');
	//Verificar si fue seleccionado un elemento
	if (selectedProduct.length > 0 && typeof selectedProduct.attr('data-name') != "undefined"){
		//Objeto a añadir al listado de productos
		var newProduct = {
			id: selectedProduct.val(),
			name: selectedProduct.attr('data-name'),
			code: selectedProduct.attr('data-tokens'),
			precio: selectedProduct.attr('data-amount'),
			quantity: 1
		};
		//Añade el elemento a la lista, si no se encuentra ahi en este momento
		productList.pushIfNotExist(newProduct, function(e) {
			return e.id === newProduct.id;
		});
		//Regresca la tabla de productos
		refreshProductTable();
	}
	return false;
});
//Eliminar el renglon de productos
$('body').on('click', '.btn-delete-product', function() {
	//Se toma el id del atributo del boton, que es el mismo del producto
	var id = $(this).attr('data-id');
	//Se recorre el listado
    productList.forEach((currentValue, index, arr)=>{
		//Si el id coincide, el producto es eliminado del listado
		if(id === currentValue.id){
			productList.splice(index, 1);
		}
	});
	//Se refresca la tabla de productos
	refreshProductTable();
});

$('body').on('change', '.quantity-product', function() {
	var id = $(this).attr('data-id');
	var value = $(this).val();
	var productId = -1;
    productList.forEach((currentValue, index, arr)=>{
		if(id === currentValue.id){
			productId = index;
		}
	});
	productList[productId].quantity = parseInt(value);
	refreshProductTable();
});
//.............................AQUI.............AQUI...................AQUI.......................................................................
//................................AQUI.............................AQUI.............................................................................
//..................................AQUI........AQUI..........AQUI.......................................................................................
//........................................AQUI..........AQUI............................................................................................
//............................................  AQUI..................................................................................................

//Tabla de Productos
//Listado de Metodos de Pago
var ordenList = [];
//Refrescar tabla de productos
function refreshOrdenTable(){
	console.log(ordenList);
	var table = $('#orden-table tbody');
	var html = "";
	//Recorrer listado de productos, para crear una fila en la tabla por cada uno
	ordenList.forEach((currentValue, index, arr)=>{
		html = html + '<tr>';
		html = html + '<td>' + currentValue.name + '</td>';
		html = html + '<td><input type="hidden" name="mlist['+index+'][id]" value="' + currentValue.id + '" /><input class="form-control monto-orden"  data-id="' + currentValue.id + '" type="number" name="mlist['+index+'][monto]" value="' + currentValue.monto + '" /></td>';
		html = html + '<td><button data-id="' + currentValue.id + '" class="btn btn-sm btn-danger btn-delete-orden"><i class="far fa-trash-alt"></i></button></td>';
		html = html + '</tr>';
	});
	//Insertar el nuevo html en el contenedor, reemplazando el contenido anterior
	table.html(html);
}
//Hacer click a añadir producto
$('#add-orden').on( "click", function(e) {
	e.preventDefault();
	//Tomar la opcion seleccionada al hacer click en agregar producto
	var selectedOrden =  $('#payment-select option:selected');
	//Verificar si fue seleccionado un elemento
	if (selectedOrden.length > 0  && typeof selectedOrden.attr('data-tokens') != "undefined"){
		//Objeto a añadir al listado de productos
		var newOrden = {
			id: selectedOrden.val(),
			name: selectedOrden.attr('data-tokens'),
			monto: 0
		};
		//Añade el elemento a la lista, si no se encuentra ahi en este momento
		ordenList.pushIfNotExist(newOrden, function(e) {
			return e.id === newOrden.id;
		});
		//Regresca la tabla de productos
		refreshOrdenTable();
	}
	return false;
});
//Eliminar el renglon de productos
$('body').on('click', '.btn-delete-orden', function() {
	//Se toma el id del atributo del boton, que es el mismo del producto
	var id = $(this).attr('data-id');
	//Se recorre el listado
    ordenList.forEach((currentValue, index, arr)=>{
		//Si el id coincide, el producto es eliminado del listado
		if(id === currentValue.id){
			ordenList.splice(index, 1);
		}
	});
	//Se refresca la tabla de productos
	refreshOrdenTable();
});
$('body').on('change', '.monto-orden', function() {
	var id = $(this).attr('data-id');
	var value = $(this).val();
	var methodId = -1;
    ordenList.forEach((currentValue, index, arr)=>{
		if(id === currentValue.id){
			methodId = index;
		}
	});
	ordenList[methodId].monto = parseInt(value);
	refreshProductTable();
});

});

</script>
@stop

