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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('eksternal.pesanan.store') }}" method="POST">
                    @csrf
                    @for ($i = 0; $i < $type_num; $i++)
                        <div class="row mb-3 pb-3 border-bottom form-item">
                            <div class="col-md-6 mb-2">
                                <label>Nama Barang {{ $i + 1 }}</label>
                                <input type="text" name="items[{{ $i }}][name]" class="form-control"
                                    value="{{ old("items.$i.name") }}">
                                @error("items.$i.name")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Harga Barang {{ $i + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" name="items[{{ $i }}][price]"
                                        class="form-control harga" value="{{ old("items.$i.price") }}">
                                </div>
                                @error("items.$i.price")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Jumlah Barang {{ $i + 1 }}</label>
                                <input type="number" name="items[{{ $i }}][amount]" class="form-control jumlah"
                                    value="{{ old("items.$i.amount") }}">
                                @error("items.$i.amount")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Satuan Barang {{ $i + 1 }}</label>
                                <input type="text" name="items[{{ $i }}][unit]" class="form-control"
                                    value="{{ old("items.$i.unit") }}">
                                @error("items.$i.unit")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Total Barang {{ $i + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" name="items[{{ $i }}][total]"
                                        class="form-control total" readonly inputmode="numeric"
                                        value="{{ old("items.$i.total") }}">
                                </div>
                            </div>
                        </div>
                    @endfor

                    <div class="mt-3">
                        <a href="{{ route('eksternal.pesanan.addSession') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
