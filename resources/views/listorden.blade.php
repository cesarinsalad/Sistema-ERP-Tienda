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
                            <h3 class="font-weight-bold text-dark m-0" style="letter-spacing: -0.5px;">Lista de Ventas</h3>
                            <p class="text-muted small m-0 mt-1"><i class="fas fa-list mr-1"></i> Histórico de transacciones y órdenes procesadas</p>
                        </div>
                        <div class="d-flex" style="gap: 12px;">
                            <button onclick="generatePDF()" class="btn px-3 py-2 font-weight-bold" 
                                    style="background: #EEE1ED; color: #7D266E; border-radius: 50rem; text-transform: uppercase; border: none;">
                                <i class="far fa-file-pdf mr-2"></i> GENERAR PDF
                            </button>
                            <a class="btn px-4 py-2 font-weight-bold shadow-sm" href="{{ route('home') }}" 
                               style="background: #7D266E; color: white; border-radius: 50rem; text-transform: uppercase;">
                                <i class="fas fa-plus mr-2"></i> NUEVA VENTA
                            </a>
                        </div>
                    </div>

                    {{-- Search Section --}}
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('listorden.index') }}" method="GET" class="form-inline mb-0" style="gap:1rem; flex-wrap:wrap;">
                            <div class="input-group" style="width: 250px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-0 bg-light" 
                                       placeholder="Buscar por cliente..." value="{{ request('search') }}"
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

                            <div class="form-group" style="height: 45px;">
                                <select name="seller_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 150px;">
                                    <option value="">Todos los Vendedores</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                            {{ $seller->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="height: 45px;">
                                <select name="payment_method_id" class="form-control border-0 bg-light" style="border-radius: 10px; height: 45px; min-width: 160px;">
                                    <option value="">Todos los Métodos de Pago</option>
                                    @foreach($paymentMethods as $pm)
                                        <option value="{{ $pm->id }}" {{ request('payment_method_id') == $pm->id ? 'selected' : '' }}>
                                            {{ $pm->nombre_metodo }} ({{ $pm->moneda }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn px-4 font-weight-bold text-white" 
                                    style="background: #5b1b50; border-radius: 10px; height: 45px;">
                                FILTRAR
                            </button>
                            @if(request('search') || request('fromDate') || request('toDate') || request('seller_id') || request('payment_method_id'))
                                <a href="{{ route('listorden.index') }}" class="btn btn-link text-muted font-weight-bold">Limpiar</a>
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
                        <table id="ventas-table" class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th width="60px">ID</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha</th>
                                    <th class="text-right">Monto (Bs)</th>
                                    <th class="text-right">Monto ($)</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $order->id }}</td>
                                    <td>
                                        <a href="{{ route('client.show',$order->client->id) }}" class="font-weight-bold text-purple">
                                            {{ $order->client->nombres }} {{ $order->client->apellidos }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2" style="background: #F1F5F9; color: #475569; border-radius: 8px; font-weight: 600;">
                                            {{ strtoupper($order->seller->name) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small font-weight-600">{{ $order->created_at->format('d/m/Y h:i A') }}</td>
                                    <td class="text-right font-weight-bold">{{ number_format($order->monto_orden * $order->tasa->value, 2, ',', '.') }}Bs</td>
                                    <td class="text-right font-weight-bold text-success" style="font-size: 1.1rem;">
                                        {{ number_format($order->monto_orden, 2, ',', '.') }}$
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-sm btn-info shadow-sm" href="{{ route('listorden.show',$order->id) }}" 
                                               style="border-radius: 8px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                               data-toggle="tooltip" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                    <div class="card-footer bg-white border-0 py-4">
                        {!! $orders->links() !!}
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
        #ventas-table_filter { display: none; }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
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
            const seller_id = $('select[name="seller_id"]').val();
            const payment_method_id = $('select[name="payment_method_id"]').val();

            $.ajax({
                url: "{{ route('listorden.pdfData') }}",
                method: 'GET',
                data: { fromDate, toDate, search, seller_id, payment_method_id },
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
            
            doc.setFontSize(8);
            var addressText = "CALLE SAN NICOLAS ENTRE EL BOULEVAR GOMEZ Y GUEVARA LOCAL S/N NRO 7 SECTOR CENTRO PORLAMAR NUEVA ESPARTA, ZONA POSTAL 6301";
            var splitAddress = doc.splitTextToSize(addressText, pageWidth - 60);
            doc.text(splitAddress, x, y+=5);
            
            doc.setFontSize(10);
            y += (splitAddress.length * 4) + 2;
            doc.text('Periodo: ' + (fromDate || 'N/A') + ' al ' + (toDate || 'N/A'), x, y);
            doc.text('Fecha y hora de emisión: ' + new Date().toLocaleString('es-VE'), x, y+=5);

            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            y += 15;
            doc.text("REPORTE DE VENTAS", pageWidth / 2, y, { align: "center" });

            const headers = [['No', 'Cliente', 'Vendedor', 'Fecha', 'Monto ($)', 'Tasa', 'Monto (Bs)']];
            const rows = [];
            let totalUSD = 0;

            data.forEach(order => {
                const clientName = order.client ? (order.client.nombres + ' ' + (order.client.apellidos || '')) : 'N/A';
                const sellerName = order.seller ? order.seller.name : 'N/A';
                const montoUSD = parseFloat(order.monto_orden) || 0;
                const tasaValue = order.tasa ? parseFloat(order.tasa.value) : 0;
                totalUSD += montoUSD;

                rows.push([
                    order.id, clientName, sellerName,
                    new Date(order.created_at).toLocaleDateString(),
                    montoUSD.toFixed(2).replace('.', ',') + '$',
                    tasaValue.toFixed(2).replace('.', ',') + 'Bs',
                    (montoUSD * tasaValue).toFixed(2).replace('.', ',') + 'Bs'
                ]);
            });

            doc.autoTable({
                head: headers, body: rows, startY: y + 10, theme: 'grid',
                styles: { fontSize: 8, cellPadding: 3 },
                headStyles: { fillColor: [117, 34, 109], textColor: 255 },
                alternateRowStyles: { fillColor: [248, 250, 252] }
            });

            doc.text('Total en Ventas: ' + totalUSD.toFixed(2).replace('.', ',') + '$', 14, doc.lastAutoTable.finalY + 10);

            // Add page numbers
            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(120);
                const pWidth = doc.internal.pageSize.getWidth();
                const pHeight = doc.internal.pageSize.getHeight();
                const pageText = `Pág. ${i} de ${totalPages}`;
                doc.text(pageText, pWidth - 14, pHeight - 10, { align: 'right' });
            }

            doc.save('ventas_' + (fromDate || 'all') + '.pdf');
        }
    </script>
@stop
