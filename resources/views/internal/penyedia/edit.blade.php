@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Penyedia</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Penyedia</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Edit Penyedia</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('internal.penyedia.update', $penyedia->id) }}" method="POST">
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

                            {{-- Nama Perusahaan --}}
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" name="company"
                                    value="{{ old('company', $penyedia->company) }}" required>
                            </div>

                            {{-- NPWP --}}
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="text" class="form-control" name="npwp"
                                    value="{{ old('npwp', $penyedia->npwp) }}" required>
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" rows="3" required>{{ old('address', $penyedia->address) }}</textarea>
                            </div>

                            {{-- Kode Pos --}}
                            <div class="form-group">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control" name="post_code"
                                    value="{{ old('post_code', $penyedia->post_code) }}">
                                @error('post_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Bank --}}
                            <div class="form-group">
                                <label>Bank</label>
                                <input type="text" class="form-control" name="bank"
                                    value="{{ old('bank', $penyedia->bank) }}">
                                @error('bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jumlah Rekening --}}
                            <div class="form-group">
                                <label>No. Rekening</label>
                                <input type="number" class="form-control" name="account"
                                    value="{{ old('account', $penyedia->account) }}" required>
                            </div>

                            {{-- Nama Delegasi --}}
                            <div class="form-group">
                                <label>Nama Delegasi</label>
                                <input type="text" class="form-control" name="delegation_name"
                                    value="{{ old('delegation_name', $penyedia->delegation_name) }}" required>
                            </div>

                            {{-- Jabatan Delegasi --}}
                            <div class="form-group">
                                <label>Jabatan Delegasi</label>
                                <input type="text" class="form-control" name="delegate_position"
                                    value="{{ old('delegate_position', $penyedia->delegate_position) }}" required>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('internal.penyedia.index') }}" class="btn btn-warning">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
