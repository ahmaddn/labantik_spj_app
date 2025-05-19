@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Tambah Barang</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tambah Barang</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Form Barang</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('eksternal.barang.store') }}" method="POST">
                                @csrf

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
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        required>
                                </div>

                                {{-- Jumlah --}}
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control" name="amount" value="{{ old('amount') }}"
                                        required>
                                </div>

                                {{-- Harga --}}
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}"
                                        required>
                                </div>


                                <div class="text-end">
                                    <a href="{{ route('eksternal.barang.index') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('layouts.footer')
    </div>
@endsection
