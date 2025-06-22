@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Data Penerimaan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item active">Tambah Data Penerimaan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Penyerahan dan Penerimaan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('eksternal.submission.store') }}" method="POST">
                            @csrf
                            @method('PUT')
                            {{-- Nomor Faktur --}}
                            <div class="form-group">
                                <label>Nomor Faktur</label>
                                <select class="form-control" name="pesananID" readonly>
                                    <option value="{{ $pesanan->id }}" selected>{{ $pesanan->invoice_num }}
                                    </option>
                                </select>
                            </div>

                            {{-- Tanggal Diterima --}}
                            <div class="form-group">
                                <label>Tanggal Diterima</label>
                                <input type="datetime" class="form-control" name="accepted" value="{{ old('accepted') }}"
                                    min="2025-01-01">
                                @error('accepted')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal Penagihan --}}
                            <div class="form-group">
                                <label>Tanggal Penagihan</label>
                                <input type="date" class="form-control" name="billing" value="{{ old('billing') }}"
                                    min="2025-01-01">
                                <small class="text text-info">(Boleh Kosong)</small><br>
                                @error('billing')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jumlah --}}
                            <div class="form-group">
                                <label>Jumlah Barang yang Diterima</label>
                                <input type="number" class="form-control" name="amount" value="{{ old('amount') }}">
                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Kondisi</label>
                                <div class="dropdown">
                                    <input name="condition" type="text" class="form-control dropdown-toggle"
                                        data-bs-toggle="dropdown" placeholder="Pilih atau Ketik Kondisi"
                                        id="conditionDropdown">
                                    <ul class="dropdown-menu" style="width:100%">
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('conditionDropdown').value='Baik'">Baik</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="document.getElementById('conditionDropdown').value='Buruk'">Buruk</a>
                                        </li>
                                    </ul>
                                </div>
                                @error('condition')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="text-end">
                                <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-warning">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
