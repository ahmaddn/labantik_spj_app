<?php \Carbon\Carbon::setLocale('id'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dokumen Perencanaan</title>
    <style>
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 19px;
            line-height: 1.15;
        }

        /* Area tanda tangan dikecualikan dari line-height 1.15 */
        .ttd-area,
        .ttd-area * {
            line-height: normal !important;
        }


        @media print {

            hr {
                border: none;
            }

            hr:first-of-type {
                border: 20px solid black;
            }

            hr:last-of-type {
                border: 0.3px solid black;
                margin-top: 0.5px;
            }
        }

        .nowrap {
            white-space: normal;
            word-break: break-word;
        }

        .break-cell {
            word-break: break-word;
            white-space: normal;
        }


        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

        }

        .tulisan td {
            line-height: 25px;
            border: none;
            font-size: 19px;
        }

        th,
        td {
            padding: 6px;
            vertical-align: top;
            font-size: 19px;
        }

        .no-border td {
            border: none;
        }

        .no-border-td {
            border: none;
        }

        .text-center {
            text-align: center;
            font-size: 19px;
        }

        .signature {
            text-align: left;
            margin-left: 70%;
            font-size: 19px;
        }

        .signature-nota {
            text-align: left;
            margin-left: 70%;
            font-size: 19px;
        }

        .page-break {
            page-break-before: always;
        }


        .konten-utama {
            align-items: center;
            justify-content: center;
            padding: 0 30px 30px 30px;

            font-size: 19px;
        }

        .page {
            height: 100%;
            align-items: center;
            padding: 0 30px 30px 30px;
            justify-content: center;
            font-size: 19px;
        }



        .content {

            font-size: 19px;
        }
    </style>
</head>

<body>

    <table width="100%" class="no-border" style="border: none; margin-bottom: 0;">
        <tr>
            <td width="10%" style="text-align: center; vertical-align: middle;
            ">
                {{-- dynamic logo: prefer $logoUrl passed from controller, then Letterhead model logo in storage, fall back to public asset --}}
                @php
                    // Resolve logo URL safely
                    $logoUrl = $logoUrl ?? null;
                    if (empty($logoUrl)) {
                        try {
                            $letterhead = \App\Models\Letterhead::first();
                        } catch (\Throwable $e) {
                            $letterhead = null;
                        }
                        if (!empty($letterhead) && !empty($letterhead->logo)) {
                            // If logo already stores a full URL, use it. Otherwise assume it's stored in storage/app/public
        if (filter_var($letterhead->logo, FILTER_VALIDATE_URL)) {
            $logoUrl = $letterhead->logo;
        } else {
            $logoUrl = \Illuminate\Support\Facades\Storage::url($letterhead->logo);
        }
    }
}
// final fallback to bundled asset
$logoUrl = $logoUrl ?: asset('jabar.png');
                @endphp
                <img src="{{ $logoUrl }}" width="100" style="margin-left:50px; display:block;" />
            </td>
            <td width="90%" style="text-align: center; vertical-align: middle;">
                <strong style="font-size: 19px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                    <span style="font-size: 29px;">CABANG DINAS PENDIDIKAN WILAYAH IX</span><br>
                    <span style="font-size: 21px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                <div style="font-size: 13px; line-height: 1.15; font-weight: normal; align-text: justify;">
                    Bidang Keahlian: Teknologi dan Rekayasa, Teknologi Informasi komunikasi, Bisnis dan Manajemen<br>
                    Kampus 1: Jalan Sekolah Nomor 20 Desa Talagakulon Kecamatan Talaga Kabupaten Majalengka <br>
                    Kampus 2: Jalan Talaga Bantarujeg Desa Mekarraharja Kecamatan Talaga Kabupaten Majalengka<br>
                    Telpon ☎(0233) 319238 FAX ✉ (0233) 319238 POS 45463 NPSN: 20213872<br>

                    Website 🌐 <a href="www.smkn1talaga.sch.id">www.smkn1talaga.sch.id</a> – Email 📧 <a
                        href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                </div>
            </td>
        </tr>

    </table>
    <svg viewBox="0 0 1000 6" width="100%" height="6" xmlns="http://www.w3.org/2000/svg">
        <!-- Garis atas: 2px -->
        <line x1="0" y1="1" x2="1000" y2="1" stroke="black" stroke-width="3" />

        <!-- Garis bawah: 0.3px, posisinya 0.7px di bawah garis atas (y1 = 3.7) -->
        <line x1="0" y1="3.7" x2="1000" y2="3.7" stroke="black" stroke-width="0." />
    </svg>




    </div>

    <div class="konten-utama">
        <h3 class="text-center">DOKUMEN PERENCANAAN</h3>

        <table style="border: none;" class="tulisan">
            <tr>
                <td>Nama satuan Pendidikan<br>
                    Alamat Satuan Pendidikan<br>
                    Kategori Barang dan Jasa</td>
                <td>: {{ $kepsek->school }} <br>
                    : {{ $kepsek->address }}<br>
                    : {{ $pesanan->kegiatan->name ?? '-' }}</td>
            </tr>
        </table>

        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="background-color: #d9d9d9">No</th>
                    <th style="background-color: #d9d9d9">Jenis</th>
                    <th style="background-color: #d9d9d9">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Jumlah barang/jasa</td>
                    <td>
                        @php
                            $jumlahBarang = 0;
                            foreach ($pesanan->barang as $item) {
                                $jumlahBarang += is_array($item) ? $item['amount'] ?? 0 : $item->amount ?? 0;
                            }
                        @endphp
                        {{ $jumlahBarang }}
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Spesifikasi/ruang lingkup barang/jasa</td>
                    <td>{{ $pesanan->kegiatan->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Waktu serah terima</td>
                    <td>{{ \Carbon\Carbon::parse($pesanan->kegiatan->accepted)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Lokasi serah terima</td>
                    <td>{{ $kepsek->school }}</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Alokasi anggaran</td>
                    <td>
                        @php
                            $total = 0;
                            foreach ($pesanan->barang as $item) {
                                $amount = is_array($item) ? $item['amount'] ?? 0 : $item->amount ?? 0;
                                $price = is_array($item) ? $item['price'] ?? 0 : $item->price ?? 0;
                                $total += $amount * $price;
                            }
                            $alokasi = $total + ($pesanan->tax ?? 0) + ($pesanan->shipping_cost ?? 0);
                        @endphp
                        Rp. {{ number_format($alokasi, 0, ',', '.') }},00 <b>{{ $pesanan->bendahara->type }}</b>
                    </td>
                </tr>
                <tr>
                    <td rowspan="4">6.</td>
                    <td>a. Identitas penyedia</td>
                    <td>{{ $pesanan->penyedia->company ?? '-' }}</td>
                </tr>
                <tr>
                    <td>b. NPWP</td>
                    <td>{{ $pesanan->penyedia->npwp ?? '-' }}</td>
                </tr>
                <tr>
                    <td>c. Alamat</td>
                    <td>{{ $pesanan->penyedia->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td>d. Nomor Rekening</td>
                    <td>{{ $pesanan->penyedia->account ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="" style="margin-top: 100px;
        margin-left: 60%;">
            Majalengka, {{ \Carbon\Carbon::parse($pesanan->prey)->translatedFormat('d F Y') }}<br>
            Pelaksana,<br><br><br><br><br>
            <strong
                style="text-decoration: underline;">{{ $pesanan->kepsek->name ?? 'Nama Kepala Sekolah' }}</strong><br>
            NIP. {{ $kepsek->nip ?? '-' }}
        </div>
    </div>

    <div class="page-break"></div>
    <div style="text-align: center;">
        <table width="100%" class="no-border" style="border: none; margin-bottom: 0;">
            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;
            ">
                    {{-- same dynamic logo for second header --}}
                    @php
                        $logoUrl = $logoUrl ?? null;
                        if (empty($logoUrl)) {
                            try {
                                $letterhead = \App\Models\Letterhead::first();
                            } catch (\Throwable $e) {
                                $letterhead = null;
                            }
                            if (!empty($letterhead) && !empty($letterhead->logo)) {
                                if (filter_var($letterhead->logo, FILTER_VALIDATE_URL)) {
                                    $logoUrl = $letterhead->logo;
                                } else {
                                    $logoUrl = \Illuminate\Support\Facades\Storage::url($letterhead->logo);
                                }
                            }
                        }
                        $logoUrl = $logoUrl ?: asset('jabar.png');
                    @endphp
                    <img src="{{ $logoUrl }}" width="100" style="margin-left:50px; display:block;" />
                </td>
                <td width="90%" style="text-align: center; vertical-align: middle;">
                    <strong style="font-size: 19px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                        <span style="font-size: 29px;">CABANG DINAS PENDIDIKAN WILAYAH IX</span><br>
                        <span style="font-size: 21px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                    <div style="font-size: 13px; line-height: 1.15; font-weight: normal; align-text: justify;">
                        Bidang Keahlian: Teknologi dan Rekayasa, Teknologi Informasi komunikasi, Bisnis dan
                        Manajemen<br>
                        Kampus 1: Jalan Sekolah Nomor 20 Desa Talagakulon Kecamatan Talaga Kabupaten Majalengka <br>
                        Kampus 2: Jalan Talaga Bantarujeg Desa Mekarraharja Kecamatan Talaga Kabupaten Majalengka<br>
                        Telpon ☎(0233) 319238 FAX ✉ (0233) 319238 POS 45463 NPSN: 20213872<br>

                        Website 🌐 <a href="www.smkn1talaga.sch.id">www.smkn1talaga.sch.id</a> – Email 📧 <a
                            href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                    </div>
                </td>
            </tr>

        </table>
        <svg viewBox="0 0 1000 6" width="100%" height="6" xmlns="http://www.w3.org/2000/svg">
            <!-- Garis atas: 2px -->
            <line x1="0" y1="1" x2="1000" y2="1" stroke="black" stroke-width="3" />

            <!-- Garis bawah: 0.3px, posisinya 0.7px di bawah garis atas (y1 = 3.7) -->
            <line x1="0" y1="3.7" x2="1000" y2="3.7" stroke="black" stroke-width="0." />
        </svg>
    </div>

    <div class="konten-utama">
        <div class="text-center">
            <h4 style="margin-bottom: 3px ">SURAT PESANAN</h4>
            <p style="margin-top: 7px">Nomor: {{ $pesanan->order_num }}</p>
        </div>

        <table class="tulisan" style="border: none;">
            <tr>
                <td style="width: 300px; padding-top: 0; padding-bottom: 0;">Nama Pekerjaan</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->kegiatan->name }}</td>
            </tr>
            <tr>
                <td style=" width:250px;padding-top: 0; padding-bottom: 0;">Kegiatan</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->kegiatan->name }}</td>
            </tr>

        </table>

        <div class="text-center">
            <h4></h4>
            <strong>SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</strong><br>
            <strong>TAHUN ANGGARAN {{ \Carbon\Carbon::parse($pesanan->created_at)->format('Y') }}</strong>
        </div>


        <table class="tulisan" style="border: none">
            <tr>
                <td style="padding-top: 0;">Yang bertanda tangan di bawah ini</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
            </tr>
            <tr>
                <td style="width: 300px; padding-top: 0; padding-bottom: 0;">Nama</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->kepsek->name }}</td>
            </tr>
            <tr>
                <td style="padding-top: 0; padding-bottom: 0;">Jabatan</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">Kepala Sekolah</td>
            </tr>
            <tr>
                <td style="padding-top: 0; padding-bottom: 0;">Alamat</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $kepsek->address }}</td>
            </tr>

            <tr>
                <td style=" padding-bottom: 0;">Selanjutnya disebut Pihak I</td>

            </tr>


            <tr>
                <td style="padding-top: 0; padding-bottom: 0;">Bersama ini memerintahkan</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
            </tr>

            <tr>
                <td style="width: 300px; padding-top: 0; padding-bottom: 0;">Nama Penyedia</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->penyedia->company }}</td>
            </tr>
            <tr>
                <td style="padding-top: 0; padding-bottom: 0;">Alamat</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->penyedia->address }}</td>
            </tr>
            <tr>
                <td style="padding-top: 0; padding-bottom: 0;">Yang dalam hal ini diwakili oleh</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->penyedia->delegation_name }} </td>
            </tr>
            <tr>
                <td colspan="2">Selanjutnya disebut Pihak II</td>
            </tr>
            <tr>
                <td style="width: 250px; padding-top: 0; padding-bottom: 0;">Pihak I memesan</td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style="padding-top: 0; padding-bottom: 0;">{{ $pesanan->kegiatan->name }}</td>
            </tr>
        </table>

        <p>Memperhatikan ketentuan-ketentuan sebagai berikut:</p>

        <table class="table-bordered" width="100%">
            <thead>
                <tr>
                    <th style="background-color: #d9d9d9;" width="5%">No</th>
                    <th style="background-color: #d9d9d9;" class="nowrap">Uraian/Jenis Barang/Spesifikasi</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Jumlah Barang</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Satuan</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Harga Satuan</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($pesanan->barang as $index => $item)
                    @php
                        $total += is_array($item) ? $item['total'] ?? 0 : $item->total ?? 0;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td class="nowrap" width="26%">{{ is_array($item) ? $item['name'] : $item->name }}</td>
                        <td style="text-align: center;" width="10%">
                            {{ is_array($item) ? $item['amount'] : $item->amount }}</td>
                        <td style="text-align: center">Unit</td>
                        <td style="text-align: center">
                            <div style="display: flex; align-items: center; justify-content: flex-start;">
                                <span style="min-width: 40px;">Rp.</span>
                                <span
                                    style="text-align: right; flex: 1;">{{ number_format(is_array($item) ? $item['price'] : $item->price, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="min-width: 40px;">Rp.</span>
                                <span
                                    style="text-align: right; flex: 1;">{{ number_format(is_array($item) ? $item['total'] : $item->total, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Total</strong></td>
                    <td style="text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="min-width: 40px;"><strong>Rp.</strong></span>
                            <span
                                style="text-align: right; flex: 1;"><strong>{{ number_format($total, 0, ',', '.') }}</strong></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="tulisan" style="border: none;">
            <tr>
                <td style="padding-top: 0; padding-bottom: 0;"><strong>Terbilang</strong></td>
                <td style="padding-top: 0; padding-bottom: 0;">:</td>
                <td style=" padding-top: 0; padding-bottom: 0;">{{ ucwords(terbilang($total)) }} Rupiah</td>
            </tr>

        </table>
        <div class="page-break-inside-avoid">
            <table style="width: 100%; border: none;" class="no-border">
                <tr>
                    <td style="width: 200px">Barang yang dipesan sebagai berikut :</td>
                </tr>
            </table>
            <table class="tulisan" style="border: none;">
                <tr>
                    <td style="padding-top:0; padding-bottom:0;">1. Tanggal barang diterima</td>
                    <td style="padding-top:0; padding-bottom:0;">:</td>
                    <td style="padding-top:0; padding-bottom:0;">
                        {{ \Carbon\Carbon::parse($pesanan->accepted)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding-top:0; padding-bottom:0;">2. Waktu Penyelesaian</td>
                    <td style="padding-top:0; padding-bottom:0;">:</td>
                    <td style="padding-top:0; padding-bottom:0;">
                        {{ \Carbon\Carbon::parse($pesanan->kegiatan->order)->diffInDays(\Carbon\Carbon::parse($pesanan->accepted)) }}
                        Hari Kalender
                    </td>
                </tr>
                <tr>
                    <td style="padding-top:0; padding-bottom:0;">3. Alamat Pengiriman Barang</td>
                    <td style="padding-top:0; padding-bottom:0;">:</td>
                    <td style="padding-top:0; padding-bottom:0;">{{ $kepsek->address }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <br>
            <div style="page-break-inside: avoid;">
                <table class="no-border "style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 60%"></td>
                        <td style="vertical-align:top; padding-top: 0; padding-bottom: 0;">
                            Majalengka, {{ \Carbon\Carbon::parse($pesanan->prey)->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; padding-top: 0; padding-bottom: 0;">
                            Untuk dan atas nama<br>
                            {{ $pesanan->penyedia->company }}
                        </td>
                        <td style="vertical-align:top; padding-top: 0; padding-bottom: 0;">
                            Untuk dan atas nama<br>
                            Kepala {{ $kepsek->school }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; padding-top:40px;">
                            <br>
                            <br>
                            <br>
                            <strong><u>{{ $pesanan->penyedia->delegation_name }}</u></strong><br>
                            {{ $pesanan->penyedia->delegate_position }}
                        </td>
                        <td style="vertical-align:top; padding-top:40px;">
                            <br>
                            <br>
                            <br>
                            <strong><u>{{ $pesanan->kepsek->name }}</u></strong><br>
                            NIP. {{ $kepsek->nip }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <style>
            @media print {
                .page-break-inside-avoid {
                    page-break-inside: avoid !important;
                }

                .page-break-inside-avoid {
                    break-inside: avoid !important;
                }
            }
        </style>
    </div>
    </div>
    <div class="page-break"></div>
    <div class="page with-bg">
        <h3 class="text-center">KWITANSI</h3>
        <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
            <span style="display:inline-block;">Nomor : {{ $pesanan->invoice_num ?? '-' }}
            </span>
        </div>
        <table style="width:100%; border:none; font-size:19px;" class="no-border">
            <tr>
                <td style="width:180px;">Telah diterima dari</td>
                <td style="width:10px;">:</td>
                <td>{{ $pesanan->bendahara->received_from ?? '-' }}</td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>:</td>
                <td>{{ ucwords(terbilang($total)) }} Rupiah</td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>:</td>
                <td>{{ $pesanan->kegiatan->name ?? '-' }}</td>
            </tr>
        </table>
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-top:30px;">
            <div style="min-width:180px;">
                <div
                    style="border:1px solid #000; padding:8px 18px; display:inline-block; font-weight:bold; font-size:15px; margin-bottom:20px; background-color: #d9d9d9;">
                    Rp. {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>
            <div style="text-align:left; min-width:300px; padding-left:42%;">
                Majalengka, {{ \Carbon\Carbon::parse($pesanan->prey)->translatedFormat('d F Y') }}<br>
                {{ $pesanan->penyedia->company ?? '-' }}<br><br><br><br><br><br><br><br>
                <span
                    style="font-weight:bold; text-decoration:underline;">{{ $pesanan->penyedia->delegation_name ?? '-' }}</span>
            </div>
        </div>
    </div>
    <table cellpadding="5" style="border: none; width: 100%;">
        <tr style="border: none;">
            <td style="vertical-align: top; text-align: left; width: 50%; border: none;">
                Lunas dibayar :
                {{ \Carbon\Carbon::parse($pesanan->paid)->translatedFormat('d F Y') }}<br>
                Setuju dibayar,<br>
                Kepala {{ $kepsek->school }}<br>
                <br><br><br><br><br>
                <b><u>{{ $pesanan->kepsek->name }}</u></b><br>
                NIP. {{ $kepsek->nip ?? '-' }}
            </td>
            <td style="vertical-align: top; text-align: left; width: 50%; border: none;">
                Tanggal Pemesanan :
                {{ \Carbon\Carbon::parse($pesanan->order_date)->translatedFormat('d F Y') }}<br>
                <br>
                Bendahara {{ $pesanan->bendahara->type ?? '-' }}<br>
                <br><br><br><br><br>
                <b><u> {{ $pesanan->bendahara->name ?? '-' }}</u></b><br>
                NIP. {{ $pesanan->bendahara->nip ?? '-' }}
            </td>
        </tr>
    </table>
    </div>
    </div>
    <div class="page-break"></div>
    <div class="page with-bg nota">
        <h3 class="text-center">NOTA</h3>
        <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
            <span style="display:inline-block;">Nomor :
                {{ $pesanan->note_num ?? '-' }}</span>
        </div>
        <!-- Header nota -->
        <table class="no-border" style="width:100%; font-size:19px; margin-bottom:10px; border: none;">
            <tr>
                <td style="width:80px;">Tn/Ny</td>
                <td style="width:10px;">:</td>
                <td>{{ $kepsek->school }}</td>
            </tr>
            <tr>
                <td>Di</td>
                <td>:</td>
                <td>{{ $kepsek->address }}</td>
            </tr>
        </table>

        <!-- Tabel detail barang -->
        <table class="data-table" style="width:100%; font-size:19px; border-collapse:collapse; margin-bottom:0;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="border:1px solid #000; padding:4px 8px; width: 10%;">Banyaknya</th>
                    <th style="border:1px solid #000; padding:4px 8px; width: 30%;">Nama Barang</th>
                    <th style="border:1px solid #000; padding:4px 8px; width: 30%;">Harga (Rp)</th>
                    <th style="border:1px solid #000; padding:4px 8px; width: 30%;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($pesanan->barang as $item)
                    @php
                        $jumlah = is_array($item) ? $item['total'] ?? 0 : $item->total ?? 0;
                        $harga = is_array($item) ? $item['price'] ?? 0 : $item->price ?? 0;
                        $amount = is_array($item) ? $item['amount'] ?? 0 : $item->amount ?? 0;
                        $total += $jumlah;
                    @endphp
                    <tr>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:center;">{{ $amount }}
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px;">
                            {{ is_array($item) ? $item['name'] : $item->name }}</td>
                        <td style="border:1px solid #000; padding:4px 8px;">
                            <div style="display:flex; justify-content:space-between;"><span>Rp.</span><span
                                    style="text-align:right; flex:1;">{{ number_format($harga, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px;">
                            <div style="display:flex; justify-content:space-between;"><span>Rp.</span><span
                                    style="text-align:right; flex:1;">{{ number_format($jumlah, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <!-- Total row langsung di bawah tabel barang, satu tabel dengan barang -->
                <tr>
                    <td colspan="3" style="border:1px solid #000; padding:4px 8px; text-align:center; width: 70%;">
                        <strong>Total</strong>
                    </td>
                    <td style="border:1px solid #000; padding:4px 8px; width: 28%;">
                        <div style="display:flex; justify-content:space-between;">
                            <span><strong>Rp.</strong></span><span
                                style="text-align:right; flex:1;"><strong>{{ number_format($total, 0, ',', '.') }}</strong></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- After-table-content: hanya tanda tangan, dan diberi style agar page-break-inside: avoid -->
        <div class="after-table-content avoid-break"
            style="margin-top:0; page-break-inside: avoid; break-inside: avoid;">

            <table style="width: 100%;  border-collapse: collapse; margin-top: 20px; border: none;" class="no-border">
                <!-- Baris tanggal -->
                <tr>
                    <td style=" width: 60%"></td>
                    <td style="text-align: left; ">
                        Majalengka, {{ \Carbon\Carbon::parse($pesanan->prey)->translatedFormat('d F Y') }}<br>
                    </td>
                </tr>

                <!-- Baris jabatan -->
                <tr>
                    <td style="text-align: left; ;">
                        Bendahara {{ $pesanan->bendahara->type ?? '-' }}
                    </td>
                    <td style="text-align: left; ">
                        Hormat Kami,
                    </td>
                </tr>

                <!-- Baris tanda tangan -->
                <tr>
                    <td style="text-align: left; padding-top: 50px;">
                        <strong style="text-decoration: underline;">
                            <br>
                            <br>
                            {{ $pesanan->bendahara->name ?? '-' }}
                        </strong><br>
                        NIP. {{ $pesanan->bendahara->nip ?? '-' }}
                    </td>
                    <td style="text-align: left; padding-top: 50px;">
                        <strong style="text-decoration: underline;">
                            <br>
                            <br>
                            {{ $pesanan->penyedia->delegation_name }}
                        </strong>
                    </td>
                </tr>
            </table>

        </div>

    </div>
    <!-- HALAMAN 1: BERITA ACARA SERAH TERIMA -->
    <div class="page berita-acara">
        <h3 class="text-center">BERITA ACARA SERAH TERIMA</h3>
        <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
            <span style="display:inline-block;">Nomor : {{ $pesanan->bast_num ?? '-' }}
            </span>
        </div>

        <!-- Data pihak pertama -->
        <p style="margin-bottom:10px;">
            Pada hari {{ strtolower(ucwords(\Carbon\Carbon::parse($pesanan->accepted)->isoFormat('dddd'))) }}
            tanggal
            {{ strtolower(ucwords(terbilang(\Carbon\Carbon::parse($pesanan->accepted)->format('d')))) }}
            bulan {{ strtolower(ucwords(\Carbon\Carbon::parse($pesanan->accepted)->isoFormat('MMMM'))) }} tahun
            {{ strtolower(ucwords(terbilang(\Carbon\Carbon::parse($pesanan->accepted)->format('Y')))) }}<br>
            Yang bertanda tangan di bawah ini :
        </p>

        <table class="no-border" style="width:100%; font-size:19px; margin-bottom:10px; border:none;">
            <tr>
                <td style="width:170px; padding-top:2px; padding-bottom:2px;">Nama</td>
                <td style="width:10px; padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penyedia->delegation_name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Jabatan</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penyedia->delegate_position ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Nama Perusahaan</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penyedia->company ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Alamat</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penyedia->address ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top:2px; padding-bottom:2px;">Sebagai pihak yang menyerahkan,
                    selanjutnya disebut PIHAK PERTAMA</td>
            </tr>
        </table>

        <!-- Data pihak kedua -->
        <table class="no-border" style="width:100%; font-size:19px; margin-bottom:10px; border:none;">
            <tr>
                <td style="width:170px; padding-top:2px; padding-bottom:2px;">Nama</td>
                <td style="width:10px; padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penerima->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Jabatan</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $pesanan->penerima->position ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Nama Instansi</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $kepsek->school }}</td>
            </tr>
            <tr>
                <td style="padding-top:2px; padding-bottom:2px;">Alamat</td>
                <td style="padding-top:2px; padding-bottom:2px;">:</td>
                <td style="padding-top:2px; padding-bottom:2px;">{{ $kepsek->address ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top:2px; padding-bottom:2px;">Sebagai pihak yang menerima,
                    selanjutnya disebut PIHAK KEDUA</td>
            </tr>
        </table>

        <!-- Rincian barang -->
        <p style="margin-bottom:10px; text-align:justify;">PIHAK PERTAMA menyerahkan hasil pekerjaan
            {{ $pesanan->kegiatan->name }}
            kepada PIHAK KEDUA, dan PIHAK KEDUA telah menerima pekerjaan {{ $pesanan->kegiatan->name }} tersebut dalam
            jumlah lengkap dengan kondisi sesuai rincian sebagai
            berikut:</p>
        <table class="data-table" style="width:100%; font-size:19px; border-collapse:collapse; margin-bottom:2px;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="border:1px solid #000; padding:4px 8px;">No</th>
                    <th style="border:1px solid #000; padding:4px 8px;">Nama Barang/Jasa</th>
                    <th style="border:1px solid #000; padding:4px 8px;">Jumlah Diserahkan</th>
                    <th style="border:1px solid #000; padding:4px 8px;">Jumlah Diterima</th>
                    <th style="border:1px solid #000; padding:4px 8px;">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->barang as $item)
                    <tr>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                            {{ $loop->iteration }}</td>
                        <td style="border:1px solid #000; padding:4px 8px;">
                            {{ is_array($item) ? $item['name'] : $item->name }}</td>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                            {{ is_array($item) ? $item['amount'] : $item->amount }}</td>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                            {{ is_array($item) ? $item['amount'] : $item->amount }}</td>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:center;">Baik</td>
                    </tr>
                @endforeach



            </tbody>
        </table>

        <!-- Penutup Berita Acara -->
        <div class="after-table-content avoid-break">
            <p style="margin-bottom:10px; text-align: justify;">Berita Acara Serah Terima ini
                berfungsi sebagai Bukti Serah Terima hasil
                pekerjaan kepada PIHAK KEDUA, untuk selanjutnya dipergunakan sebagaimana mestinya. Berita Acara
                Serah
                Terima ini dibuat dengan sebenarnya dan ditandatangani oleh kedua belah pihak.</p>

            <table class="no-border" style="margin-top:20px; width:100%; border: none;">
                <tr>
                    <td style="text-align:left; width:65%;">
                        PIHAK PERTAMA
                    </td>
                    <td style="text-align:left; width:35%;">
                        PIHAK KEDUA
                    </td>
                </tr>
                <tr>
                    <td style="height:64px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:left;">
                        <strong style="text-decoration:underline;">{{ $pesanan->penerima->name ?? '-' }}</strong><br>
                        NIP. {{ $pesanan->penerima->nip ?? '-' }}
                    </td>
                    <td style="text-align:left;">
                        <strong
                            style="text-decoration:underline;">{{ $pesanan->penyedia->delegation_name ?? '-' }}</strong><br>
                    </td>
                </tr>
            </table>
            <div style="display: flex; justify-content: center; margin-top:-70px;">
                <table class="no-border" style="width: 50%; border: none;">
                    <tr>
                        <td style="text-align: center;">
                            Mengetahui,<br>
                            Kepala Sekolah
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="display: flex; justify-content: center;">
                                <div style="text-align: left; vertical-align: bottom; margin-top: 70px;">
                                    <strong
                                        style="text-decoration:underline;">{{ $pesanan->kepsek->name ?? '-' }}</strong><br>
                                    NIP. {{ $kepsek->nip ?? '-' }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <!-- HALAMAN 2: FAKTUR -->
    <div class="page faktur">
        <h3 style="text-align:center; margin-bottom:20px;">FAKTUR</h3>
        <table style="width:100%; border:none; font-size:19px; margin-bottom:10px;">
            <tr>
                <td style="width:33%; vertical-align:top;" class="no-border-td">
                    <table style="border:none; font-size:18px; width:100%;">
                        <tr>
                            <td>Nomor Faktur</td>
                            <td>: {{ $pesanan->invoice_num ?? '007' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width:33%; vertical-align:top;" class="no-border-td">
                    <table style="border:none; font-size:18px; width:100%;">
                        <tr>
                            <td>Tanggal Penagihan</td>
                            <td>:
                                {{ \Carbon\Carbon::parse($pesanan->created_at ?? now())->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:33%; vertical-align:top;" class="no-border-td">
                    <table style="border:none; font-size:18px; width:100%;">
                        <tr>
                            <td>Batas Akhir Pembayaran</td>
                            <td>:
                                {{ $pesanan->billing ? \Carbon\Carbon::parse($pesanan->billing)->translatedFormat('d F Y') : '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width:100%; border:none; font-size:18px; margin-bottom:10px;" class="no-border">
            <thead>
                <tr>
                    <th style="width:50%; vertical-align:top; padding:0; text-align:left; border: none;">Ditagihkan
                        kepada</th>
                    <th
                        style="width:50%; vertical-align:top; padding:0; text-align:left; padding-left:15px; border: none;">
                        Ditagihkan Oleh</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:top; padding:0;">
                        <table style="width:100%; border:none; font-size:18px; margin-bottom:10px;" class="no-border">
                            <tr>
                                <td style="padding:0;">Nama Lengkap</td>
                                <td style="padding:0;">:&nbsp;</td>
                                <td style="padding:0;" class="break-cell">{{ $pesanan->kepsek->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:0;">Nama Perusahaan</td>
                                <td style="padding:0;">:</td>
                                <td style="padding:0;" class="break-cell">{{ $kepsek->school }}</td>
                            </tr>
                            <tr>
                                <td style="padding:0;">Alamat Lengkap</td>
                                <td style="padding:0;">:</td>
                                <td style="padding:0;" class="break-cell">{{ $kepsek->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:0;">Kode POS</td>
                                <td style="padding:0;">:</td>
                                <td style="padding:0;" class="break-cell">45463</td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align:top; padding:0;">
                        <table style="width:100%; border:none; font-size:18px; margin-bottom:10px; margin-left: 15px;"
                            class="no-border">
                            <tr>
                                <td style="padding:0;">Nama Lengkap</td>
                                <td style="padding:0;">:&nbsp;</td>
                                <td style="padding:0;" class="break-cell">
                                    {{ $pesanan->penyedia->delegation_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:0;">Alamat</td>
                                <td style="padding:0;">: </td>
                                <td style="padding:0;" class="break-cell">{{ $pesanan->penyedia->address ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0;">Kode POS</td>
                                <td style="padding:0;">: </td>
                                <td style="padding:0;" class="break-cell">45466</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
            </tr>
        </table>
        <table
            style="width:100%; border:1px solid #000; border-collapse:collapse; font-size:18px; margin-bottom:10px;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="border:1px solid #000; padding:4px 6px;">No</th>
                    <th style="border:1px solid #000; padding:4px 6px;">Deskripsi</th>
                    <th style="border:1px solid #000; padding:4px 6px;">Jumlah</th>
                    <th style="border:1px solid #000; padding:4px 6px;">Harga Satuan</th>
                    <th style="border:1px solid #000; padding:4px 6px;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->barang as $index => $item)
                    <tr>
                        <td style="border:1px solid #000; padding:4px 6px; text-align:center;">
                            {{ $loop->iteration }}
                        </td>
                        <td style="border:1px solid #000; padding:4px 6px;">{{ $item['name'] }}</td>
                        <td style="border:1px solid #000; padding:4px 6px; text-align:center;">
                            {{ $item->amount }}</td>
                        <td style="border:1px solid #000; padding:4px 6px;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="min-width:40px;">Rp.</span>
                                <span
                                    style="text-align:right; flex:1;">{{ number_format($item['price'], 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td style="border:1px solid #000; padding:4px 6px;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="min-width:40px;">Rp.</span>
                                <span
                                    style="text-align:right; flex:1;">{{ number_format($item['total'], 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @php
                    $totalHarga = collect($pesanan->barang)->sum(function ($item) {
                        return is_array($item) ? $item['total'] ?? 0 : $item->total ?? 0;
                    });
                @endphp
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="border:none;"></td>
                    <td style="border:1px solid #000; padding:4px 6px; text-align:left;">
                        <strong>Total Harga</strong>
                    </td>
                    <td style="border:1px solid #000; padding:4px 6px;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <span style="min-width:40px;"><strong>Rp.</strong></span>
                            <span
                                style="text-align:right; flex:1;"><strong>{{ number_format($totalHarga, 0, ',', '.') }}</strong></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border:none;"></td>
                    <td style="border:1px solid #000; padding:4px 6px; text-align:left;">Pajak</td>
                    <td style="border:1px solid #000; padding:4px 6px;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <span style="min-width:40px;">Rp.</span>
                            <span style="text-align:right; flex:1;">{{ $pesanan->tax }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border:none;"></td>
                    <td style="border:1px solid #000; padding:4px 6px; text-align:left;">Biaya Kirim</td>
                    <td style="border:1px solid #000; padding:4px 6px;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <span style="min-width:40px;">Rp.</span>
                            <span style="text-align:right; flex:1;">{{ $pesanan->shipping_cost }}</span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <table style="width:100%; margin-top:40px; border:none;" class="no-border">
            <tr>
                <td style="width:70%; vertical-align:top;">
                    <strong>Cara Pembayaran</strong><br>
                    Transfer via Bank {{ $pesanan->penyedia->bank }}<br>
                    a.n CV Techria Indonesia<br>
                    No. Rek : {{ $pesanan->penyedia->account ?? '-' }}<br>
                </td>
                <td style="width:30%; text-align:justify; vertical-align:top;">
                    CV Techria Indonesia<br>
                    {{ $pesanan->penyedia->delegate_position }},<br><br><br>
                    <strong>{{ $pesanan->penyedia->delegation_name ?? '-' }}</strong>
                </td>
            </tr>
        </table>

        <div style="width:100%; font-size:18px; margin-top:100px;">
            <em>*) Mohon lakukan pembayaran maksimal 15 hari setelah faktur dikirim</em>
        </div>
    </div>
    </div>

    <style>
        @media print {


            body {
                font-family: 'DejaVu Sans', 'Arial', sans-serif;
                font-size: 12pt;
                line-height: 1.2;
            }

            .konten-utama {
                padding-top: 0mm !important;
                padding-left: 0mm !important;
                padding-right: 0mm !important;
            }

            .page-break-inside-avoid {
                page-break-inside: avoid !important;
            }

            .avoid-break {
                page-break-inside: avoid;
                break-inside: avoid;
                -webkit-page-break-inside: avoid;
                display: block;
                margin-top: 5px;
            }

            .after-table-content.avoid-break {
                page-break-inside: avoid;
                break-inside: avoid;
                -webkit-page-break-inside: avoid;
                display: block;
                margin-top: 5px;
            }

            table.data-table {
                page-break-inside: auto;
                break-inside: auto;
            }

            table.data-table th,
            table.data-table td {
                page-break-inside: auto;
                break-inside: auto;
            }

            .page.berita-acara {
                page-break-after: always;
                break-after: page;
            }

            .page.nota {
                page-break-after: always;
                break-after: page;
            }

            .page.faktur {
                page-break-before: always;
                break-before: page;
            }

            .page:last-of-type {
                page-break-after: auto;
                break-after: auto;
            }
        }
    </style>





</body>

</html>

</html>
