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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade-show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4 bg-white rounded shadow">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Tombol Import Excel -->
                <button type="button" class="btn btn-success text-white px-4 py-2 rounded hover:bg-green-600 me-2"
                    data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-excel me-2"></i> Import Excel
                </button>

                <!-- Modal Import Excel -->
                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('eksternal.pesanan.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="excel_file" class="form-label">Pilih File Excel</label>
                                        <input type="file" class="form-control" id="excel_file" name="excel_file"
                                            accept=".xlsx,.xls,.csv" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="{{ route('eksternal.pesanan.addSession') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    <i class="fas fa-plus me-2"></i> Tambah Pesanan
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
                                            <tr
                                                class="{{ !$item->kegiatanID || !$item->penyediaID || !$item->penerimaID || !$item->bendaharaID || !$item->kepsekID ? 'table-warning' : '' }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $item->kegiatan->name ?? 'Belum diisi' }}
                                                    @if (!$item->kegiatanID)
                                                        <small class="text-muted d-block"><i
                                                                class="fas fa-exclamation-triangle text-warning"></i> Perlu
                                                            dilengkapi</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->penyedia->company ?? 'Belum diisi' }}
                                                    @if (!$item->penyediaID)
                                                        <small class="text-muted d-block"><i
                                                                class="fas fa-exclamation-triangle text-warning"></i> Perlu
                                                            dilengkapi</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->penerima->name ?? 'Belum diisi' }}
                                                    @if (!$item->penerimaID)
                                                        <small class="text-muted d-block"><i
                                                                class="fas fa-exclamation-triangle text-warning"></i> Perlu
                                                            dilengkapi</small>
                                                    @endif
                                                </td>
                                                <td class="text-wrap" style="white-space: normal">
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($item->barang->take(3) as $barang)
                                                            <li>{{ $barang->name ?? '-' }} ({{ $barang->amount }}
                                                                {{ $barang->unit }})</li>
                                                        @endforeach
                                                        @if ($item->barang->count() > 3)
                                                            <li class="text-muted">... dan {{ $item->barang->count() - 3 }}
                                                                item lainnya</li>
                                                        @endif
                                                    </ul>
                                                </td>

                                                <td>{{ \Carbon\Carbon::parse($item->paid)->translatedFormat('d F Y') }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if (!$item->kegiatanID || !$item->penyediaID || !$item->penerimaID || !$item->bendaharaID || !$item->kepsekID)
                                                        <span class="badge bg-warning text-dark mb-2 d-block">
                                                            <i class="fas fa-edit"></i> Perlu Edit
                                                        </span>
                                                    @endif

                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#centermodal-{{ $item->id }}"
                                                            title="Pengaturan Keuntungan">
                                                            <i class="fas fa-money-bill"></i>
                                                        </button>
                                                        <a href="{{ route('eksternal.pesanan.edit', $item->id) }}"
                                                            class="btn btn-sm btn-outline-info" title="Edit Pesanan">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('eksternal.pesanan.export', $item->id) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank"
                                                            title="Print">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <form action="{{ route('eksternal.pesanan.delete', $item->id) }}"
                                                            method="POST" class="d-inline-block"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="centermodal-{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Pembayaran Pesanan</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- Form dengan ID unik -->
                                                        <form
                                                            action="{{ route('eksternal.pesanan.saveProfit', $item->id) }}"
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

        <!-- Modal Import Excel -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h4 class="modal-title">
                            <i class="fas fa-file-excel me-2"></i>
                            Import Data Barang dari Excel
                        </h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('eksternal.pesanan.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="excel_file" class="form-label fw-bold">Pilih File Excel</label>
                                <input type="file" class="form-control" id="excel_file" name="excel_file"
                                    accept=".xlsx,.xls" required>
                                <div class="form-text">Format yang didukung: .xlsx, .xls (maksimal 2MB)</div>
                            </div>
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Format Excel yang diharapkan:
                                </h6>
                                <div class="row">
                                    <div class="col-3 fw-bold">Kolom A:</div>
                                    <div class="col-9">Nama Barang/Jasa</div>
                                    <div class="col-3 fw-bold">Kolom B:</div>
                                    <div class="col-9">Qty (Jumlah)</div>
                                    <div class="col-3 fw-bold">Kolom C:</div>
                                    <div class="col-9">Satuan</div>
                                    <div class="col-3 fw-bold">Kolom D:</div>
                                    <div class="col-9">Harga Rp.</div>
                                </div>
                                <hr class="my-2">
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Pastikan baris pertama adalah header dan data dimulai dari baris kedua.
                                </small>
                            </div>
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Catatan Penting:
                                </h6>
                                <ul class="mb-0">
                                    <li>Setelah import, data pesanan akan muncul di tabel dengan status <span
                                            class="badge bg-warning text-dark">Perlu Edit</span></li>
                                    <li>Anda perlu mengedit pesanan tersebut untuk melengkapi data Kegiatan, Penyedia,
                                        Penerima, dll.</li>
                                    <li>Data barang (nama, qty, satuan, harga) sudah otomatis terisi dari Excel</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Tutup
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload me-2"></i>Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle percentage calculation for profit
            document.querySelectorAll('.persen-keuntungan').forEach(function(input) {
                input.addEventListener('input', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const totalPesanan = parseFloat(document.getElementById('totalPesanan_' +
                        itemId).value) || 0;
                    const persenKeuntungan = parseFloat(this.value) || 0;
                    const totalKeuntungan = totalPesanan + (totalPesanan * persenKeuntungan / 100);

                    document.getElementById('totalKeuntungan_' + itemId).value = Math.round(
                        totalKeuntungan);
                });
            });
        });
    </script>
@endsection
