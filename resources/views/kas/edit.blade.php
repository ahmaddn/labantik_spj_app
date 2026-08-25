@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Transaksi Kas</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kas.index') }}">Kas</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title text-white mb-0">Form Edit Transaksi Kas</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kas.update', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Tipe Transaksi --}}
                            <div class="form-group mb-3">
                                <label class="form-label font-weight-bold">Tipe Transaksi</label>
                                <select class="form-control form-select" name="type" id="transaction_type">
                                    <option value="pemasukan" {{ old('type', $transaction->type) == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Masuk ke Kas)</option>
                                    <option value="pengeluaran" {{ old('type', $transaction->type) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Keluar dari Kas)</option>
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date', $transaction->date->format('Y-m-d')) }}">
                                @error('date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Kategori / Jenis --}}
                            <div class="form-group mb-3">
                                <label class="form-label" id="category_label">Jenis Transaksi</label>
                                <input type="text" class="form-control" name="category" value="{{ old('category', $transaction->category) }}">
                                @error('category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Qty --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Qty</label>
                                <input type="number" class="form-control" name="qty" value="{{ old('qty', $transaction->qty) }}" min="1">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nominal --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Nominal (per Item)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" name="nominal" class="form-control" value="{{ old('nominal', $transaction->nominal) }}" min="0">
                                </div>
                                @error('nominal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Penanggung Jawab --}}
                            <div class="form-group mb-4">
                                <label class="form-label">Penanggung Jawab (PIC)</label>
                                <input type="text" class="form-control" name="pic" value="{{ old('pic', $transaction->pic) }}">
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('kas.index') }}" class="btn btn-warning">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
