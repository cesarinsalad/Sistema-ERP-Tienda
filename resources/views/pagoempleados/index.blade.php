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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Historial de Pagos</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-hand-holding-usd mr-1"></i> Control de pagos de nómina y honorarios</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <button onclick="generatePDF()" class="btn px-3 py-2 font-weight-bold" 
                                    style="background: #EEE1ED; color: #7D266E; border-radius: 50rem; text-transform: uppercase; border: none;">
                                <i class="far fa-file-pdf mr-2"></i> GENERAR PDF
                            </button>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('pagoempleados.create') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> REGISTRAR PAGO
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('pagoempleados.index') }}" method="GET" class="form-inline mb-0" style="gap:1rem; flex-wrap:wrap;">
                            <div class="input-group" style="width: 280px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar empleado o C.I..." value="{{ request('search') }}"
                                       style="border-radius: 0 10px 10px 0; height: 45px;">
                            </div>
                            
                            <div class="form-group d-flex align-items-center bg-light px-3" style="border-radius: 10px; height: 45px;">
                                <label class="mr-3 font-weight-bold text-muted small uppercase m-0" style="letter-spacing: 0.05em;">Desde:</label>
                                <input class="form-control border-0 bg-transparent p-0" type="date" name="fromDate" value="{{ request('fromDate', $defaultFrom) }}">
                            </div>
                            <div class="form-group d-flex align-items-center bg-light px-3" style="border-radius: 10px; height: 45px;">
                                <label class="mr-3 font-weight-bold text-muted small uppercase m-0" style="letter-spacing: 0.05em;">Hasta:</label>
                                <input class="form-control border-0 bg-transparent p-0" type="date" name="toDate" value="{{ request('toDate', $defaultTo) }}">
                            </div>

                            <button type="submit" class="btn px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                FILTRAR
                            </button>
                            @if(request('search') || request('fromDate') || request('toDate'))
                                <a href="{{ route('pagoempleados.index') }}" class="btn btn-link text-muted font-weight-bold">Limpiar</a>
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
                        <table id="pagos-table" class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th width="60px">ID</th>
                                    <th>Empleado</th>
                                    <th>Documento</th>
                                    <th class="text-right">Monto ($)</th>
                                    <th>Método</th>
                                    <th>Referencia</th>
                                    <th>Fecha Pago</th>
                                    <th class="text-right">Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pagos as $pago)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $pago->id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $pago->empleado->user->name ?? 'Empleado N/A' }}</div>
                                    </td>
                                    <td class="text-purple font-weight-600">{{ $pago->empleado->document ?? 'N/A' }}</td>
                                    <td class="text-right">
                                        <span class="font-weight-bold text-success" style="font-size: 1.1rem;">
                                            ${{ number_format($pago->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px; font-weight: 600;">
                                            {{ strtoupper($pago->payment_method ?? 'EFECTIVO') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted small font-weight-bold">{{ $pago->reference ?? 'SIN REF.' }}</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-600">{{ \Carbon\Carbon::parse($pago->payment_date)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-right text-muted small font-weight-600">
                                        {{ $pago->created_at->format('d/m/Y h:i A') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fa-3x mb-3 opacity-2"></i>
                                        <p class="mb-0">No hay pagos registrados para este filtro.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pagos->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $pagos->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Warning Modal --}}
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .warning-icon-container { display: flex; justify-content: center; }
        .warning-icon-bg {
            width: 80px; height: 80px; background: #FEF3C7; color: #D97706;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            
            // Auto logo detection
            const imgLogo = document.createElement('img');
            imgLogo.src = "{{ asset('imagenes/logo-gigi.png') }}";
            imgLogo.id = 'img-logo';
            imgLogo.className = 'd-none';
            document.body.appendChild(imgLogo);
        });

        function generatePDF() {
            const fromDate = $('input[name="fromDate"]').val();
            const toDate = $('input[name="toDate"]').val();
            const search = $('input[name="search"]').val();

            $.ajax({
                url: "{{ route('pagoempleados.pdfData') }}",
                method: 'GET',
                data: { fromDate, toDate, search },
                success: function(data) {
                    if (!data || data.length === 0) {
                        $('#warning-message').text('No hay datos para generar el PDF en este rango/búsqueda.');
                        $('#warningModal').modal('show');
                        return;
                    }
                    renderPDF(data, fromDate, toDate);
                },
                error: function() {
                    alert('Error al obtener los datos.');
                }
            });
        }

        function renderPDF(data, fromDate, toDate) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            const pageWidth = doc.internal.pageSize.getWidth();
            var x = 14, y = 20;

            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.text('GIGI FASHION IMPORT C.A.', x, y);
            
            const logo = document.getElementById('img-logo');
            if (logo) doc.addImage(logo, 'PNG', pageWidth - 42, y-10, 28, 28);

            doc.setFontSize(12);
            doc.setFont('helvetica', 'normal');
            doc.text("RIF: J-40270897-1", x, y+=7);
            doc.setFontSize(10);
            doc.text('Periodo: ' + (fromDate || 'N/A') + ' al ' + (toDate || 'N/A'), x, y+=6);

            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            y += 15;
            doc.text("REPORTE DE PAGOS DE NÓMINA", pageWidth / 2, y, { align: "center" });

            const headers = [['No', 'Empleado', 'Cedula', 'Monto ($)', 'Metodo', 'Referencia', 'Fecha Pago', 'Registrado']];
            const rows = [];
            let total = 0;

            data.forEach(pago => {
                const empName = pago.empleado && pago.empleado.user ? pago.empleado.user.name : 'N/A';
                const empDoc = pago.empleado ? pago.empleado.document : 'N/A';
                const monto = parseFloat(pago.amount) || 0;
                total += monto;

                rows.push([
                    pago.id, empName, empDoc,
                    '$' + monto.toFixed(2),
                    pago.payment_method || 'Efectivo',
                    pago.reference || 'Sin Ref.',
                    new Date(pago.payment_date).toLocaleDateString(),
                    new Date(pago.created_at).toLocaleDateString()
                ]);
            });

            doc.autoTable({
                head: headers, body: rows, startY: y + 10, theme: 'grid',
                styles: { fontSize: 8, cellPadding: 3 },
                headStyles: { fillColor: [117, 34, 109], textColor: 255 },
                alternateRowStyles: { fillColor: [248, 250, 252] }
            });

            doc.text('Total Pagado: $' + total.toFixed(2), 14, doc.lastAutoTable.finalY + 10);
            doc.save('pagos_' + (fromDate || 'all') + '.pdf');
        }
    </script>
@stop
