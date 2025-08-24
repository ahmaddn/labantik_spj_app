@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Data Laporan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Laporan</li>
                    </ul>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade-show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card p-4 bg-white rounded shadow">
            <!-- Filter Form -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Filter Laporan</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('report.index') }}" class="row g-3 align-items-end"
                        id="filterForm">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}" onchange="updateExportLink()">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                value="{{ request('end_date') }}" onchange="updateExportLink()">
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-primary me-3">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('report.index') }}" class="btn btn-secondary me-3">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                                <!-- Export Button dengan ID untuk update dinamis -->
                                <a href="{{ route('report.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                                    id="exportLink" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function updateExportLink() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const exportLink = document.getElementById('exportLink');

                    let baseUrl = '{{ route('report.export') }}';
                    let params = [];

                    if (startDate) {
                        params.push('start_date=' + startDate);
                    }

                    if (endDate) {
                        params.push('end_date=' + endDate);
                    }

                    if (params.length > 0) {
                        exportLink.href = baseUrl + '?' + params.join('&');
                    } else {
                        exportLink.href = baseUrl;
                    }
                }
            </script>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-2">Daftar Laporan</h5>
                            <p class="card-text mb-0">
                                Ini adalah daftar laporan yang telah dicatat
                                @if (request('start_date') || request('end_date'))
                                    @if (request('start_date') && request('end_date'))
                                        dari {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                        sampai {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                                    @elseif(request('start_date'))
                                        dari {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                    @elseif(request('end_date'))
                                        sampai {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                                    @endif
                                @endif
                                .
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Nominal</th>
                                        <th>Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentBalance = 0;
                                    @endphp
                                    @forelse ($pesanan as $data)
                                        @php
                                            $currentBalance += $data->total;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d M Y', strtotime($data->order_date)) }}</td>
                                            <td>{{ $data->kegiatan->name }}</td>
                                            <td>{{ $data->penerima->name ?? '-' }}</td>
                                            <td>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp ' . number_format($data->profit, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-gray-500">
                                                @if (request('start_date') || request('end_date'))
                                                    Tidak ada data laporan pada periode yang dipilih
                                                @else
                                                    Belum Ada Data Laporan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
