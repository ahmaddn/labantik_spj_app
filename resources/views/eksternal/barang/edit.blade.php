@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Barang</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Barang</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Edit Barang</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('eksternal.barang.update', $barang->id) }}" method="POST">
                            @csrf
                            @method('PUT')

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

                            {{-- Nama Barang --}}
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $barang->name) }}" required>
                            </div>

                            {{-- Jumlah --}}
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" class="form-control" name="amount"
                                    value="{{ old('amount', $barang->amount) }}" required>
                            </div>

                            {{-- Harga --}}
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="price"
                                    value="{{ old('price', $barang->price) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Kategori Satuan</label>
                                <div class="dropdown">
                                    <input name="unit" type="text" class="form-control dropdown-toggle"
                                        data-bs-toggle="dropdown" placeholder="Pilih atau Ketik Kategori" id="carDropdown"
                                        value="{{ old('unit', $barang->unit) }}">
                                    <ul class="dropdown-menu" style="width:100%">
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('carDropdown').value='Volvo'">Volvo</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('carDropdown').value='Saab'">Saab</a></li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('carDropdown').value='Mercedes'">Mercedes</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('carDropdown').value='Audi'">Audi</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('eksternal.barang.index') }}" class="btn btn-warning">Batal</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
