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

        /* Area Cetak */
        .invoice-card {
            background-color: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            position: relative;
            box-sizing: border-box;
            min-height: 297mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Panel Aksi */
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

        /* Header */
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

        /* Details */
        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 45px;
        }

        .invoice-to {
            max-width: 50%;
        }

        .invoice-to h3 {
            font-size: 14px;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            letter-spacing: 0.5px;
        }

        .client-name {
            font-size: 16px;
            font-weight: 700;
            color: #000000;
            margin: 0 0 6px 0;
        }

        .client-address {
            font-size: 13px;
            line-height: 1.5;
            color: #495057;
            margin: 0;
        }

        .meta-details {
            text-align: right;
            font-size: 13.5px;
            max-width: 45%;
        }

        .meta-row {
            margin-bottom: 8px;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
        }

        .meta-label {
            font-weight: 600;
            color: var(--dark-slate);
            margin-right: 8px;
            white-space: nowrap;
        }

        .meta-value {
            color: #2b2b2b;
            text-align: right;
            word-break: break-word;
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
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
            color: #2b2b2b;
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
            margin-top: 20px;
            gap: 20px;
        }

        .bottom-left {
            width: 55%;
        }

        .thank-you {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark-slate);
            margin: 0 0 15px 0;
        }

        .info-block {
            margin-bottom: 15px;
            background-color: #fafbfc;
            border: 1px solid #f1f3f5;
            padding: 12px;
            border-radius: 6px;
        }

        .info-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--dark-slate);
            margin: 0 0 6px 0;
            letter-spacing: 0.5px;
        }

        .info-desc {
            font-size: 11px;
            color: #495057;
            line-height: 1.5;
            margin: 0;
        }

        .bottom-right {
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
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

        /* Signature Block (TTD) */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }

        .signature-container {
            width: 250px;
        }

        .sig-date {
            font-size: 12px;
            color: #495057;
            margin-bottom: 5px;
        }

        .sig-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--dark-slate);
            margin-bottom: 55px;
        }

        .sig-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #000000;
            margin: 0;
            text-decoration: underline;
        }

        .sig-position {
            font-size: 11px;
            color: #6c757d;
            margin: 2px 0 0 0;
        }

        /* Footer Accent */
        .footer-section {
            margin-top: 40px;
            border-top: 2px solid var(--primary-yellow);
            padding-top: 15px;
        }

        .contact-info {
            font-size: 11px;
            color: #6c757d;
            display: flex;
            justify-content: center;
            gap: 20px;
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

    <!-- Panel Aksi Atas -->
    <div class="no-print-panel">
        <a href="{{ route('eksternal.pesanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Invoice
        </button>
    </div>

    <!-- Konten Invoice Utama -->
    <div class="invoice-card">
        <div>
            <!-- Header -->
            <div class="header-section">
                <div class="logo-container">
                    <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <h2 class="brand-name">{{ $pesanan->penyedia->company ?? 'Nama Perusahaan' }}</h2>
                        <p class="brand-tagline">TAGLINE SPACE HERE</p>
                    </div>
                </div>
            </div>

            <!-- Banner -->
            <div class="yellow-banner">
                <h1 class="banner-text">INVOICE</h1>
            </div>

            <!-- Detail Invoice -->
            <div class="details-section">
                <div class="invoice-to">
                    <h3>Tagihan Kepada:</h3>
                    <p class="client-name">{{ $pesanan->penerima->name ?? 'Nama Penerima' }}</p>
                    <div class="client-address">
                        NIP. {{ $pesanan->penerima->nip ?? '-' }}<br>
                        {{ $pesanan->penerima->position ?? 'Jabatan' }}<br>
                        {{ $pesanan->penerima->school ?? 'Sekolah / Instansi' }}
                    </div>
                </div>
                <div class="meta-details">
                    <div class="meta-row">
                        <span class="meta-label">No. Invoice:</span>
                        <span class="meta-value">{{ $pesanan->invoice_num ?? '0000' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Tanggal:</span>
                        <span class="meta-value">{{ \Carbon\Carbon::parse($pesanan->order_date)->format('d / m / Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Barang -->
            <div class="table-container">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;" class="text-center">No.</th>
                            <th style="width: 47%;">Deskripsi Barang / Jasa</th>
                            <th style="width: 17%;" class="text-right">Harga Satuan</th>
                            <th style="width: 10%;" class="text-center">Jumlah</th>
                            <th style="width: 18%;" class="text-right">Total Harga</th>
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
            <!-- Ringkasan Pembayaran -->
            <div class="bottom-section">
                <div class="bottom-left">
                    <p class="thank-you">Terima kasih atas kerja sama Anda.</p>
                    
                    @if($pesanan->penyedia)
                    <div class="info-block">
                        <p class="info-title">Informasi Pembayaran:</p>
                        <p class="info-desc">
                            Nama Bank: {{ $pesanan->penyedia->bank ?? '-' }}<br>
                            No. Rekening: {{ $pesanan->penyedia->account ?? '-' }}<br>
                            Pemilik Rekening: {{ $pesanan->penyedia->delegation_name ?? '-' }}
                        </p>
                    </div>
                    @endif

                    <div class="info-block">
                        <p class="info-title">Syarat & Ketentuan:</p>
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
                        $taxPercentage = $subtotal > 0 ? round(($taxNominal / $subtotal) * 100, 2) : 0;
                    @endphp
                    <div class="summary-row">
                        <span class="summary-label">Pajak ({{ $taxPercentage }}%):</span>
                        <span class="summary-value">Rp. {{ number_format($taxNominal, 0, ',', '.') }}</span>
                    </div>

                    @if($pesanan->shipping_cost > 0)
                    <div class="summary-row">
                        <span class="summary-label">Biaya Pengiriman:</span>
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

            <!-- Tanda Tangan (TTD) -->
            <div class="signature-section">
                <div class="signature-container">
                    <p class="sig-date">Majalengka, {{ \Carbon\Carbon::parse($pesanan->order_date)->translatedFormat('d F Y') }}</p>
                    <p class="sig-label">Tanda Tangan Resmi,</p>
                    <p class="sig-name">{{ $pesanan->penyedia->delegation_name ?? 'Nama Penanggung Jawab' }}</p>
                    <p class="sig-position">{{ $pesanan->penyedia->delegate_position ?? 'Direktur / Pengelola' }}</p>
                </div>
            </div>

            <!-- Bagian Kaki (Footer) -->
            <div class="footer-section">
                <div class="contact-info">
                    @if($pesanan->penyedia)
                        <span><strong>Telepon:</strong> {{ $pesanan->penyedia->post_code ?? '-' }}</span>
                        <span><strong>Alamat:</strong> {{ $pesanan->penyedia->address ?? '-' }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
