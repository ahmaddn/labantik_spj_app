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
            margin-left: 60px;
            font-size: 19px;
        }

        .page {
            height: 100%;
            position: relative;
            font-size: 19px;
        }

        .with-bg {
            background-image: url('{{ asset('assets/img/bg.jpg') }}');
            background-size: 794px 1127px;
            /* presisi A4 */
            background-repeat: no-repeat;
            background-position: top center;
            height: 1127px;
            width: 794px;
            box-sizing: border-box;
            padding: 40px;
            /* atur jarak teks dari pinggir */
            font-size: 19px;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 3cm 2cm;
            font-size: 19px;
        }
    </style>
</head>

<body>

    <table width="100%" class="no-border" style="border: none; margin-bottom: 0;">
        <tr>
            <td width="10%" style="text-align: center; vertical-align: middle;
            ">
                <img src="{{ asset('jabar.png') }}" width="100" style="margin-left:50px; display:block;" />
            </td>
            <td width="90%" style="text-align: center; vertical-align: middle;">
                <strong style="font-size: 19px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                    DINAS PENDIDIKAN<br>
                    <span style="font-size: 29px;">CABANG DINAS PENDIDIKAN WILAYAH IX</span><br>
                    <span style="font-size: 21px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                <span style="font-size: 14px;">Jalan Sekolah Nomor 20 Telpon ☎ (0233) 319238<br>
                    FAX ✉ (0233) 319238 Website 🌐 www.smkn1talaga.sch.id – Email 📧 <a
                        href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                    Desa Talagakulon Kec. Talaga Kab. Majalengka 45463</span>
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
                <td>: SMK Negeri 1 Talaga <br>
                    : {{ $kepsek->address }}<br>
                    : {{ $pesanan->kegiatan->name ?? '-' }}</td>

            </tr>

        </table>



        <table style="width: 90%;">
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
                    <td>{{ $pesanan->barang->name ?? '-' }}</td>
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
                    <td>SMKN 1 Talaga</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Alokasi anggaran</td>
                    <td>Rp. {{ number_format($pesanan->budget, 0, ',', '.') }},00 <b>BOS</b></td>
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
            Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Pelaksana,<br><br><br><br>
            <strong style="text-decoration: underline;">{{ $kepsek->name ?? 'Nama Kepala Sekolah' }}</strong><br>
            NIP. {{ $kepsek->nip ?? '-' }}
        </div>
    </div>

    <div class="page-break"></div>
    <div style="text-align: center;">
        <table width="100%" class="no-border" style="border: none; margin-bottom: 0;">
            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;
            ">
                    <img src="{{ asset('jabar.png') }}" width="100" style="margin-left:50px; display:block;" />
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <strong style="font-size: 19px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                        DINAS PENDIDIKAN<br>
                        <span style="font-size: 29px;">CABANG DINAS PENDIDIKAN WILAYAH IX</span><br>
                        <span style="font-size: 21px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                    <span style="font-size: 14px;">Jalan Sekolah Nomor 20 Telpon ☎ (0233) 319238<br>
                        FAX ✉ (0233) 319238 Website 🌐 www.smkn1talaga.sch.id – Email 📧 <a
                            href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                        Desa Talagakulon Kec. Talaga Kab. Majalengka 45463</span>
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
            <h4>SURAT PESANAN</h4>
            <p>Nomor: {{ $pesanan->invoice_num }}</p>
        </div>

        <table class="tulisan" style="border: none">
            <tr>
                <td>Nama Pekerjaan<br>
                    Kegiatan</td>
                <td>: {{ $pesanan->kegiatan->name }}<br>
                    : {{ $pesanan->kegiatan->name }}</td>
            </tr>

        </table>

        <div class="text-center">
            <h4></h4>
            <strong>SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</strong><br>
            <strong>TAHUN ANGGARAN 2024</strong>
        </div>

        <p>Yang bertanda tangan di bawah ini :</p>
        <table class="tulisan" style="border: none">
            <tr>
                <td>Nama<br>Jabatan<br>Alamat</td>
                <td>: {{ $kepsek->name }}<br>: Kepala Sekolah<br>: {{ $kepsek->address }}</td>
            </tr>

            <tr>
                <td colspan="2">Selanjutnya disebut Pihak I</td>
            </tr>
        </table>

        <p>Bersama ini memerintahkan :</p>
        <table style="border: none" class="tulisan">
            <tr>
                <td>Nama Penyedia<br>Alamat<br>Yang dalam hal ini diwakili oleh</td>
                <td>: {{ $pesanan->penyedia->company }}<br>: {{ $pesanan->penyedia->address }}<br>:
                    {{ $pesanan->penyedia->delegation_name }}</td>
            </tr>

            <tr>
                <td colspan="2">Selanjutnya disebut Pihak II</td>
            </tr>
            <tr>
                <td>Pihak 1 Memesan</td>
                <td>: {{ $pesanan->kegiatan->name }}</td>
            </tr>
        </table>

        <p>Memperhatikan ketentuan-ketentuan sebagai berikut:</p>

        <table class="table-bordered" width="90%">
            <thead>
                <tr>
                    <th style="background-color: #d9d9d9" width="5%">No</th>
                    <th style="background-color: #d9d9d9;" class="nowrap">Uraian/Jenis Barang/Spesifikasi</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Jumlah Barang</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Satuan</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Harga Satuan</th>
                    <th style="background-color: #d9d9d9; text-align: center;">Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $item)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td class="nowrap" width="19%">{{ $item->name }}</td>
                        <td style="text-align: center;" width="10%">{{ $item->amount }}</td>
                        <td style="text-align: center">Unit</td>
                        <td style="text-align: center">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: center">Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Total</strong></td>
                    <td><strong>Rp. {{ number_format(collect($barang)->sum('total'), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        <p><strong>Terbilang :</strong> {{ ucwords(terbilang(collect($barang)->sum('total'))) }} Rupiah</p>


        <p>Barang yang dipesan sebagai berikut :</p>
        <table class="tulisan" style="border: none;">
            <tr>
                <td>1. Tanggal barang diterima<br>2. Waktu Penyelesaian<br>3. Alamat Pengiriman Barang</td>
                <td>: {{ \Carbon\Carbon::parse($pesanan->accepted)->translatedFormat('d F Y') }}<br>
                    :
                    {{ \Carbon\Carbon::parse($pesanan->kegiatan->order)->diffInDays(\Carbon\Carbon::parse($pesanan->accepted)) }}
                    Hari Kalender<br>
                    : {{ $kepsek->address }}
                </td>

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
            <table class="no-border" style="width: 100%; border: none;">
                <tr>
                    <td colspan="2" style="vertical-align:top;">
                        <div style="display:flex; justify-content:space-between; width:100%;">
                            <div style="text-align:left;">
                                Untuk dan atas nama<br>
                                {{ $pesanan->penyedia->company }}
                            </div>
                            <div style="text-align:right;">
                                Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                                Untuk dan atas nama<br>
                                Kepala SMKN 1 Talaga
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align:top; padding-top:40px;">
                        <div style="display:flex; justify-content:space-between; width:100%;">
                            <div style="text-align:left;">
                                <strong><u>{{ $pesanan->penyedia->delegation_name }}</u></strong><br>
                                {{ $pesanan->penyedia->delegate_position }}
                            </div>
                            <div style="text-align:right;">
                                <strong><u>{{ $kepsek->name }}</u></strong><br>
                                NIP. {{ $kepsek->nip }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </div>
    <div class="page-break"></div>
    <div class="page with-bg">
        <div class="content">
            <h3 class="text-center">KWITANSI</h3>
            <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
                <span style="display:inline-block;">Nomor : {{ $pesanan->invoice_num ?? '-' }}
                    /{{ $pesanan->penyedia->company ?? '-' }}/Kwitansi/IV/{{ date('Y') }}</span>
            </div>
            <table style="width:100%; border:none; font-size:19px;" class="no-border">
                <tr>
                    <td style="width:180px;">Telah diterima dari</td>
                    <td style="width:10px;">:</td>
                    <td>{{ $pesanan->penyedia->company ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Uang Sejumlah</td>
                    <td>:</td>
                    <td>{{ ucwords(terbilang($pesanan->barangs->sum('total'))) }} Rupiah</td>
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
                        style="border:1px solid #000; padding:8px 18px; display:inline-block; font-weight:bold; font-size:15px; margin-bottom:20px;">
                        Rp. {{ number_format($pesanan->barangs->sum('total'), 0, ',', '.') }}</div>
                </div>
                <div style="text-align:left; min-width:300px; padding-left:42%;">
                    Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    {{ $pesanan->penyedia->company ?? '-' }}<br><br><br><br><br><br>
                    <span
                        style="font-weight:bold; text-decoration:underline;">{{ $pesanan->penyedia->delegation_name ?? '-' }}</span>
                </div>
            </div>
            <div
                style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:40px; flex-direction:column;">
                <div style="display:flex; justify-content:space-between; width:100%; margin-bottom:10px;">
                    <span style="font-size:18px;">Lunas dibayar :
                        {{ \Carbon\Carbon::parse($pesanan->paid)->translatedFormat('d F Y') }}</span>
                    <span style="font-size:18px; margin-right: 80px;">Tanggal Pemesanan :
                        {{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('d F Y') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; width:100%;">
                    <div style="width:45%; text-align:left;">
                        Setuju dibayar,<br>
                        Kepala SMK Negeri 1 Talaga
                    </div>
                    <div style="width:45%; text-align:left; margin-left:260px;">
                        Bendahara {{ $pesanan->bendahara->type ?? '-' }}
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; width:100%; margin-top:60px;">
                    <div style="width:45%; text-align:left;">
                        <strong style="text-decoration:underline;">{{ $kepsek->name ?? '-' }}</strong><br>
                        NIP. {{ $kepsek->nip ?? '-' }}
                    </div>
                    <div style="width:45%; text-align:right;">
                        <strong style="text-decoration:underline;">{{ $pesanan->bendahara->name ?? '-' }}</strong><br>
                        NIP. {{ $pesanan->bendahara->nip ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page with-bg">
        <div class="content">
            <h3 class="text-center" style="margin-bottom:0;">NOTA</h3>
            <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
                <span style="display:inline-block;">Nomor : {{ $pesanan->invoice_num ?? '-' }}
                    /{{ $pesanan->penyedia->company ?? '-' }}/Nota/IV/{{ date('Y') }}</span>
            </div>
            <table style="width:100%; border:none; font-size:19px; margin-bottom:10px;" class="no-border">
                <tr>
                    <td style="width:80px;">Tn/Ny</td>
                    <td style="width:10px;">:</td>
                    <td>SMK Negeri 1 Talaga</td>
                </tr>
                <tr>
                    <td>Di</td>
                    <td>:</td>
                    <td>{{ $kepsek->address }}
                    <td>
                </tr>
            </table>
            <table style="width:100%; font-size:19px; border-collapse:collapse; margin-bottom:20px;">
                <thead>
                    <tr style="background:#f5f5f5;">
                        <th style="border:1px solid #000; padding:4px 8px;">Banyaknya</th>
                        <th style="border:1px solid #000; padding:4px 8px;">Nama Barang</th>
                        <th style="border:1px solid #000; padding:4px 8px;">Harga (Rp)</th>
                        <th style="border:1px solid #000; padding:4px 8px;">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                        <tr>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                                {{ $item->amount }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px;">
                                {{ $item->name }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:right;">Rp.
                                {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:right;">Rp.
                                {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="border:1px solid #000; padding:4px 8px; text-align:right;">
                            <strong>Total</strong>
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px; text-align:right;"><strong>Rp.
                                {{ number_format(collect($barang)->sum('total'), 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:40px;">
                <div style="width:45%; text-align:left;">
                    Bendahara {{ $pesanan->bendahara->type ?? '-' }}
                    <br><br><br>
                    <strong style="text-decoration:underline;">{{ $pesanan->bendahara->name ?? '-' }}</strong><br>
                    NIP. {{ $pesanan->bendahara->nip ?? '-' }}
                </div>
                <div style="width:45%; text-align:right;">
                    Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Hormat Kami,<br><br><br>
                    <strong style="text-decoration:underline;">{{ $pesanan->penyedia->delegation_name }}</strong>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="page with-bg">
            <h3 class="text-center" style="margin-bottom:0;">BERITA ACARA SERAH TERIMA</h3>
            <div style="width:100%; text-align:center; margin-bottom:10px; font-size:19px;">
                <span style="display:inline-block;">Nomor : {{ $pesanan->invoice_num ?? '-' }}
                    /{{ $pesanan->penyedia->company ?? '-' }}/BA/IV/{{ date('Y') }}</span>
            </div>
            <p style="margin-bottom:10px;">
                Pada hari {{ strtolower(ucwords(\Carbon\Carbon::parse($pesanan->created_at)->isoFormat('dddd'))) }}
                tanggal
                {{ strtolower(ucwords(terbilang(\Carbon\Carbon::parse($pesanan->created_at)->format('d')))) }}
                bulan {{ strtolower(ucwords(\Carbon\Carbon::parse($pesanan->created_at)->isoFormat('MMMM'))) }}
                tahun
                {{ strtolower(ucwords(terbilang(\Carbon\Carbon::parse($pesanan->created_at)->format('Y')))) }}
                <br>
                Yang bertanda tangan di bawah ini :
            </p>
            <table style="width:100%; border:none; font-size:19px; margin-bottom:10px;" class="no-border">
                <tr>
                    <td style="width:120px;">Nama</td>
                    <td style="width:10px;">:</td>
                    <td>{{ $pesanan->penyedia->delegation_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $pesanan->penyedia->delegate_position ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td>{{ $pesanan->penyedia->company ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $pesanan->penyedia->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3">Sebagai pihak yang menyerahkan, selanjutnya disebut PIHAK PERTAMA</td>
                </tr>
            </table>
            <table style="width:100%; border:none; font-size:19px; margin-bottom:10px;" class="no-border">
                <tr>
                    <td style="width:120px;">Nama</td>
                    <td style="width:10px;">:</td>
                    <td>{{ $pesanan->penerima->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $pesanan->penerima->position ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama Instansi</td>
                    <td>:</td>
                    <td>SMK Negeri 1 Talaga</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $kepsek->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3">Sebagai pihak yang menerima, selanjutnya disebut PIHAK KEDUA</td>
                </tr>
            </table>
            <p style="margin-bottom:10px;">PIHAK PERTAMA menyerahkan hasil pekerjaan Belanja Peralatan Komputer dan
                Lainnya kepada PIHAK KEDUA, dan PIHAK KEDUA telah menerima hasil pekerjaan Belanja Peralatan
                Komputer
                dan Lainnya tersebut dalam jumlah lengkap dengan kondisi sesuai rincian sebagai berikut:</p>
            <table style="width:100%; font-size:19px; border-collapse:collapse; margin-bottom:20px;">
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
                    @foreach ($pesanan->barangs as $index => $item)
                        <tr>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                                {{ $loop->iteration }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px;">{{ $item->name }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                                {{ $item->amount }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                                {{ $item->amount }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 8px; text-align:center;">
                                {{ $pesanan->condition }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin-bottom:10px;">Berita Acara Serah Terima ini berfungsi sebagai Bukti Serah Terima hasil
                pekerjaan kepada PIHAK KEDUA, untuk selanjutnya dipergunakan sebagaimana mestinya. Berita Acara
                Serah
                Terima ini dibuat dengan sebenarnya dan ditandatangani oleh kedua belah pihak.</p>

            <table class="no-border" style="margin-top:80px; width:100%; border: none;">
                <tr>
                    <td style="text-align:left; width:50%;">
                        PIHAK PERTAMA
                    </td>
                    <td style="text-align:right; width:50%;">
                        PIHAK KEDUA
                    </td>
                </tr>
                <tr>
                    <td style="height:40px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:left;">
                        <strong style="text-decoration:underline;">{{ $pesanan->penerima->name ?? '-' }}</strong><br>
                        NIP. {{ $pesanan->penerima->nip ?? '-' }}
                    </td>
                    <td style="text-align:right;">
                        <strong
                            style="text-decoration:underline;">{{ $pesanan->penyedia->delegation_name ?? '-' }}</strong><br>
                    </td>
                </tr>
            </table>
            <table class="no-border" style="margin-top:60px; width:100%; page-break-inside: avoid; border: none;">
                <tr>
                    <td style="text-align:center;">
                        Mengetahui,<br>
                        Kepala Sekolah<br><br>
                        <strong style="text-decoration:underline;">{{ $kepsek->name ?? '-' }}</strong><br>
                        NIP. {{ $kepsek->nip ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-break"></div>
        <div class="page-break"></div>
        <div class="page with-bg">
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
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <strong>Ditagihkan Kepada</strong><br>
                        Nama Lengkap : {{ $kepsek->name ?? 'UDIN WAHYUDIN, S.IP., M.Si' }}<br>
                        Nama Perusahaan : SMK Negeri 1 Talaga<br>
                        Alamat Lengkap : {{ $kepsek->address ?? '-' }}<br>
                        Kode POS : 45463<br>
                    </td>
                    <td style="width:50%; vertical-align:top;">
                        <strong>Ditagihkan Oleh</strong><br>
                        Nama Lengkap : {{ $pesanan->penyedia->delegation_name ?? '' }}<br>
                        Alamat : {{ $pesanan->penyedia->address ?? '' }}<br>
                        Kode POS : 45466
                    </td>
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
                    @foreach ($barang as $item)
                        <tr>
                            <td style="border:1px solid #000; padding:4px 6px; text-align:center;">
                                {{ $loop->iteration }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 6px;">{{ $item->name }}</td>
                            <td style="border:1px solid #000; padding:4px 6px; text-align:center;">
                                {{ $item->amount }}
                            </td>
                            <td style="border:1px solid #000; padding:4px 6px; text-align:right;">Rp.
                                {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="border:1px solid #000; padding:4px 6px; text-align:right;">Rp.
                                {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="border:1px solid #000; padding:4px 6px; text-align:right;">
                            <strong>Total Harga</strong>
                        </td>
                        <td style="border:1px solid #000; padding:4px 6px; text-align:right;"><strong>Rp.
                                {{ number_format(collect($barang)->sum('total'), 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border:1px solid #000; padding:4px 6px; text-align:right;">Pajak
                        </td>
                        <td style="border:1px solid #000; padding:4px 6px; text-align:right;">Rp. 0</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border:1px solid #000; padding:4px 6px; text-align:right;">Biaya
                            Kirim</td>
                        <td style="border:1px solid #000; padding:4px 6px; text-align:right;">Rp. 0</td>
                    </tr>
                </tfoot>
            </table>
            <table style="width:100%; margin-top:40px; border:none;" class="no-border">
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <strong>Cara Pembayaran</strong><br>
                        Transfer via Bank {{ $pesanan->penyedia->bank }}<br>
                        a.n CV Techria Indonesia<br>
                        No. Rek : {{ $pesanan->penyedia->account ?? '-' }}<br>
                    </td>
                    <td style="width:50%; text-align:right; vertical-align:top;">
                        CV Techria Indonesia<br>
                        Marketing,<br><br><br>
                        <strong style="font-size:15px; ">{{ $pesanan->penyedia->delegation_name ?? '-' }}</strong>
                    </td>
                </tr>
            </table>
            <div style="width:100%; font-size:18px; margin-top:10px;">
                <em>*) Mohon lakukan pembayaran maksimal 15 hari setelah faktur dikirim</em>
            </div>
        </div>
</body>

</html>

</html>
