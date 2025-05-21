@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ul>
                </div>
            </div>
        </div>
         {{-- Validasi Error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

        <form action="{{ route('eksternal.pesanan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Invoice</label>
                        <input type="number" name="invoice_num" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kegiatan</label>
                        <select name="kegiatanID" class="form-control" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($kegiatan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penyedia</label>
                        <select name="penyediaID" class="form-control" required>
                            <option value="">-- Pilih Penyedia --</option>
                            @foreach($penyedia as $item)
                                <option value="{{ $item->id }}">{{ $item->company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penerima</label>
                        <select name="penerimaID" class="form-control" required>
                            <option value="">-- Pilih Penerima --</option>
                            @foreach($penerima as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Barang</label>
                        <select name="barangID" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Budget</label>
                        <input type="number" name="budget" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Total Uang</label>
                        <input type="number" name="money_total" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Uang</label>
                        <input type="text" name="money" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Order</label>
                        <input type="date" name="order" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Bayar</label>
                        <input type="date" name="paid" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>

    </div>
    @include('layouts.footer')
</div>
@endsection
