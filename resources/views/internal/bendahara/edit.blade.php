@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Data Bendahara</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('internal.bendahara.index') }}">Daftar Bendahara</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Data Bendahara</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Bendahara</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('internal.bendahara.update', $bendahara->id) }}" method="POST">
                            @csrf
                            @method('PUT')


                            {{-- Nama Bendahara --}}
                            <div class="form-group">
                                <label>Nama Bendahara</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $bendahara->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jenis Bendahara --}}
                            <div class="form-group">
                                <label>Jenis Bendahara</label>
                                <select class="form-control" name="jenis">
                                    <option value="BOS" {{ ($pesanan->type ?? '') === 'BOS' ? 'selected' : '' }}>BOS
                                    </option>
                                    <option value="BODP" {{ ($pesanan->type ?? '') === 'BODP' ? 'selected' : '' }}>BODP
                                    </option>
                                </select>
                                @error('jenis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- NIP --}}
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" name="nip"
                                    value="{{ old('nip', $bendahara->nip) }}">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a class="btn btn-secondary" href="{{ route('internal.bendahara.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
