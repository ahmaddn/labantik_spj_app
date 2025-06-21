@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Pesanan</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('eksternal.pesanan.update', $pesanan->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Invoice</label>
                                <input type="number" name="invoice_num" class="form-control"
                                    value="{{ $pesanan->invoice_num }}">
                                @error('invoice_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kegiatan</label>
                                <select name="kegiatanID" class="form-control" {{ $kegiatan->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $kegiatan->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Kegiatan --' }}
                                    </option>
                                    @foreach ($kegiatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $pesanan->kegiatan->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kegiatanID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Penyedia</label>
                                <select name="penyediaID" class="form-control"
                                    {{ $penyedia->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $penyedia->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Penyedia --' }}
                                    </option>
                                    @foreach ($penyedia as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $pesanan->penyedia->id ? 'selected' : '' }}>
                                            {{ $item->company }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penyediaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Penerima</label>
                                <select name="penerimaID" class="form-control"
                                    {{ $penerima->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $penerima->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Penerima --' }}
                                    </option>
                                    @foreach ($penerima as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $pesanan->penerima->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('penerimaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Barang</label>
                                <select name="barangID" class="form-control" {{ $barang->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $barang->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Barang --' }}
                                    </option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $pesanan->barang->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barangID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Budget</label>
                                <input type="number" name="budget" class="form-control" value="{{ $pesanan->budget }}">
                                @error('budget')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Bayar</label>
                                <input type="date" name="paid" class="form-control" min="2025-01-01"
                                    value="{{ $pesanan->paid }}">
                                @error('paid')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Perbarui</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
