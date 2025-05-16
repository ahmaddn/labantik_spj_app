@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Data</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Data</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Form Kepala Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('internal.kepsek.AddKepsek') }}" method="POST">
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

                                {{-- Nama Kepala Sekolah --}}
                                <div class="form-group">
                                    <label>Nama Kepsek</label>
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
    <input type="number" class="form-control" name="school" min="1900" max="2100">
</div>


                                {{-- Nama Sekolah --}}
                                <div class="form-group">
                                    <label>Alamat Sekolah</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                                

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('layouts.footer')
    </div>
@endsection
