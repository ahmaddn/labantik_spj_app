@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item active">Edit Pesanan</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Pesanan</h5>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <div class="card-body">

                <form action="{{ route('eksternal.pesanan.editBarang') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Pesanan</label>
                                <input type="text" name="order_num" class="form-control"
                                    value="{{ $pesanan->order_num }}">
                                @error('order_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Invoice</label>
                                <input type="text" name="invoice_num" class="form-control"
                                    value="{{ $pesanan->invoice_num }}">
                                @error('invoice_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Nota</label>
                                <input type="text" name="note_num" class="form-control" value="{{ $pesanan->note_num }}">
                                @error('note_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Berita Acara Serah Terima</label>
                                <input type="text" name="bast_num" class="form-control" value="{{ $pesanan->bast_num }}">
                                @error('bast_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kepala Sekolah</label>
                                <select name="kepsekID" class="form-control" {{ $kepsek->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $kepsek->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Kepsek --' }}
                                    </option>
                                    @foreach ($kepsek as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id === ($pesanan->kepsek->id ?? '') ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach

                                </select>
                                @error('BendaharaID')
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
                                            {{ $item->id === ($pesanan->bendahara->id ?? '') ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
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
                                            {{ $item->id == ($pesanan->penerima->id ?? '') ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('penerimaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kegiatan</label>
                                <select name="kegiatanID" class="form-control"
                                    {{ $kegiatan->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ $kegiatan->isEmpty() ? '-- Tidak ada data --' : '-- Pilih Kegiatan --' }}
                                    </option>
                                    @foreach ($kegiatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == ($pesanan->kegiatan->id ?? '') ? 'selected' : '' }}>
                                            {{ $item->name }}
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
                                            {{ $item->id == ($pesanan->penyedia->id ?? '') ? 'selected' : '' }}>
                                            {{ $item->company }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penyediaID')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Pesanan</label>
                                <input type="date" name="order_date" class="form-control" min="2025-01-01"
                                    value="{{ $pesanan->order_date }}">
                                @error('order_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Penagihan</label>
                                <input type="date" name="billing" class="form-control" value="{{ $pesanan->billing }}">
                                @error('billing')
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
                            <div class="form-group">
                                <label>Tanggal Diterima</label>
                                <input type="date" name="accepted" class="form-control" min="2025-01-01"
                                    value="{{ $pesanan->accepted }}">
                                @error('accepted')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Titimangsa</label>
                                <input type="date" name="prey" class="form-control" min="2025-01-01"
                                    value="{{ $pesanan->prey }}">
                                @error('prey')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jumlah Jenis Barang</label>
                                <input type="number" name="type_num" class="form-control"
                                    value="{{ $pesanan->type_num }}">
                                @error('type_num')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Pajak</label>
                                <div class="input-group">
                                    <input type="number" name="tax" class="form-control" step="0.01"
                                        min="0" max="100"
                                        value="{{ old('tax', session('edit_pesanan.tax_percentage', 0)) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('tax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Ongkos Kirim</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" name="shipping_cost" class="form-control"
                                        value="{{ old('shipping_cost', $pesanan->shipping_cost) }}">
                                </div>
                                @error('shipping_cost')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Penanggung Jawab (PIC)</label>
                                <input type="text" name="pic" class="form-control"
                                    value="{{ old('pic', $pesanan->pic) }}">
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Lanjut</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
