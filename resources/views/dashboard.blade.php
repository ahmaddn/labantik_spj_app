@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade-show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        </style>
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome, {{ Auth::user()->namalengkap }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon">
                                <img src="assets/img/icons/invoices-icon1.svg" alt=""
                                    style="width: 40px; height: 40px; object-fit: contain;" />
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount">
                                    Rp.{{ number_format($totals, 0, ',', '.') }}
                                </div>

                            </div>
                        </div>
                        <p class="inovices-all small">Jumlah
                            Semua Transaksi
                            <span>
                                <a data-bs-toggle="collapse" href="#jumlahSemuaTransaksi" aria-expanded="false"
                                    aria-controls="jumlahSemuaTransaksi"class="btn btn-sm bg-success-light ">
                                    <i class="fas fa-asterisk"></i>
                                </a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon">
                                <img src="assets/img/icons/invoices-icon2.svg " alt=""
                                    style="width: 40px; height: 40px; object-fit: contain;" />
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount">Rp.{{ number_format($totalkeuntungan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div>
                            <p class="inovices-all small">
                                Jumlah Keuntungan
                                <span>
                                    <a data-bs-toggle="collapse" href="#jumlahKeuntungan" aria-expanded="false"
                                        aria-controls="jumlahKeuntungan"class="btn btn-sm bg-success-light ">
                                        <i class="fas fa-asterisk"></i>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon">
                                <img src="assets/img/icons/invoices-icon4.svg" alt=""
                                    style="width: 40px; height: 40px; object-fit: contain;" />
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount"
                                    style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    Rp.{{ number_format($totalpengeluaran, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <p class="inovices-all">
                            Jumlah Pengeluaran
                            <span>
                                <a data-bs-toggle="collapse" href="#jumlahPengeluaran" aria-expanded="false"
                                    aria-controls="jumlahPengeluaran"class="btn btn-sm bg-success-light ">
                                    <i class="fas fa-asterisk"></i>
                                </a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon">
                                <img src="assets/img/icons/invoices-icon3.svg" alt=""
                                    style="width: 40px; height: 40px; object-fit: contain;" />
                            </span>
                            <div class="inovices-dash-count">
                                @php
                                    $labaBersih = $totalkeuntungan - $totalpengeluaran;
                                @endphp
                                <div class="inovices-amount"
                                    style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    Rp.{{ number_format($labaBersih, 0, ',', '.') }}
                                </div>

                            </div>
                        </div>
                        <p class="inovices-all">Jumlah Laba Bersih
                            <span>
                                <a href="{{ route('report.excel') }}" class="btn btn-sm bg-success-light " target="_blank">
                                    <i class="fas fa-asterisk"></i>
                                </a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="collapse hidden" id="jumlahSemuaTransaksi">
                <div class="card">
                    <h5 class="card-header">Detail Semua Transaksi</h5>
                    <div class="card-body">
                        <table class="datatable table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTransaksi as $total)
                                    <tr>
                                        <td>{{ $total->kegiatan->name ?? 'Kegiatan Tidak Diketahui' }}</td>
                                        <td>Rp{{ number_format($total->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="collapse hidden" id="jumlahKeuntungan">
                <div class="card">
                    <h5 class="card-header">Detail Keuntungan</h5>
                    <div class="card-body">
                        <table class="datatable table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTransaksi as $total)
                                    <tr>
                                        <td>{{ $total->kegiatan->name ?? 'Kegiatan Tidak Diketahui' }}</td>
                                        <td>Rp{{ number_format($total->profit, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="collapse hidden" id="jumlahPengeluaran">
                <div class="card">
                    <h5 class="card-header">Detail Keuntungan</h5>
                    <div class="card-body">
                        <table class="datatable table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPengeluaran as $total)
                                    <tr>
                                        <td>{{ $total->type ?? 'Kegiatan Tidak Diketahui' }}</td>
                                        <td>Rp{{ number_format($total->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
