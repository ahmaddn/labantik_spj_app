@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Data Penerima</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('internal.penerima.index') }}">Daftar Penerima</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Penerima</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Penerima</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('internal.penerima.addPenerima') }}" method="POST">
                            @csrf

                            {{-- Nama Penerima --}}
                            <div class="form-group">
                                <label>Nama Penerima</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- NIP --}}
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="number" class="form-control" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jabatan --}}
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" name="position" value="{{ old('position') }}">
                                @error('position')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="number" class="form-control" name="school" min="2025" max="2100"
                                    value="{{ old('school') }}">
                                @error('school')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a class="btn btn-secondary" href="{{ route('internal.penerima.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
