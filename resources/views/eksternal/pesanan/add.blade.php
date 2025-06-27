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
                        <li class="breadcrumb-item active">Tambah Pesanan</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Pesanan</h5>
            </div>
            <div class="card-body">

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('eksternal.pesanan.session') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Invoice</label>
                                <input type="number" name="invoice_num" class="form-control"
                                    value="{{ old('invoice_num') }}">
                                @error('invoice_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Pesanan</label>
                                <input type="number" name="order_num" class="form-control" value="{{ old('order_num') }}">
                                @error('order_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Nota</label>
                                <input type="number" name="note_num" class="form-control" value="{{ old('note_num') }}">
                                @error('note_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Berita Acara Serah Terima</label>
                                <input type="number" name="bast_num" class="form-control" value="{{ old('bast_num') }}">
                                @error('bast_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bendahara</label>
                                <select name="bendaharaID" class="form-control"
                                    {{ $bendahara->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $bendahara->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Bendahara --' }}
                                    </option>
                                    @foreach ($bendahara as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('bendaharaID') === $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('BendaharaID')
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
                                            {{ old('penerimaID') === $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penerimaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kegiatan</label>
                                <select name="kegiatanID" class="form-control"
                                    {{ $kegiatan->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $kegiatan->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Kegiatan --' }}
                                    </option>
                                    @foreach ($kegiatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('kegiatanID') === $item->id ? 'selected' : '' }}>{{ $item->name }}
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
                                            {{ old('penyediaID') === $item->id ? 'selected' : '' }}>{{ $item->company }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penyediaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Penagihan</label>
                                <input type="date" name="billing" class="form-control" value="{{ old('billing') }}">
                                @error('billing')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Bayar</label>
                                <input type="date" name="paid" class="form-control" min="2025-01-01"
                                    value="{{ old('paid') }}">
                                @error('paid')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Diterima</label>
                                <input type="date" name="accepted" class="form-control" min="2025-01-01"
                                    value="{{ old('accepted') }}">
                                @error('accepted')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jumlah Jenis Barang</label>
                                <input type="number" name="type_num" class="form-control" value="{{ old('type_num') }}">
                                @error('type_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
