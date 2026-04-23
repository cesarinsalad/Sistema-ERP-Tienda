@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'GIGI FASHION IMPORT')

@section('content')
<style>
    .hidden { display: none; }

    /* KPI Cards */
    .kpi-card {
        border-radius: 16px;
        padding: 1.4rem 1.6rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    }
    .kpi-card .kpi-icon {
        font-size: 2.8rem;
        opacity: 0.18;
        position: absolute;
        right: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
    }
    .kpi-card .kpi-value {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    .kpi-card .kpi-label {
        font-size: 0.82rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    .kpi-orders, .kpi-products, .kpi-revenue  { background: #7D266E; }

    /* Charts */
    .chart-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .chart-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 1rem 1.4rem 0.6rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: #334155;
    }
    .chart-card .card-body { padding: 1rem 1.4rem 1.4rem; }
    canvas.chart { width: 100% !important; max-height: 240px; }

    /* Filter card */
    .filter-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    /* Tables */
    .metrics-table th { 
        font-size: 0.78rem; 
        text-transform: uppercase; 
        letter-spacing: 0.08em; 
        color: #94a3b8; 
        border-top: none; 
        padding: 1.2rem 1rem !important;
    }
    .metrics-table td { 
        vertical-align: middle; 
        font-size: 0.9rem; 
        padding: 1rem !important;
    }
    .metrics-table tbody tr:hover { background: #f8fafc; }
    .rank-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 26px; height: 26px; border-radius: 50%;
        font-size: 0.75rem; font-weight: 700; background: #f1f5f9; color: #475569;
    }
    .rank-badge.gold   { background: #fef3c7; color: #b45309;}
    .rank-badge.silver { background: #f1f5f9; color: #64748b;}
    .rank-badge.bronze { background: #fde8d8; color: #b45309;}

    .warning-icon-container { display: flex; justify-content: center; }
    .warning-icon-bg {
        width: 100px; height: 100px; background: #FEF3C7; color: #D97706;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 3rem; animation: scaleUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes scaleUp {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>

<img src="{{ asset('imagenes/logo-gigi.png') }}" class="hidden" id="img-logo" width="64">

<div class="pt-4">


@if (Session::get('errors'))
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)<p class="m-0">{{ $message }}</p>@endforeach
    </div>
@endif

{{-- Filter Card --}}
<div class="card filter-card">
    <div class="py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <h4 class="m-0 font-weight-bold" style="color: #334155; letter-spacing: -0.5px;">Métricas de Negocio</h4>
        <button onclick="pdf()" class="btn btn-sm px-3 py-2" style="font-weight:600; font-size: 16px; background: #EEE1ED; color: #7D266E; border-radius: 10px; border: none;">
            <i class="far fa-file-pdf mr-2"></i>Generar PDF
        </button>
    </div>
    <div class="card-body py-4 px-4">
        <form action="{{ route('metrics.query') }}" method="POST" class="form-inline" style="gap:1.5rem; flex-wrap:wrap;">
            @csrf
            <div class="form-group">
                <label class="mr-3 font-weight-bold text-muted small uppercase" style="letter-spacing: 0.05em;">Desde:</label>
                <input class="form-control border-0 bg-light" type="date" name="fromDate" value="{{ $fromDate }}" style="border-radius:10px; padding: 1.2rem 1rem;">
            </div>
            <div class="form-group">
                <label class="mr-3 font-weight-bold text-muted small uppercase" style="letter-spacing: 0.05em;">Hasta:</label>
                <input class="form-control border-0 bg-light" type="date" name="toDate" value="{{ $toDate }}" style="border-radius:10px; padding: 1.2rem 1rem;">
            </div>
            <button type="submit" class="btn px-4 py-2 font-weight-bold" style="border-radius:10px; background: #7D266E; color: white; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);">
                <i class="fas fa-filter mr-1"></i> Filtrar
            </button>
        </form>
    </div>
</div>

{{-- KPI Row --}}
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="kpi-card kpi-orders">
            <div class="kpi-label">Órdenes en Período</div>
            <div class="kpi-value">{{ array_sum(json_decode($cantidadPorDiaOrders, true) ?? []) }}</div>
            <i class="fas fa-shopping-cart kpi-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="kpi-card kpi-products">
            <div class="kpi-label">Productos Vendidos</div>
            <div class="kpi-value">{{ array_sum(json_decode($cantidadPorDiaProducts, true) ?? []) }}</div>
            <i class="fas fa-boxes kpi-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="kpi-card kpi-revenue">
            <div class="kpi-label">Ganancia Neta Total</div>
            <div class="kpi-value">${{ number_format($totalGain, 2) }}</div>
            <i class="fas fa-dollar-sign kpi-icon"></i>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header">Órdenes por Día</div>
            <div class="card-body">
                <canvas id="prediccion" class="chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header">Productos Vendidos por Día</div>
            <div class="card-body">
                <canvas id="products" class="chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header">Ingresos por Día</div>
            <div class="card-body">
                <canvas id="ganancia" class="chart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Tables Row --}}
<div class="row">
    {{-- Top Products --}}
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header border-0 pt-4 px-4">
                <h5 class="m-0 font-weight-bold">Productos Más Vendidos</h5>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="table-responsive">
                    <table class="table metrics-table mb-0" id="table-sold-products">
                        <thead><tr><th>#</th><th>Producto</th><th class="text-right">Uds</th><th class="text-right">$</th></tr></thead>
                        <tbody>
                        @foreach ($top10Products as $i => $product)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : '')) }}">{{ $i+1 }}</span>
                                </td>
                                <td><a href="{{ route('articulo.show', $product['id']) }}" class="text-primary font-weight-500">{{ ucfirst($product['name']) }}</a></td>
                                <td class="text-right">{{ $product['total'] }}</td>
                                <td class="text-right font-weight-bold text-success">{{ number_format($product['gain'], 2) }}$</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Categories --}}
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header border-0 pt-4 px-4">
                <h5 class="m-0 font-weight-bold">Categorías Más Vendidas</h5>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="table-responsive">
                    <table class="table metrics-table mb-0" id="table-sold-categories">
                        <thead><tr><th>#</th><th>Categoría</th><th class="text-right">Uds</th><th class="text-right">$</th></tr></thead>
                        <tbody>
                        @foreach ($top10Categories as $i => $category)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : '')) }}">{{ $i+1 }}</span>
                                </td>
                                <td><a href="{{ route('categories.show', $category['id']) }}" class="text-primary font-weight-500">{{ ucfirst($category['name']) }}</a></td>
                                <td class="text-right">{{ $category['total'] }}</td>
                                <td class="text-right font-weight-bold text-success">{{ number_format($category['gain'], 2) }}$</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Clients --}}
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card chart-card h-100">
            <div class="card-header border-0 pt-4 px-4">
                <h5 class="m-0 font-weight-bold">Mejores Clientes</h5>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="table-responsive">
                    <table class="table metrics-table mb-0" id="table-best-clients">
                        <thead><tr><th>#</th><th>Cliente</th><th class="text-right">Visitas</th><th class="text-right">$</th></tr></thead>
                        <tbody>
                        @foreach ($top10Clients as $i => $client)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : '')) }}">{{ $i+1 }}</span>
                                </td>
                                <td><a href="{{ route('client.show', $client['id']) }}" class="text-primary font-weight-500">{{ ucfirst($client['name']) }}</a></td>
                                <td class="text-right">{{ $client['total'] }}</td>
                                <td class="text-right font-weight-bold text-success">{{ number_format($client['gain'], 2) }}$</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>{{-- /pt-4 wrapper --}}

{{-- Warning Modal (Premium Aesthetic) --}}
<div class="modal fade" id="warningModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
            <div class="modal-body text-center p-5">
                <div class="warning-icon-container mb-4">
                    <div class="warning-icon-bg">
                        <i class="fas fa-exclamation"></i>
                    </div>
                </div>
                <h3 class="font-weight-bold mb-3" style="color: #1E293B;">Atención</h3>
                <p id="warning-message" class="text-muted mb-4" style="font-size: 1.1rem;">No hay datos para generar el PDF.</p>
                <button type="button" class="btn btn-block py-3 font-weight-bold" data-dismiss="modal" 
                        style="background: #7D266E; color: white; border-radius: 1rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);">
                    ENTENDIDO
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="/js/jspdf/dist/jspdf.umd.min.js" defer></script>
    <script src="/js/jspdf/dist/jspdf.plugin.autotable.min.js" defer></script>
    <script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        const commonOptions = (title, yLabel) => ({
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                title: { display: false },
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f8fafc',
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    title: { display: true, text: 'Días', color: '#94a3b8', font: { size: 11 } }
                },
                y: {
                    grid: { color: 'rgba(148,163,184,0.15)' },
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    title: { display: true, text: yLabel, color: '#94a3b8', font: { size: 11 } }
                }
            }
        });


        // Chart 1 – Orders
        const ctx1 = document.getElementById('prediccion').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: {!! $listaFechasOrders !!},
                datasets: [{
                    label: 'Órdenes',
                    data: {!! $cantidadPorDiaOrders !!},
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderColor: '#8B5CF6',
                    borderWidth: 3,
                    pointBackgroundColor: '#8B5CF6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: commonOptions('Órdenes por Día', 'Cantidad')
        });

        // Chart 2 – Products
        const ctx2 = document.getElementById('products').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! $listaFechasProducts !!},
                datasets: [{
                    label: 'Productos',
                    data: {!! $cantidadPorDiaProducts !!},
                    backgroundColor: 'rgba(125, 38, 110, 0.1)',
                    borderColor: '#7D266E',
                    borderWidth: 3,
                    pointBackgroundColor: '#7D266E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: commonOptions('Productos Vendidos por Día', 'Cantidad')
        });

        // Chart 3 – Revenue
        const ctx3 = document.getElementById('ganancia').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: {!! $listaFechasWins !!},
                datasets: [{
                    label: 'Ingresos',
                    data: {!! $cantidadPorDiaWins !!},
                    backgroundColor: 'rgba(76, 29, 149, 0.1)',
                    borderColor: '#4C1D95',
                    borderWidth: 3,
                    pointBackgroundColor: '#4C1D95',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: commonOptions('Ingresos por Día', 'USD ($)')
        });
    });

    function pdf() {
        if ({!! $cantidadPorDiaOrders !!}.length === 0) {
            $('#warning-message').text('No hay datos para generar el informe de métricas.');
            $('#warningModal').modal('show');
            return;
        }

        const {jsPDF} = window.jspdf;
        let graphics = document.querySelectorAll('.chart');
        const doc = new jsPDF('p', 'mm', 'a4');
        var x = 14, y = 20;

        // Title and Header
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.text('GIGI FASHION IMPORT C.A.', x, y);
        
        let logo = document.querySelectorAll('#img-logo');
        if (logo.length > 0) {
            doc.addImage(logo[0], 'PNG', 165, y-10, 28, 28);
        }

        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text("RIF: J-40270897-1", x, y+=7);
        
        var from = document.querySelector('input[name="fromDate"]') ? document.querySelector('input[name="fromDate"]').value : '';
        var to   = document.querySelector('input[name="toDate"]')   ? document.querySelector('input[name="toDate"]').value   : '';
        doc.setFontSize(10);
        doc.text("Periodo: " + (from || 'N/A') + " al " + (to || 'N/A'), x, y+=6);

        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        y += 15;
        doc.text("INFORME DE MÉTRICAS", 105, y, { align: "center" });
        
        y += 12;
        
        // Add Charts
        let col = 0;
        let startY = y;
        let maxY = y;

        graphics.forEach((el, index) => {
            // Get the title from the parent card header
            const card = el.closest('.chart-card');
            const title = card ? card.querySelector('.card-header').innerText : '';

            // Get chart image as base64
            const imgData = el.toDataURL('image/png', 1.0);
            
            // Dimensions for 2-column layout
            const maxWidth = 85;
            const ratio = el.width / el.height;
            let targetWidth = maxWidth;
            let targetHeight = targetWidth / ratio;
            
            // Limit height strictly
            if (targetHeight > 45) {
                targetHeight = 45;
                targetWidth = targetHeight * ratio;
            }
            
            if (startY + targetHeight + 15 > 275) { 
                doc.addPage();
                startY = 20;
                maxY = 20;
            }

            // Determine X coordinate based on column (0 or 1)
            let colX = col === 0 ? 14 : 111;

            // Draw title above the chart
            if (title) {
                doc.setFontSize(10);
                doc.setFont('helvetica', 'bold');
                doc.text(title, colX + (maxWidth / 2), startY, { align: "center" });
            }

            // Center the chart within its column
            let currentX = colX + (maxWidth - targetWidth) / 2;

            doc.addImage(imgData, 'PNG', currentX, startY + 5, targetWidth, targetHeight);
            
            if (startY + 5 + targetHeight > maxY) {
                maxY = startY + 5 + targetHeight;
            }

            col++;
            if (col > 1) {
                col = 0;
                startY = maxY + 15;
            }
        });

        y = col === 0 ? startY : maxY + 15;

        // AutoTable styles matching the Premium Purple theme
        const tableStyles = {
            theme: 'grid',
            styles: { fontSize: 8, cellPadding: 3 },
            headStyles: { fillColor: [117, 34, 109], textColor: 255, fontStyle: 'bold' },
            alternateRowStyles: { fillColor: [248, 250, 252] }
        };

        if (y > 250) { doc.addPage(); y = 20; }
        else { y += 5; }

        doc.setFontSize(12);
        doc.setFont('helvetica', 'bold');
        doc.text("Ganancia Neta Total: {{ number_format($totalGain, 2, ',', '.') }} $", x, y);
        y += 15;

        // Table 1: Productos Más Vendidos
        if (y > 260) { doc.addPage(); y = 20; }
        doc.setFontSize(11);
        doc.text("Productos Más Vendidos:", x, y);
        y += 4;
        doc.autoTable({ 
            html: '#table-sold-products', 
            startY: y,
            ...tableStyles
        });
        
        y = doc.lastAutoTable.finalY + 15;

        // Table 2: Categorías Más Vendidas
        if (y > 260) { doc.addPage(); y = 20; }
        doc.setFontSize(11);
        doc.text("Categorías Más Vendidas:", x, y);
        y += 4;
        doc.autoTable({ 
            html: '#table-sold-categories', 
            startY: y,
            ...tableStyles
        });

        y = doc.lastAutoTable.finalY + 15;

        // Table 3: Mejores Clientes
        if (y > 260) { doc.addPage(); y = 20; }
        doc.setFontSize(11);
        doc.text("Mejores Clientes:", x, y);
        y += 4;
        doc.autoTable({ 
            html: '#table-best-clients', 
            startY: y,
            ...tableStyles
        });

        doc.save('informe_metricas_' + (from || 'inicio') + '_' + (to || 'fin') + '.pdf');
    }
    </script>
@stop
