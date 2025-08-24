@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Daftar Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesanan</li>
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
            <div class="flex justify-between mb-4">
                <a href="{{ route('eksternal.pesanan.addSession') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Pesanan
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title">Daftar Pesanan</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center">
                                    <thead>
                                        <tr>
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
                                        @foreach ($pesanan as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->kegiatan->name ?? '-' }}</td>
                                                <td>{{ $item->penyedia->company ?? '-' }}</td>
                                                <td>{{ $item->penerima->name ?? '-' }}</td>
                                                <td class="text-wrap" style="white-space: normal">
                                                    <ul>
                                                        @foreach ($item->barang->pluck('name') as $barang)
                                                            <li>- {{ $barang ?? '-' }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>

                                                <td>{{ \Carbon\Carbon::parse($item->paid)->translatedFormat('d F Y') }}</td>
                                                <td class="px-4 py-2">
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#centermodal-{{ $item->id }}"><i
                                                            class="fas fa-money-bill"></i></button>
                                                    <a href="{{ route('eksternal.pesanan.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('eksternal.pesanan.export', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>

                                                    <form action="{{ route('eksternal.pesanan.delete', $item->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>

                                                </td>
                                            </tr>
                                            <div class="modal fade" id="centermodal-{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Pembayaran Pesanan</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <!-- Form dengan ID unik -->
                                                        <form
                                                            action="{{ route('eksternal.pesanan.saveTotal', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="totalPesanan_{{ $item->id }}"
                                                                        class="form-label">Total Pesanan</label>
                                                                    <input type="number" class="form-control"
                                                                        id="totalPesanan_{{ $item->id }}"
                                                                        value="{{ $item->total }}" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="persenKeuntungan_{{ $item->id }}"
                                                                        class="form-label">Persen Keuntungan (%)</label>
                                                                    <input type="number"
                                                                        class="form-control persen-keuntungan"
                                                                        id="persenKeuntungan_{{ $item->id }}"
                                                                        placeholder="Masukkan persen keuntungan"
                                                                        step="0.01" min="0"
                                                                        data-item-id="{{ $item->id }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="totalKeuntungan_{{ $item->id }}"
                                                                        class="form-label">Total dengan Keuntungan</label>
                                                                    <input type="number" class="form-control"
                                                                        id="totalKeuntungan_{{ $item->id }}"
                                                                        name="profit"
                                                                        value="{{ old('profit', $item->profit ?? '') }}"
                                                                        placeholder="Total akan dihitung otomatis"
                                                                        min="0">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($pesanan->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data
                                                    pesanan.</td>
                                            </tr>
                                        @endif
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
