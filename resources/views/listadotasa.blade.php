@extends('adminlte::page')
@section('title', 'GIGI FASHION IMPORT')

@section('content')
    <div class="row pt-4">
        <div class="col-md-9 mx-auto">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Historial de Tasas</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-coins mr-1"></i> Control de tasa de cambio (Bs/$)</p>
                        </div>
                        <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('listadotasa.create') }}" 
                           style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                            <i class="fas fa-plus mr-2"></i> AGREGAR NUEVA TASA
                        </a>
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
                                    <th>Valor de la Tasa</th>
                                    <th class="text-right">Fecha de Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exchangerates as $exchangerate)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $exchangerate->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 p-2 bg-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-dollar-sign text-purple"></i>
                                            </div>
                                            <span class="font-weight-bold text-dark" style="font-size: 1.2rem;">
                                                {{ number_format($exchangerate->value, 2, ',', '.') }} <small class="text-muted">Bs/$</small>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="text-muted font-weight-600">{{ $exchangerate->created_at->format('d/m/Y h:i A') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($exchangerates->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $exchangerates->links() !!}
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
