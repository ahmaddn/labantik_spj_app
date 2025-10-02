@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Kop Surat</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        </li>
                        <li class="breadcrumb-item">Tambah Kop Surat</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Kop Surat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('eksternal.pesanan.storeLetterhead') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lembaga Utama</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Sub Lembaga</label>
                                <input type="date" class="form-control" name="order" value="{{ old('order') }}"
                                    min="2025-01-01">
                                @error('order')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Perusahaan/Instansi</label>
                                <input type="date" class="form-control" name="deadline" value="{{ old('deadline') }}"
                                    min="2025-01-01">
                                @error('deadline')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Bidang</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat 1</label>
                                <textarea class="form-control" name="info" rows="3">{{ old('info') }}</textarea>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat 2 (Opsional)</label>
                                <textarea class="form-control" name="info" rows="3">{{ old('info') }}</textarea>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Fax</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Pos</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NPSN (Jika ada)</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="info" rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" class="form-control" name="info"
                                    rows="3">{{ old('info') }}</input>
                                @error('info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
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
@endsection
