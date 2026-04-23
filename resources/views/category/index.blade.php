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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Gestión de Categorías</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-tags mr-1"></i> Organización del catálogo de productos</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <a class="btn-premium-return" href="{{ route('categories.inactivos') }}">
                                <i class="fas fa-archive"></i> VER INACTIVAS
                            </a>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('categories.create') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> AGREGAR CATEGORÍA
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('categories.index') }}" method="GET" class="form-inline mb-0">
                            <div class="input-group" style="width: 350px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar categoría..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            <button type="submit" class="btn ml-3 px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                BUSCAR
                            </button>
                            @if(request('search'))
                                <a href="{{ route('categories.index') }}" class="btn btn-link text-muted ml-2 font-weight-bold">Limpiar</a>
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
                                    <th width="80px">ID</th>
                                    <th>Nombre de Categoría</th>
                                    <th class="text-center">Productos Relacionados</th>
                                    <th width="120px">Estado</th>
                                    <th width="150px" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $category->id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark" style="font-size: 1.05rem;">{{ $category->name }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-2" style="background: #EEE1ED; color: #7D266E; border-radius: 8px; font-weight: 700;">
                                            {{ $category->products_count }} ITEMS
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }} px-2 py-1" style="border-radius: 6px;">
                                            {{ $category->is_active ? 'ACTIVO' : 'INACTIVO' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap: 8px;">
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('categories.show', $category->id) }}" 
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{ route('categories.edit', $category->id) }}"
                                               style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy',$category->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-danger' : 'btn-success' }} shadow-sm"
                                                        style="border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                        data-toggle="tooltip" title="{{ $category->is_active ? 'Desactivar' : 'Reactivar' }}">
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
                @if($categories->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $categories->links() !!}
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
