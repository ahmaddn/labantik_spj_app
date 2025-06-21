<?php \Carbon\Carbon::setLocale('id'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dokumen Perencanaan</title>
    <style>
        body {
            font-family: 'Calibri', 'Arial', sans-serif;

            font-size: 14px;
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


        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

        }

        .tulisan td {
            line-height: 20px;
            border: none;
        }

        th,
        td {
            padding: 6px;
            vertical-align: top;
        }

        .no-border td {
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .page-break {
            page-break-before: always;
        }

        .konten-utama {
            margin-left: 60px;
        }

        .page {

            height: 100%;
            position: relative;
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
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 3cm 2cm;
        }
    </style>
</head>

<body>

    <table width="100%" class="no-border" style="border: none;">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ asset('jabar.png') }}" width="90">
            </td>
            <td style="text-align: center;">
                <strong style="font-size: 14px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                    DINAS PENDIDIKAN<br>
                    CABANG DINAS PENDIDIKAN WILAYAH IX<br>
                    <span style="font-size: 16px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                Jalan Sekolah Nomor 20 Telpon ☎ (0233) 319238<br>
                FAX ✉ (0233) 319238 Website 🌐 www.smkn1talaga.sch.id – Email 📧 <a
                    href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                Desa Talagakulon Kec. Talaga Kab. Majalengka 45463
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
                    : Jl. Sekolah No 20 Talagakulon (0233) 319238 Talaga - Majalengka<br>
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

        <div class="signature">
            Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Pelaksana,<br><br><br><br>
            <strong style="text-decoration: underline;">{{ $kepsek->name ?? 'Nama Kepala Sekolah' }}</strong><br>
            NIP. {{ $kepsek->nip ?? '-' }}
        </div>
    </div>

    <div class="page-break"></div>

    <div style="text-align: center;">
        <table width="100%" class="no-border" style="border: none;">
            <tr>
                <td width="15%" style="text-align: center;">
                    <img src="{{ asset('jabar.png') }}" width="90">
                </td>
                <td style="text-align: center;">
                    <strong style="font-size: 14px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                        DINAS PENDIDIKAN<br>
                        CABANG DINAS PENDIDIKAN WILAYAH IX<br>
                        <span style="font-size: 16px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                    Jalan Sekolah Nomor 20 Telpon ☎ (0233) 319238<br>
                    FAX ✉ (0233) 319238 Website 🌐 www.smkn1talaga.sch.id – Email 📧 <a
                        href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                    Desa Talagakulon Kec. Talaga Kab. Majalengka 45463
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

        <table class="table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #d9d9d9" width="">No</th>
                    <th style="background-color: #d9d9d9">Uraian/Jenis Barang/Spesifikasi</th>
                    <th style="background-color: #d9d9d9">Jumlah Barang</th>
                    <th style="background-color: #d9d9d9">Satuan</th>
                    <th style="background-color: #d9d9d9">Harga Satuan</th>
                    <th style="background-color: #d9d9d9">Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($barang as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>Unit</td>
                        <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                @endforeach
                <td colspan="5"><strong>Total</strong></td>
                <td><strong>Rp. {{ number_format($barang->sum('total'), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        <div class="page-break"></div>
        <p><strong>Terbilang :</strong> {{ ucwords(terbilang($barang->sum('total'))) }} Rupiah</p>


        <p>Barang yang dipesan sebagai berikut :</p>
        <table class="tulisan" style="border: none;">
            <tr>
                <td>1. Tanggal barang diterima<br>2. Waktu Penyelesaian<br>3. Alamat Pengiriman Barang</td>
                <td>: {{ \Carbon\Carbon::parse($pesanan->accepted_date)->translatedFormat('d F Y') }}<br>: Hari
                    Kalender<br>: {{ $kepsek->address }}
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
        <table class="no-border" style="width: 100%; border: none;">
            <tr>
                <td colspan="2" style="text-align: right;">Majalengka, 5 April 2023</td>
            </tr>
            <tr>
                <td style="text-align: left;">Untuk dan atas nama<br>{{ $pesanan->penyedia->company }}</td>
                <td style="text-align: right;">Untuk dan atas nama<br>Kepala SMKN 1 Talaga</td>
            </tr>
            <tr>
                <td style="text-align: left;"></td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td colspan="2"><br><br><br></td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <strong><u>{{ $pesanan->penyedia->delegation_name }}</u></strong><br>
                    {{ $pesanan->penyedia->delegate_position }}
                </td>
                <td style="text-align: right;">
                    <strong><u>{{ $kepsek->name }}</u></strong><br>
                    NIP. {{ $kepsek->nip }}
                </td>
            </tr>
        </table>
    </div>
    </div>
    <div class="page-break"></div>
    <div class="page with-bg">
        <div class="content">
            <h3 class="text-center">KWITANSI</h3>
            <table style="border: none" class="tulisan">
                <tr>
                    <td>Telah diterima dari<br>Uang sejumlah<br>Untuk Pembayaran</td>
                    <td>: {{ $pesanan->penyedia->company }}<br>: {{ ucwords(terbilang($barang->sum('total'))) }} <br>:
                        {{ $pesanan->penyedia->delegation_name }}</td>
                </tr>
            </table>
        </div>

        <table class="table-bordered">
            <tr>
                </td><strong>Rp. {{ number_format($barang->sum('total'), 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>


</body>

</html>
