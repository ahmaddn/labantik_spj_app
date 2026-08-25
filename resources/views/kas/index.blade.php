@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Pengelolaan Kas</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kas</li>
                    </ul>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon bg-success-light">
                                <i class="fas fa-arrow-down text-success fs-4"></i>
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount">
                                    Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <p class="inovices-all mt-2">Total Pemasukan</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon bg-danger-light">
                                <i class="fas fa-arrow-up text-danger fs-4"></i>
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount">
                                    Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <p class="inovices-all mt-2">Total Pengeluaran</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card inovices-card">
                    <div class="card-body">
                        <div class="inovices-widget-header">
                            <span class="inovices-widget-icon bg-info-light">
                                <i class="fas fa-wallet text-info fs-4"></i>
                            </span>
                            <div class="inovices-dash-count">
                                <div class="inovices-amount">
                                    Rp. {{ number_format($saldoKas, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <p class="inovices-all mt-2">Saldo Kas saat ini</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Riwayat Transaksi Kas</h5>
                <a href="{{ route('kas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>

            <div class="table-responsive">
                <table class="datatable table table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Kategori / Jenis</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Total</th>
                            <th>Penanggung Jawab (PIC)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->date)->translatedFormat('d F Y') }}</td>
                                <td>
                                    @if($data->type === 'pemasukan')
                                        <span class="badge bg-success"><i class="fas fa-arrow-down"></i> Pemasukan</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-arrow-up"></i> Pengeluaran</span>
                                    @endif
                                </td>
                                <td>{{ $data->category }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($data->nominal * $data->qty, 0, ',', '.') }}</td>
                                <td>{{ $data->pic }}</td>
                                <td>
                                    <a href="{{ route('kas.edit', $data->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kas.destroy', $data->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Belum ada data transaksi kas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
