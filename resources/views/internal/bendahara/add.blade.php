@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Add Data</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('internal.bendahara.index') }}">Daftar Kepala
                                Sekolah</a></li>
                        <li class="breadcrumb-item active">Add Data Bendahara</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Bendahara</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('internal.bendahara.addBendahara') }}" method="POST">
                            @csrf

                            {{-- Nama Bendahara --}}
                            <div class="form-group">
                                <label>Pembayaran Telah Diterima Dari : </label>
                                <input type="text" class="form-control" name="received_from"
                                    value="{{ old('received_from') }}">
                                @error('received_from')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Nama Bendahara --}}
                            <div class="form-group">
                                <label>Nama Bendahara</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jenis Bendahara --}}
                            <div class="form-group">
                                <label>Jenis Bendahara</label>
                                <select class="form-control" name="jenis" id="jenis-bendahara">
                                    <option value="Bendahara BOS">Bendahara BOS</option>
                                    <option value="Bendahara BOPD">Bendahara BOPD</option>
                                    <option value="Other">Lainnya...</option>
                                </select>
                                @error('jenis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group" id="other-bendahara" style="display: none;">
                                <label>Jenis Bendahara Lainnya</label>
                                <input type="text" class="form-control" name="other" value="{{ old('other') }}">
                                @error('other')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- NIP --}}
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a class="btn btn-secondary" href="{{ route('internal.bendahara.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
