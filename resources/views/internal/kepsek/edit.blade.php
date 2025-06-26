@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Data Kepala Sekolah</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('internal.kepsek.index') }}">Daftar Kepala
                                Sekolah</a></li>
                        <li class="breadcrumb-item active">Edit Data Kepala Sekolah</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Kepala Sekolah</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('internal.kepsek.update', $kepsek->id) }}" method="POST">
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

                            {{-- Nama Kepsek --}}
                            <div class="form-group">
                                <label>Nama Kepsek</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $kepsek->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- NIP --}}
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" name="nip"
                                    value="{{ old('nip', $kepsek->nip) }}">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="text" class="form-control" name="school" min="1900" max="2100"
                                    value="{{ old('school', $kepsek->school) }}">
                                @error('school')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nama Sekolah --}}
                            <div class="form-group">
                                <label>Alamat Sekolah</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ old('address', $kepsek->address) }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a class="btn btn-secondary" href="{{ route('internal.kepsek.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
