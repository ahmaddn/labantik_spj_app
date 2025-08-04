@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Kegiatan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tambah Kegiatan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('eksternal.kegiatan.addKegiatan') }}" method="POST">
                            @csrf


                            {{-- Nama Kegiatan --}}
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal Order --}}
                            <div class="form-group">
                                <label>Tanggal Order</label>
                                <input type="date" class="form-control" name="order" value="{{ old('order') }}"
                                    min="2025-01-01">
                                @error('order')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Batas Akhir Pembayaran --}}
                            <div class="form-group">
                                <label>Batas Akhir Pembayaran</label>
                                <input type="date" class="form-control" name="deadline" value="{{ old('deadline') }}"
                                    min="2025-01-01">
                                @error('deadline')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- Info --}}
                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" name="info" rows="3">{{ old('info') }}</textarea>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="text-end">
                                <a href="{{ route('eksternal.kegiatan.index') }}" class="btn btn-warning">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
