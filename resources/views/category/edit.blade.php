@extends('adminlte::page')

@section('title', 'TRUCUPEY,C.A.')

@section('content')

    <form action="{{ route('categories.update',$category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <br><br>
        <div class="card; card bg-light mb-3;">
            <div class="py-3 px-3 border-bottom d-flex justify-content-between">
                <h4> Actualizar Datos de la categoría</h4>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Regresar">
                <a class="btn btn-primary" href="{{ route('categories.index') }}"><i class="fas fa-arrow-left"><text> Regresar</text></i></a>
                </span>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Nombre</label>
                        <input type="string" value="{{ $category->name }}" class="form-control @error('name') is-invalid @enderror " value="{{ $category->name }}" name="name" placeholder="Nombre" required>
                        @error('name')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Descripción</label>
                        <textarea value="{{ @old('description') }}"
                                  class="form-control @error('descripcion') is-invalid @enderror " name="description"
                                  placeholder="Descripción" required>{{ $category->description }} </textarea>
                        @error('description')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="py-3 px-3 border-bottom d-flex justify-content-between">
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@stop
