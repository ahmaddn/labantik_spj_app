@extends('layouts.app')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Kegiatan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Kegiatan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Edit Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('eksternal.kegiatan.update', $kegiatan->id) }}" method="POST">
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

                            {{-- Nama Kegiatan --}}
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $kegiatan->name) }}">
                            </div>

                            {{-- Tanggal Order --}}
                            <div class="form-group">
                                <label>Tanggal Order</label>
                                <input type="date" class="form-control" name="order"
                                    value="{{ old('order', $kegiatan->order) }}" min="2025-01-01">
                            </div>

                            {{-- Tanggal Diterima --}}
                            <div class="form-group">
                                <label>Tanggal Diterima</label>
                                <input type="date" class="form-control" name="accepted"
                                    value="{{ old('accepted', $kegiatan->accepted) }}" min="2025-01-01">
                            </div>

                            {{-- Waktu Selesai --}}
                            <div class="form-group">
                                <label>Waktu Selesai</label>
                                <input type="time" class="form-control" name="completed"
                                    value="{{ old('completed', $kegiatan->completed) }}">
                            </div>

                            {{-- Info --}}
                            <div class="form-group">
                                <label>Info</label>
                                <textarea class="form-control" name="info" rows="3">{{ old('info', $kegiatan->info) }}</textarea>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('eksternal.kegiatan.index') }}" class="btn btn-warning">Batal</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
