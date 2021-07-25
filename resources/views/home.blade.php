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

        #resultado-cliente {
            display: none;
        }

        #select-container {
            display: flex;
            align-items: flex-start;
        }

        #select-container2 {
            display: flex;
            align-items: flex-start;
        }

        .dropdown.bootstrap-select {
            width: 85% !important;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        #add-product, #add-orden {
            width: 15%;
        }

        #scroll {
            border: 1px;
            max-height: 300px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        .currency-td > div{
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: 0 .75rem;
        }
        .monto-orden{
            border: none;
        }
        .total-title{
            padding-left: 10px;
            font-weight: bold;
        }
        #generateOrderBtn{
            float: right;
        }
    </style>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="err-description"></p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('home.guardarorden') }}" id="order-form" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h2>1. Identificar Cliente</h2>
                            <br>
                        </div>

                        <div class="input-group mb-3">
                            <input id="busqueda" type="text" name="cedula_name" class="form-control"
                                   placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button id="busqueda_cliente_bttm" class="btn btn-outline-secondary" type="button"><i
                                        class="fa fa-search"></i>Buscar
                                </button>
                            </div>
                        </div>

                        <div id="resultado-cliente">
                            <div class="row">
                                <input id="client-id" name="client_id_name" type="hidden"/>
                                <div class="col-md-6 col-xs-12">
                                    <label for="client-nom">Nombres </label>
                                    <input type="text" value="{{ @old('client_nom') }}" id="client-nom"
                                           name="client_nom"
                                           class="form-control @error('client_nom') is-invalid @enderror " disabled/>
                                    @error('client_nom')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="client-ape">Apellidos</label>
                                    <input type="text" value="{{ @old('client_ape') }}" id="client-ape"
                                           name="client_ape"
                                           class="form-control @error('client_ape') is-invalid @enderror " disabled/>
                                    @error('client_ape')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="client-tel">Teléfono</label>
                                    <input type="text" value="{{ @old('client_tel') }}" id="client-tel"
                                           name="client_tel"
                                           class="form-control @error('client_tel') is-invalid @enderror " disabled/>
                                    @error('client_tel')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="client-dir">Dirección</label>
                                    <textarea value="{{ @old('client_dir') }}" id="client-dir" name="client_dir"
                                              class="form-control @error('client_dir') is-invalid @enderror "
                                              disabled> </textarea>
                                    @error('client_dir')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h2>2. Seleccionar Producto(s)</h2>
                            <br>
                        </div>

                        <div id="select-container">
                            <select class="selectpicker" data-live-search="true" id="product-select">
                                <option data-tokens="">Escriba el Código de Producto Deseado</option>
                            </select>
                            <button id="add-product" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Añadir
                            </button>
                        </div>

                        <div id="scroll">
                            <table class="table" id="product-table">
                                <thead>
                                <tr>
                                    <th scope="col">Cod</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div><p><span class="total-title">Sub-Total: </span> <span id="subtotal-amount">0Bs</span></p></div>
                            <div><p><span class="total-title">Ref: </span> <span id="subtotal-ref">0$</span></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h2>3. Seleccionar Método(s) de Pago</h2>
                            <br>
                        </div>
                        <div id="select-container2">
                            <select class="selectpicker" data-live-search="true" id="payment-select">
                                <option>Elija el Método de Pago</option>
                                @foreach ($paymentMethods as $method)
                                    <option data-currencyCode="{{$method->moneda}}" data-ref="{{$method->ref}}" data-tokens="{{$method->nombre_metodo}}"
                                            value="{{$method->id}}">{{$method->nombre_metodo}}</option>
                                @endforeach
                            </select>
                            <button id="add-orden" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Añadir
                            </button>
                        </div>
                        <table class="table" id="orden-table">
                            <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Referencia (opcional)</th>
                                <th scope="col">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div><p><span class="total-title">Sub-Total: </span> <span id="subtotal-amount-pm">0Bs</span></p></div>
                        <div><p><span class="total-title">Ref: </span> <span id="subtotal-ref-pm">0$</span></p></div>
                        <button type="submit" id="generateOrderBtn" class="btn btn-success">Generar Orden</button>
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


        $(document).ready(function () {
            var _token = '{{ csrf_token() }}';
            var tasa = {{$tasaDolar}};
            var totalOrder = 0;
            var totalMethods = 0;
            $('.selectpicker').selectpicker();   //Cargo todos los registros
            function cargar_datos_cliente(datos) {
                var cedula = $('#busqueda').val();
                $.ajax({
                    url: '{{ route("client.search") }}',
                    method: 'POST',
                    data: {
                        cedula: cedula,
                        _token: _token
                    },
                    success: function (data) {
                        $('#resultado-cliente').show();
                        if (data.client) {
                            if(data.client.deleted_at){
                                $('#errorModal').modal();
                                $('#err-description').html('El cliente se encuentra baneado desde el: <br><i>'+data.client.deleted_at+'</i>');
                                return false;
                            }
                            $('#resultado-cliente .form-control').attr("disabled", true);
                            $('#client-id').val(data.client.id);
                            $('#client-nom').val(data.client.nombres);
                            $('#client-ape').val(data.client.apellidos);
                            $('#client-tel').val(data.client.telefono);
                            $('#client-dir').val(data.client.direccion);
                        } else {
                            $('#errorModal').modal();
                            $('#err-description').html('El cliente no ha sido registrado anteriormente <br> Por favor, regístrelo para poder continuar');
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
                    url: '{{ route("product.search") }}',
                    method: 'POST',
                    data: {
                        codigo: codigo,
                        _token: _token
                    },
                    success: function (data) {
                        if (data) {
                            var newOptions = "";
                            data.forEach((currentValue, index, arr) => {
                                newOptions = newOptions + '<option value="' + currentValue.id + '" data-amount="' + currentValue.precio + '" data-name="' + currentValue.nombre + '" data-stockQuantity="' + currentValue.cantidad + '" data-tokens="' + currentValue.codigo + '">' + currentValue.nombre + '</option>';
                            });
                            $('#product-select').html(newOptions);
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

            $('#busqueda_cliente_bttm').on("click", function () {
                var busqueda = $('#busqueda').val();
                if (busqueda != '') {
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
            Array.prototype.inArray = function (comparer) {
                for (var i = 0; i < this.length; i++) {
                    if (comparer(this[i])) return true;
                }
                return false;
            };
            Array.prototype.pushIfNotExist = function (element, comparer) {
                if (!this.inArray(comparer)) {
                    this.push(element);
                }
            };


//Refrescar tabla de productos
            function refreshProductTable() {
                //console.log(productList);
                var table = $('#product-table tbody');
                var html = "";
                var subtotal = 0;
                //Recorrer listado de productos, para crear una fila en la tabla por cada uno
                productList.forEach((currentValue, index, arr) => {
                    subtotal += parseFloat(currentValue.precio) * parseInt(currentValue.quantity);
                    html = html + '<tr>';
                    html = html + '<th scope="row">' + currentValue.code + '</th>';
                    html = html + '<td>' + currentValue.name + '</td>';
                    html = html + '<td>' +
                        '<input type="hidden" name="plist[' + index + '][id]" value="' + currentValue.id + '" />' +
                        '<input class="form-control quantity-product"  data-id="' + currentValue.id + '" type="number" name="plist[' + index + '][cantidad]"  data-max="' + currentValue.stockQuantity + '" value="' + currentValue.quantity + '" />' +
                        '</td>';
                    html = html + '<td>' + new Intl.NumberFormat().format((currentValue.precio * parseInt(currentValue.quantity))* tasa) + ' Bs </td>';
                    html = html + '<td>' + new Intl.NumberFormat().format(currentValue.precio * parseInt(currentValue.quantity)) + ' $ </td>';
                    html = html + '<td><button data-id="' + currentValue.id + '" class="btn btn-sm btn-danger btn-delete-product"><i class="far fa-trash-alt"></i></button></td>';
                    html = html + '</tr>';
                });
                $('#subtotal-amount').html( new Intl.NumberFormat().format((subtotal * tasa))+' Bs');
                $('#subtotal-ref').html(new Intl.NumberFormat().format(subtotal) +' $');
                totalOrder = subtotal;
                //Insertar el nuevo html en el contenedor, reemplazando el contenido anterior
                table.html(html);
            }

//0Hacer click a añadir producto
            $('#add-product').on("click", function (e) {
                e.preventDefault();
                //Tomar la opcion seleccionada al hacer click en agregar producto
                var selectedProduct = $('#product-select option:selected');
                //Verificar si fue seleccionado un elemento
                if (selectedProduct.length > 0 && typeof selectedProduct.attr('data-name') != "undefined") {
                    //Objeto a añadir al listado de productos
                    var newProduct = {
                        id: selectedProduct.val(),
                        name: selectedProduct.attr('data-name'),
                        code: selectedProduct.attr('data-tokens'),
                        precio: selectedProduct.attr('data-amount'),
                        stockQuantity: selectedProduct.attr('data-stockQuantity'),
                        quantity: 1
                    };
                    //Añade el elemento a la lista, si no se encuentra ahi en este momento
                    productList.pushIfNotExist(newProduct, function (e) {
                        return e.id === newProduct.id;
                    });
                    //Regresca la tabla de productos
                    refreshProductTable();
                }
                return false;
            });
//Eliminar el renglon de productos
            $('body').on('click', '.btn-delete-product', function () {
                //Se toma el id del atributo del boton, que es el mismo del producto
                var id = $(this).attr('data-id');
                //Se recorre el listado
                productList.forEach((currentValue, index, arr) => {
                    //Si el id coincide, el producto es eliminado del listado
                    if (id === currentValue.id) {
                        productList.splice(index, 1);
                    }
                });
                //Se refresca la tabla de productos
                refreshProductTable();
            });

            $('body').on('change', '.quantity-product', function () {
                var id = $(this).attr('data-id');
                var value = parseInt($(this).val());
                var max = parseInt($(this).attr('data-max'));
                var productId = -1;
                productList.forEach((currentValue, index, arr) => {
                    if (id === currentValue.id) {
                        productId = index;
                    }
                });
                if(value <= max && value >= 0){
                    productList[productId].quantity = value;
                }
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
            function refreshOrdenTable() {
                //console.log(ordenList);
                var table = $('#orden-table tbody');
                var html = "";
                var subtotal = 0;
                //Recorrer listado de productos, para crear una fila en la tabla por cada uno
                ordenList.forEach((currentValue, index, arr) => {
                    if(currentValue.currencyCode == "$"){
                        subtotal += currentValue.monto;
                    }else{
                        subtotal += parseFloat(currentValue.monto) / parseFloat(tasa);
                    }
                    html = html + '<tr>';
                    html = html + '<td>' + currentValue.name + '</td>';
                    html = html + '<td class="currency-td"><div><span>'+currentValue.currencyCode+'</span><input type="hidden" name="mlist[' + index + '][id]" value="' + currentValue.id + '" /><input class="form-control monto-orden"  data-id="' + currentValue.id + '" type="number" name="mlist[' + index + '][monto]" value="' + currentValue.monto + '" /></div></td>';
                    if(currentValue.hasRef=='1'){
                        html = html + '<td><input class="form-control input-referencia"  data-id="' + currentValue.id + '" type="text" name="mlist[' + index + '][ref]" value="' + currentValue.ref + '" /></td>';
                    }else{
                        html = html + '<td></td>';
                    }
                    html = html + '<td><button data-id="' + currentValue.id + '" class="btn btn-sm btn-danger btn-delete-orden"><i class="far fa-trash-alt"></i></button></td>';
                    html = html + '</tr>';
                });
                $('#subtotal-amount-pm').html( new Intl.NumberFormat().format((subtotal * tasa))+' Bs');
                $('#subtotal-ref-pm').html(new Intl.NumberFormat().format(subtotal) +' $');
                totalMethods = subtotal;
                //Insertar el nuevo html en el contenedor, reemplazando el contenido anterior
                table.html(html);
            }

//Hacer click a añadir producto
            $('#add-orden').on("click", function (e) {
                e.preventDefault();
                //Tomar la opcion seleccionada al hacer click en agregar producto
                var selectedOrden = $('#payment-select option:selected');
                //Verificar si fue seleccionado un elemento
                if (selectedOrden.length > 0 && typeof selectedOrden.attr('data-tokens') != "undefined") {
                    //Objeto a añadir al listado de productos
                    var newOrden = {
                        id: selectedOrden.val(),
                        name: selectedOrden.attr('data-tokens'),
                        hasRef: selectedOrden.attr('data-ref'),
                        ref: '',
                        currencyCode: selectedOrden.attr('data-currencyCode'),
                        monto: 0
                    };
                    //Añade el elemento a la lista, si no se encuentra ahi en este momento
                    ordenList.pushIfNotExist(newOrden, function (e) {
                        return e.id === newOrden.id;
                    });
                    //Regresca la tabla de productos
                    refreshOrdenTable();
                }
                return false;
            });
    //Eliminar el renglon de productos
            $('body').on('click', '.btn-delete-orden', function () {
                //Se toma el id del atributo del boton, que es el mismo del producto
                var id = $(this).attr('data-id');
                //Se recorre el listado
                ordenList.forEach((currentValue, index, arr) => {
                    //Si el id coincide, el producto es eliminado del listado
                    if (id === currentValue.id) {
                        ordenList.splice(index, 1);
                    }
                });
                //Se refresca la tabla de productos
                refreshOrdenTable();
            });
            $('body').on('change', '.monto-orden', function () {
                var id = $(this).attr('data-id');
                var value = $(this).val();
                var methodId = -1;
                ordenList.forEach((currentValue, index, arr) => {
                    if (id === currentValue.id) {
                        methodId = index;
                    }
                });
                if(parseInt(value)>0){
                    ordenList[methodId].monto = parseInt(value);
                }
                refreshOrdenTable();
            });
            $('body').on('change', '.input-referencia', function () {
                var id = $(this).attr('data-id');
                var value = $(this).val();
                var methodId = -1;
                ordenList.forEach((currentValue, index, arr) => {
                    if (id === currentValue.id) {
                        methodId = index;
                    }
                });
                if(value.length <= 100){
                    ordenList[methodId].ref = value;
                }
                refreshOrdenTable();
            });
            $('#generateOrderBtn').on("click", function (e) {
                e.preventDefault();
                var error = '';
                if($('#client-id').val().length <= 0 &&
                    $('#client-nom').val().length <= 0 &&
                    $('#client-ape').val().length <= 0 &&
                    $('#client-tel').val().length <= 0 &&
                    $('#client-dir').val().length <= 0
                ){
                    error = 'Cliente no seleccionado.';
                }
                if(totalOrder !=  totalMethods){
                    error = 'El monto a pagar debe ser igual al sub-total de productos.';
                }
                if(totalOrder ==  0){
                    error = 'No se han seleccionado productos para la compra.';
                }

                if(error.length>0){
                    $('#errorModal').modal();
                    $('#err-description').html(error);
                    return false;
                }else{
                    $('#order-form').submit();
                }

                return false;
            });


        });

    </script>
@stop

