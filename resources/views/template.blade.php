<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumen Perencanaan</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 14px; }
        table, th, td { border: 1px solid black; border-collapse: collapse; }
        th, td { padding: 6px; vertical-align: top; }
        .no-border td { border: none; }
        .text-center { text-align: center; }
        .signature { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <div style="text-align: center;">
    <table width="100%" class="no-border" style="border: none;">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ asset('jabar.png') }}" width="90">
            </td>
            <td style="text-align: center;
                   ">
                <strong style="font-size: 14px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>
                DINAS PENDIDIKAN<br>
                CABANG DINAS PENDIDIKAN WILAYAH IX<br>
                <span style="font-size: 16px;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 TALAGA</span></strong><br>
                Jalan Sekolah Nomor 20 Telpon ☎ (0233) 319238<br>
                FAX ✉ (0233) 319238 Website 🌐 www.smkn1talaga.sch.id – Email 📧 <a href="mailto:admin@smkn1talaga.sch.id">admin@smkn1talaga.sch.id</a><br>
                Desa Talagakulon Kec. Talaga Kab. Majalengka 45463
            </td>
        </tr>
    </table>
    <hr style="border: 2px solid black;">
</div>
 
    <h3 class="text-center">DOKUMEN PERENCANAAN</h3>

    <table class="no-border" style="border: none;">
        <tr>
            <td>Nama satuan Pendidikan</td>
            <td>: SMK Negeri 1 Talaga</td>
        </tr>
        <tr>
            <td>Alamat Satuan Pendidikan</td>
            <td>: Jl. Sekolah No 20 Talagakulon (0233) 319238 Talaga - Majalengka</td>
        </tr>
    </table>

    <br>

    <table class="no-border" style="border: none;">
        <tr>
            <td>Kategori Barang dan Jasa</td>
            <td>: Belanja Peralatan Komputer dan Lainnya</td>
        </tr>
    </table>

    <br>

    <table style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Keterangan</th>
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
                <td>{{ \Carbon\Carbon::parse($pesanan->order)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Lokasi serah terima</td>
                <td>SMKN 1 Talaga</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Alokasi anggaran</td>
                <td>Rp. {{ number_format($pesanan->money_total, 0, ',', '.') }},00 <b>BOS</b></td>
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

    <div class="signature" style="margin: right 50px;">
        Majalengka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        Pelaksana,<br><br><br><br>
        <strong style="text-decoration: underline;">{{ $kepsek->name ?? 'Nama Kepala Sekolah' }}</strong><br>
        NIP. {{ $kepsek->nip ?? '-' }}
    </div>
</body>
</html>
