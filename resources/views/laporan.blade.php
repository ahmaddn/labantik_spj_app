@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Laporan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-white rounded shadow">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-2">Laporan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                @foreach (['harian' => 'Harian', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan'] as $key => $label)
                                    <li class="nav-item">
                                        <form action="{{ route('riwayat') }}" method="POST"
                                            id="formKategori{{ $key }}">
                                            @csrf
                                            <input type="hidden" name="kategori" value="{{ $key }}">
                                            <input type="hidden" name="tanggal"
                                                value="{{ now()->format($key === 'tahunan' ? 'Y' : 'Y-m-d') }}">
                                            <button type="submit" class="nav-link {{ $kategori == $key ? 'active' : '' }}">
                                                {{ $label }}
                                            </button>
                                        </form>
                                    </li>
                                @endforeach

                            </ul>
                            <form action="{{ route('riwayat') }}" method="POST" id="formLaporan">
                                @csrf
                                <input type="hidden" name="kategori" value="{{ $kategori }}">

                                @if ($kategori === 'harian' || $kategori === 'bulanan')
                                    <div class="mt-3 mb-3">
                                        <label for="tanggal">Tanggal:</label>
                                        <input type="date" name="tanggal" class="form-control form-control-sm w-25"
                                            value="{{ $tanggal }}"
                                            onchange="document.getElementById('formLaporan').submit()">
                                    </div>
                                @elseif ($kategori === 'tahunan')
                                    <div class="mt-3 mb-3">
                                        <label for="tanggal">Tahun:</label>
                                        <select name="tanggal" class="form-control form-control-sm w-25"
                                            onchange="document.getElementById('formLaporan').submit()">
                                            @foreach ($list_tahun as $tahun)
                                                <option value="{{ $tahun }}"
                                                    {{ $tahun == $tanggal ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </form>


                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th>No</th>
                                            <th>Kegiatan</th>
                                            <th>Penyedia</th>
                                            <th>Penerima</th>
                                            <th>Barang</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $key => $item)
                                            <tr class="border-b">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->kegiatan->name }}</td>
                                                <td>{{ $item->penyedia->company }}</td>
                                                <td>{{ $item->penerima->name }}</td>
                                                <td>{{ $item->barang->pluck('name')->join(' | ') ?? '-' }}</td>
                                                <td>{{ $item->paid }}</td>
                                                <td> <a href="{{ route('eksternal.pesanan.export', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada
                                                    data laporan.</td>
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
