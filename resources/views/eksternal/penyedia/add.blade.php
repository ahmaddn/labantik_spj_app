@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Penyedia</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tambah Penyedia</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Penyedia</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('eksternal.penyedia.store') }}" method="POST">
                            @csrf


                            {{-- Nama Perusahaan --}}
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" name="company" value="{{ old('company') }}"
                                    autofocus>
                                @error('company')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- NPWP --}}
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="number" class="form-control" name="npwp" value="{{ old('npwp') }}">
                                @error('npwp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Bank --}}
                            <div class="form-group">
                                <label>Bank</label>
                                <input type="text" class="form-control" name="bank" value="{{ old('bank') }}">
                                @error('bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- No Rekening --}}
                            <div class="form-group">
                                <label>No. Rekening</label>
                                <input type="number" class="form-control" name="account" value="{{ old('account') }}">
                                @error('account')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nama Delegasi --}}
                            <div class="form-group">
                                <label>Nama Delegasi</label>
                                <input type="text" class="form-control" name="delegation_name"
                                    value="{{ old('delegation_name') }}">
                                @error('delegation_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jabatan Delegasi --}}
                            <div class="form-group">
                                <label>Jabatan Delegasi</label>
                                <input type="text" class="form-control" name="delegate_position"
                                    value="{{ old('delegate_position') }}">
                                @error('delegate_position')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('eksternal.penyedia.index') }}" class="btn btn-warning">
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
