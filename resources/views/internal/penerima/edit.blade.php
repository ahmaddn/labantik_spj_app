@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Data Penerima</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Data</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Penerima</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('internal.penerima.update', $penerima->id) }}" method="POST">
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

                                {{-- Nama Penerima --}}
                                <div class="form-group">
                                    <label>Nama Penerima</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $penerima->name) }}">
                                </div>

                                {{-- NIP Penerima --}}
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="nip" value="{{ old('nip', $penerima->nip) }}">
                                </div>

                                {{-- Tahun Ajaran --}}
                                <div class="form-group">
                                    <label>Tahun Ajaran</label>
                                    <input type="number" class="form-control" name="school" min="1900" max="2100" value="{{ old('school', $penerima->school) }}">
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Update</button>
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
