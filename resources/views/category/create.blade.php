@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-7 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Nueva Categoría</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-folder-plus mr-1"></i> Defina una nueva clasificación para sus productos</p>
                        </div>
                        <a class="btn-premium-return" href="{{ url()->previous() }}">
                            <i class="fas fa-arrow-left mr-2"></i> REGRESAR
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Nombre de la Categoría</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-list text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                       class="form-control border-0 bg-light @error('name') is-invalid @enderror" 
                                       placeholder="Ej: Calzado, Ropa Interior, etc." required style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            @error('name')
                                <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small font-weight-bold text-uppercase" style="letter-spacing: 0.05em;">Descripción Opcional</label>
                            <textarea name="description" class="form-control border-0 bg-light" 
                                      placeholder="Breve descripción de los productos en esta categoría..." rows="4" style="border-radius: 12px;">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-right">
                        <button type="submit" class="btn px-5 py-2 font-weight-bold shadow-sm" 
                                style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-plus mr-2"></i> CREAR CATEGORÍA
                        </button>
                    </div>
                </form>
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
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
