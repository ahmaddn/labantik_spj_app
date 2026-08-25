<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pesanan->invoice_num ?? '0000' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-yellow: #fec006;
            --dark-slate: #232b38;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --text-color: #495057;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Printable Area */
        .invoice-card {
            background-color: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            position: relative;
            box-sizing: border-box;
            min-height: 297mm; /* Standard A4 height aspect */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Float Action Panel */
        .no-print-panel {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .btn-print {
            background-color: var(--dark-slate);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            background-color: #1a202c;
            transform: translateY(-1px);
        }

        .btn-back {
            color: var(--dark-slate);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Invoice Layout Styling */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background: var(--dark-slate);
            color: #ffffff;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark-slate);
            margin: 0;
            line-height: 1.1;
        }

        .brand-tagline {
            font-size: 11px;
            color: #888;
            margin: 2px 0 0 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Banner */
        .yellow-banner {
            background-color: var(--primary-yellow);
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 40px;
            margin-left: -40px;
            margin-right: -40px;
            margin-bottom: 35px;
        }

        .banner-text {
            color: var(--dark-slate);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 2px;
            margin: 0;
        }

        /* Details Section */
        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .invoice-to {
            max-width: 50%;
        }

        .invoice-to h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark-slate);
            margin: 0 0 8px 0;
        }

        .client-name {
            font-size: 16px;
            font-weight: 700;
            color: #000000;
            margin: 0 0 4px 0;
        }

        .client-address {
            font-size: 13px;
            line-height: 1.4;
            color: #6c757d;
            margin: 0;
        }

        .meta-details {
            text-align: right;
            display: grid;
            grid-template-columns: auto 120px;
            row-gap: 8px;
            column-gap: 15px;
            font-size: 14px;
            align-items: center;
        }

        .meta-label {
            font-weight: 600;
            color: var(--dark-slate);
            text-align: left;
        }

        .meta-value {
            color: #2b2b2b;
            text-align: right;
        }

        /* Items Table */
        .table-container {
            margin-bottom: 40px;
            flex-grow: 1;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background-color: var(--dark-slate);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 15px;
            letter-spacing: 0.5px;
        }

        .items-table th:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .items-table th:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .items-table td {
            padding: 14px 15px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border-color);
        }

        .items-table tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Bottom Section */
        .bottom-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .bottom-left {
            max-width: 50%;
        }

        .thank-you {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-slate);
            margin: 0 0 15px 0;
        }

        .info-block {
            margin-bottom: 15px;
        }

        .info-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--dark-slate);
            margin: 0 0 5px 0;
        }

        .info-desc {
            font-size: 11px;
            color: #6c757d;
            line-height: 1.5;
            margin: 0;
        }

        .bottom-right {
            min-width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 10px;
            font-size: 13.5px;
        }

        .summary-label {
            font-weight: 500;
            color: #6c757d;
        }

        .summary-value {
            font-weight: 600;
            color: var(--dark-slate);
        }

        .total-bar {
            background-color: var(--primary-yellow);
            display: flex;
            justify-content: space-between;
            padding: 12px 15px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 800;
            color: var(--dark-slate);
            margin-top: 10px;
        }

        /* Footer Accent */
        .footer-section {
            margin-top: 50px;
            border-top: 2px solid var(--primary-yellow);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .contact-info {
            font-size: 11px;
            color: #6c757d;
        }

        .contact-info span {
            margin-right: 15px;
        }

        .sign-area {
            text-align: center;
        }

        .sign-line {
            width: 150px;
            border-bottom: 1px solid #6c757d;
            margin-bottom: 5px;
        }

        .sign-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--dark-slate);
        }

        /* Print Settings */
        @media print {
            body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
            }

            .invoice-card {
                box-shadow: none;
                padding: 0;
                border-radius: 0;
                min-height: auto;
            }

            .no-print-panel {
                display: none !important;
            }

            /* Ensure banner extends on print */
            .yellow-banner {
                margin-left: 0;
                margin-right: 0;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Panel for UI view -->
    <div class="no-print-panel">
        <a href="{{ route('eksternal.pesanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Invoice
        </button>
    </div>

    <!-- Main Printable Invoice -->
    <div class="invoice-card">
        <div>
            <!-- Header -->
            <div class="header-section">
                <div class="logo-container">
                    <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <h2 class="brand-name">{{ $pesanan->penyedia->company ?? 'Brand Name' }}</h2>
                        <p class="brand-tagline">TAGLINE SPACE HERE</p>
                    </div>
                </div>
            </div>

            <!-- Banner -->
            <div class="yellow-banner">
                <h1 class="banner-text">INVOICE</h1>
            </div>

            <!-- Invoice Details -->
            <div class="details-section">
                <div class="invoice-to">
                    <h3>Invoice to:</h3>
                    <p class="client-name">{{ $pesanan->penerima->name ?? 'Nama Penerima' }}</p>
                    <p class="client-address">
                        NIP. {{ $pesanan->penerima->nip ?? '-' }}<br>
                        {{ $pesanan->penerima->position ?? 'Jabatan' }}<br>
                        {{ $pesanan->penerima->school ?? 'Sekolah / Instansi' }}
                    </p>
                </div>
                <div class="meta-details">
                    <span class="meta-label">Invoice#</span>
                    <span class="meta-value">{{ $pesanan->invoice_num ?? '52148' }}</span>

                    <span class="meta-label">Date</span>
                    <span class="meta-value">{{ \Carbon\Carbon::parse($pesanan->order_date)->format('d / m / Y') }}</span>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-container">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">SL.</th>
                            <th style="width: 50%;">Item Description</th>
                            <th style="width: 15%;" class="text-right">Price</th>
                            <th style="width: 10%;" class="text-center">Qty.</th>
                            <th style="width: 20%;" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @forelse ($pesanan->barang as $index => $item)
                            @php
                                $itemTotal = $item->price * $item->amount;
                                $subtotal += $itemTotal;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-right">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->amount }}</td>
                                <td class="text-right">Rp. {{ number_format($itemTotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada item barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <!-- Summary and Bottom section -->
            <div class="bottom-section">
                <div class="bottom-left">
                    <p class="thank-you">Thank you for your business</p>
                    
                    @if($pesanan->penyedia)
                    <div class="info-block">
                        <p class="info-title">Payment Info:</p>
                        <p class="info-desc">
                            Bank Name: {{ $pesanan->penyedia->bank ?? '-' }}<br>
                            Account No: {{ $pesanan->penyedia->account ?? '-' }}<br>
                            A/C Holder: {{ $pesanan->penyedia->delegation_name ?? '-' }}
                        </p>
                    </div>
                    @endif

                    <div class="info-block">
                        <p class="info-title">Terms & Conditions:</p>
                        <p class="info-desc">Pembayaran dilakukan secara penuh sesuai dengan kesepakatan penyerahan barang dan jasa.</p>
                    </div>
                </div>

                <div class="bottom-right">
                    <div class="summary-row">
                        <span class="summary-label">Sub Total:</span>
                        <span class="summary-value">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    @php
                        $taxNominal = $pesanan->tax ?? 0;
                        // Calculate percentage for display if tax nominal > 0
                        $taxPercentage = $subtotal > 0 ? round(($taxNominal / $subtotal) * 100, 2) : 0;
                    @endphp
                    <div class="summary-row">
                        <span class="summary-label">Tax ({{ $taxPercentage }}%):</span>
                        <span class="summary-value">Rp. {{ number_format($taxNominal, 0, ',', '.') }}</span>
                    </div>

                    @if($pesanan->shipping_cost > 0)
                    <div class="summary-row">
                        <span class="summary-label">Shipping:</span>
                        <span class="summary-value">Rp. {{ number_format($pesanan->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @php
                        $grandTotal = $subtotal + $taxNominal + ($pesanan->shipping_cost ?? 0);
                    @endphp
                    <div class="total-bar">
                        <span>Total:</span>
                        <span>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="footer-section">
                <div class="contact-info">
                    @if($pesanan->penyedia)
                        <span><strong>Phone:</strong> {{ $pesanan->penyedia->post_code ?? '-' }}</span>
                        <span><strong>Address:</strong> {{ $pesanan->penyedia->address ?? '-' }}</span>
                    @endif
                </div>
                <div class="sign-area">
                    <div class="sign-line"></div>
                    <p class="sign-title">Authorised Sign</p>
                    @if($pesanan->penyedia)
                        <small style="color: #6c757d; font-size: 10px;">{{ $pesanan->penyedia->delegation_name }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Auto trigger print dialog on page load -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            // Optional: Auto open print dialog
            // window.print();
        });
    </script>
</body>
</html>
