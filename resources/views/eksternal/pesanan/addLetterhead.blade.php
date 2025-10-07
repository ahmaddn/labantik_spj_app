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
                <form action="{{ route('eksternal.pesanan.storeLetterhead') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lembaga Utama</label>
                                <input type="text" class="form-control" name="main_institution"
                                    value="{{ old('main_institution') }}">
                                @error('main_institution')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Sub Lembaga</label>
                                <input type="text" class="form-control" name="sub_institution"
                                    value="{{ old('sub_institution') }}">
                                @error('sub_institution')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Perusahaan/Instansi</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Bidang</label>
                                <input class="form-control" name="field" value="{{ old('info') }}">
                                @error('field')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat 1</label>
                                <textarea class="form-control" name="address1">{{ old('address1') }}</textarea>
                                @error('address1')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat 2 (Opsional)</label>
                                <textarea class="form-control" name="address2">{{ old('address2') }}</textarea>
                                @error('address2')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" class="form-control" name="no_telp"
                                    rows="3">{{ old('no_telp') }}</input>
                                @error('no_telp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                                @error('fax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Pos</label>
                                <input type="text" class="form-control" name="pos" value="{{ old('pos') }}">
                                @error('pos')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NPSN (Jika ada)</label>
                                <input type="text" class="form-control" name="npsn" value="{{ old('npsn') }}">
                                @error('npsn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                                @error('website')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control"
                                    name="logo" value="{{ old('logo') }}">
                                @error('logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>



                    <div class="text-end">
                        <a href="{{ route('eksternal.pesanan.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
