@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'GIGI FASHION IMPORT')

@section('content')
<div class="row pt-4">
    <div class="col-md-11 mx-auto">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="font-weight-bold text-dark mb-1 text-uppercase">{{ $empleado->user->name ?? 'Empleado' }}</h2>
                <span class="badge px-3 py-2 text-white" style="background: #7D266E; border-radius: 8px; font-size: 0.9rem; font-weight: 600; letter-spacing: 0.05em;">
                    {{ strtoupper($empleado->position) }}
                </span>
                <span class="badge {{ $empleado->is_active ? 'badge-success' : 'badge-danger' }} px-3 py-2 ml-2" style="border-radius: 8px; font-size: 0.9rem;">
                    {{ $empleado->is_active ? 'ACTIVO' : 'INACTIVO' }}
                </span>
            </div>
            <div class="d-flex gap-2" style="gap: 12px;">
                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn-premium-edit">
                    <i class="fas fa-edit mr-1"></i> EDITAR PERFIL
                </a>
                <a href="{{ route('empleados.index') }}" class="btn-premium-return">
                    <i class="fas fa-arrow-left mr-1"></i> VOLVER
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Main Info and Metrics Panel --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 1.25rem;">
                    <div class="card-header bg-white pt-4 pb-0 border-bottom-0">
                        <h5 class="font-weight-bold text-muted small text-uppercase" style="letter-spacing: 0.1em;">Detalles y Rendimiento</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            {{-- Info --}}
                            <div class="col-md-6 border-right">
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1">Email de Acceso</label>
                                    <p class="h6 font-weight-600 text-dark">{{ $empleado->user->email ?? 'Sin correo' }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1">Cédula / ID</label>
                                    <p class="h6 font-weight-600 text-dark">{{ $empleado->document }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1">Teléfono</label>
                                    <p class="h6 font-weight-600 text-dark">{{ $empleado->phone ?: 'No registrado' }}</p>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1">Sueldo Base</label>
                                    <p class="h5 font-weight-bold text-success">${{ number_format($empleado->salary, 2) }}</p>
                                </div>
                            </div>
                            {{-- Metrics --}}
                            <div class="col-md-6 pl-md-4">
                                <div class="metric-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted small font-weight-bold text-uppercase">Ventas Totales</span>
                                        <span class="h5 font-weight-bold text-purple m-0">{{ $totalSalesCount }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 10px;">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 100%; background-color: #7D266E;"></div>
                                    </div>
                                </div>
                                <div class="metric-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted small font-weight-bold text-uppercase">Monto Generado</span>
                                        <span class="h5 font-weight-bold text-success m-0">${{ number_format($totalSalesAmount, 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="metric-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted small font-weight-bold text-uppercase">Ticket Promedio</span>
                                        <span class="h5 font-weight-bold text-info m-0">${{ $totalSalesCount > 0 ? number_format($totalSalesAmount / $totalSalesCount, 2) : '0.00' }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-top">
                                    <p class="small text-muted mb-0">
                                        <i class="fas fa-info-circle mr-1"></i> Rendimiento basado en el historial completo de ventas del empleado en el sistema.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Performance Chart --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 1.25rem;">
                    <div class="card-header bg-white pt-4 pb-0 border-bottom-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold text-muted small text-uppercase m-0" style="letter-spacing: 0.1em;">Evolución de Ventas ($)</h5>
                            <form action="{{ route('empleados.show', $empleado->id) }}" method="GET" id="chartFilterForm">
                                <select name="chart_filter" class="form-control form-control-sm border-0 bg-light font-weight-bold text-purple" style="border-radius: 8px; width: auto;" onchange="this.form.submit()">
                                    <option value="thisweek" {{ $filter == 'thisweek' ? 'selected' : '' }}>Esta semana</option>
                                    <option value="lastmonth" {{ $filter == 'lastmonth' ? 'selected' : '' }}>Último mes</option>
                                    <option value="3months" {{ $filter == '3months' ? 'selected' : '' }}>Últimos 3 meses</option>
                                    <option value="6months" {{ $filter == '6months' ? 'selected' : '' }}>Últimos 6 meses</option>
                                    <option value="12months" {{ $filter == '12months' ? 'selected' : '' }}>Últimos 12 meses</option>
                                    <option value="thisyear" {{ $filter == 'thisyear' ? 'selected' : '' }}>Año actual</option>
                                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Todo el tiempo</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <p class="text-muted small mb-3"><i class="fas fa-calendar-check mr-1"></i> Mostrando: <span class="font-weight-bold text-dark">{{ $periodLabel }}</span></p>
                        <div style="height: 220px;">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Sales Table --}}
        <div class="card shadow-sm border-0" style="border-radius: 1.25rem;">
            <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
                <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-history mr-2 text-purple"></i> Historial de Ventas</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-top-0 px-4 text-muted small font-weight-bold text-uppercase">Orden #</th>
                                <th class="border-top-0 text-muted small font-weight-bold text-uppercase">Cliente</th>
                                <th class="border-top-0 text-muted small font-weight-bold text-uppercase">Fecha</th>
                                <th class="border-top-0 text-muted small font-weight-bold text-uppercase text-right">Monto ($)</th>
                                <th class="border-top-0 text-muted small font-weight-bold text-uppercase text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas as $venta)
                                <tr>
                                    <td class="px-4 font-weight-bold text-purple">#{{ $venta->id }}</td>
                                    <td>
                                        <span class="font-weight-600">{{ $venta->client->nombres ?? 'Cliente' }} {{ $venta->client->apellidos ?? '' }}</span>
                                    </td>
                                    <td class="text-muted">{{ $venta->created_at->format('d/m/Y h:i A') }}</td>
                                    <td class="text-right font-weight-bold text-dark">${{ number_format($venta->monto_orden, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('listorden.show', $venta->id) }}" class="btn btn-sm btn-outline-info px-3" style="border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-eye mr-1"></i> VER
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-receipt fa-3x mb-3 opacity-2"></i>
                                        <p class="mb-0">Sin registros de ventas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($ventas->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {!! $ventas->links() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .text-purple { color: #7D266E !important; }
        .bg-purple { background-color: #7D266E !important; }
        .font-weight-600 { font-weight: 600; }
        .table td { vertical-align: middle; padding: 1rem 0.75rem; }
        
        .btn-premium-edit {
            background-color: #FDF4FB !important;
            color: #7D266E !important;
            border-radius: 50rem !important;
            font-size: 14px !important;
            padding: 0.5rem 1.5rem !important;
            border: 1px solid #7D266E !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            transition: all 0.2s ease-in-out !important;
            text-decoration: none !important;
        }
        .btn-premium-edit:hover {
            background-color: #7D266E !important;
            color: white !important;
        }
    </style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Ventas Mensuales ($)',
                    data: @json($data),
                    borderColor: '#7D266E',
                    backgroundColor: 'rgba(125, 38, 110, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#7D266E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: {
                            callback: function(value) { return '$' + value; },
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@stop
