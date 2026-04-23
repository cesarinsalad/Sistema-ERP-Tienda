@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-11 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Productos Inactivos</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-archive mr-1"></i> Catálogo de artículos fuera de inventario</p>
                        </div>
                        <a class="btn-premium-return" href="{{ route('articulo.index') }}">
                            <i class="fas fa-arrow-left mr-2"></i> VOLVER A ACTIVOS
                        </a>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('articulo.inactivos') }}" method="GET" class="form-inline mb-0">
                            <div class="input-group" style="width: 350px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por nombre o código..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            <button type="submit" class="btn ml-3 px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                BUSCAR
                            </button>
                            @if(request('search'))
                                <a href="{{ route('articulo.inactivos') }}" class="btn btn-link text-muted ml-2 font-weight-bold">Limpiar</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <i class="fas fa-check-circle mr-2"></i> {{ $message }}
                </div>
            @endif

            {{-- Table Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th width="60px">No</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-right">Precio (Bs)</th>
                                    <th class="text-right">Precio ($)</th>
                                    <th>Marca</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articulos as $articulo)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ ++$i }}</td>
                                    <td class="font-weight-600 text-purple">{{ $articulo->codigo }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $articulo->nombre }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px; font-weight: 700;">
                                            {{ $articulo->cantidad }}
                                        </span>
                                    </td>
                                    <td class="text-right font-weight-bold">{{ number_format((floatval($articulo->precio) * floatval($tasaDolar)), 2, ',', '.') }}Bs</td>
                                    <td class="text-right font-weight-bold text-danger">${{ number_format($articulo->precio, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="text-muted small font-weight-bold text-uppercase">{{ $articulo->brand->name }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap: 8px;">
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('articulo.show', $articulo->id) }}" 
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{ route('articulo.edit', $articulo->id) }}"
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('articulo.destroy', $articulo->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-success shadow-sm"
                                                        style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                        data-toggle="tooltip" title="Reactivar">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($articulos->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $articulos->links() !!}
                    </div>
                @endif
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
