@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Transaksi Kas</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kas.index') }}">Kas</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0" style="border-radius: 8px;">
                    <div class="card-header bg-white py-3 border-bottom" style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <h5 class="card-title mb-0" style="font-weight: 700; color: #232b38; font-size: 16px;">
                            <i class="fas fa-wallet text-primary me-2"></i> Form Tambah Transaksi Kas
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kas.store') }}" method="POST">
                            @csrf

                            {{-- Tipe Transaksi --}}
                            <div class="form-group mb-3">
                                <label class="form-label font-weight-bold" style="color: #495057; font-weight: 600;">Tipe Transaksi</label>
                                <select class="form-control form-select" name="type" id="transaction_type" style="border-radius: 6px; padding: 10px 15px;">
                                    <option value="pemasukan" {{ old('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Masuk ke Kas)</option>
                                    <option value="pengeluaran" {{ old('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Keluar dari Kas)</option>
                                </select>
                                @error('type')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="form-group mb-3">
                                <label class="form-label" style="color: #495057; font-weight: 600;">Tanggal</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}" style="border-radius: 6px; padding: 10px 15px;">
                                @error('date')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Kategori / Jenis --}}
                            <div class="form-group mb-3">
                                <label class="form-label" id="category_label" style="color: #495057; font-weight: 600;">Jenis Transaksi</label>
                                <input type="text" class="form-control" name="category" value="{{ old('category') }}" placeholder="Contoh: Pembelian Alat Tulis, Kas Masuk SPJ, dll." style="border-radius: 6px; padding: 10px 15px;">
                                @error('category')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Qty & Nominal Side-by-Side --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" style="color: #495057; font-weight: 600;">Jumlah (Qty)</label>
                                        <input type="number" class="form-control" name="qty" value="{{ old('qty', 1) }}" min="1" style="border-radius: 6px; padding: 10px 15px;">
                                        @error('qty')
                                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label" style="color: #495057; font-weight: 600;">Nominal (per Item)</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="background-color: #f1f3f5; border-right: none; border-radius: 6px 0 0 6px;">Rp.</span>
                                            <input type="number" name="nominal" class="form-control" value="{{ old('nominal') }}" min="0" style="border-radius: 0 6px 6px 0; padding: 10px 15px;">
                                        </div>
                                        @error('nominal')
                                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Penanggung Jawab --}}
                            <div class="form-group mb-4">
                                <label class="form-label" style="color: #495057; font-weight: 600;">Penanggung Jawab (PIC)</label>
                                <input type="text" class="form-control" name="pic" value="{{ old('pic') }}" placeholder="Nama penanggung jawab" style="border-radius: 6px; padding: 10px 15px;">
                                @error('pic')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end pt-2 border-top">
                                <a href="{{ route('kas.index') }}" class="btn btn-light me-2" style="border-radius: 6px; padding: 8px 20px; font-weight: 600; background-color: #f8f9fa; border: 1px solid #ddd; color: #495057;">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 6px; padding: 8px 25px; font-weight: 600;">
                                    Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('transaction_type');
            const categoryLabel = document.getElementById('category_label');

            function updateLabels() {
                if (typeSelect.value === 'pemasukan') {
                    categoryLabel.innerText = 'Sumber Pemasukan / Kategori';
                } else {
                    categoryLabel.innerText = 'Jenis Pengeluaran / Kategori';
                }
            }

            typeSelect.addEventListener('change', updateLabels);
            updateLabels(); // Initial run
        });
    </script>
@endsection
