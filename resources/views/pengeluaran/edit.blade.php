@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Pengeluaran</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tambah Pengeluaran</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Pengeluaran</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            {{-- Tanggal --}}
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="date"
                                    value="{{ $pengeluaran->date ?? old('date') }}">
                                @error('date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jenis Pengeluaran --}}
                            <div class="form-group">
                                <label>Jenis Pengeluaran</label>
                                <input type="text" class="form-control" name="type"
                                    value="{{ $pengeluaran->type ?? old('type') }}">
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Qty --}}
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control" name="qty"
                                    value="{{ $pengeluaran->qty ?? old('qty') }}">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nominal --}}
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" name="nominal" class="form-control"
                                        value="{{ $pengeluaran->nominal ?? old('nominal') }}">
                                </div>
                                @error('nominal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Penanggung Jawab --}}
                            <div class="form-group">
                                <label>Penanggung Jawab</label>
                                <input type="text" class="form-control" name="pic"
                                    value="{{ $pengeluaran->pic ?? old('pic') }}">
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('pengeluaran.index') }}" class="btn btn-warning">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
