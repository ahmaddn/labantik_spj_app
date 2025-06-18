@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Data Penerima</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('internal.penerima.index') }}">Tabel Penerima</a>
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

                            {{-- Nama Penerima --}}
                            <div class="form-group">
                                <label>Nama Penerima</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>

                            {{-- NIP --}}
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}">
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="number" class="form-control" name="school" min="1900" max="2100"
                                    value="{{ old('school') }}">
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
