@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Tambah Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.addSession') }}">Tambah Pesanan</a>
                        </li>
                        <li class="breadcrumb-item">Tambah Barang</li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div id="basic-pills-wizard" class="twitter-bs-wizard wizard">
                    {{-- STEP NAVIGATION --}}
                    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                        @for ($i = 0; $i < $type_num; $i++)
                            <li class="nav-item">
                                <a class="nav-link {{ $i === 0 ? 'active' : '' }}" href="#step{{ $i }}"
                                    data-toggle="tab">
                                    <span class="step-icon">{{ $i + 1 }}</span>
                                </a>
                            </li>
                        @endfor
                    </ul>

                    <form action="{{ route('eksternal.pesanan.store') }}" method="POST">
                        @csrf

                        {{-- STEP CONTENT --}}
                        <div class="tab-content twitter-bs-wizard-tab-content mt-4">
                            @for ($i = 0; $i < $type_num; $i++)
                                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="step{{ $i }}">
                                    <div class="row mb-3 pb-3 border-bottom form-item">
                                        <div class="col-md-6 mb-2">
                                            <label>Nama Barang</label>
                                            <input type="text" name="items[{{ $i }}][name]"
                                                class="form-control" value="{{ old("items.$i.name") }}">
                                            @error("items.$i.name")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Harga Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number" name="items[{{ $i }}][price]"
                                                    class="form-control harga" value="{{ old("items.$i.price") }}">
                                            </div>
                                            @error("items.$i.price")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Jumlah Barang</label>
                                            <input type="number" name="items[{{ $i }}][amount]"
                                                class="form-control jumlah" value="{{ old("items.$i.amount") }}">
                                            @error("items.$i.amount")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Satuan Barang</label>
                                            <input type="text" name="items[{{ $i }}][unit]"
                                                class="form-control" value="{{ old("items.$i.unit") }}">
                                            @error("items.$i.unit")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Total Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" name="items[{{ $i }}][total]"
                                                    class="form-control total" readonly inputmode="numeric"
                                                    value="{{ old("items.$i.total") }}">
                                            </div>
                                            @error("items.$i.total ")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- NAVIGATION BUTTONS --}}
                                    <ul class="pager wizard twitter-bs-wizard-pager-link mt-3">
                                        @if ($i > 0)
                                            <li class="previous me-2"><a href="javascript:;"
                                                    class="btn btn-primary">Sebelumnya</a></li>
                                        @endif
                                        @if ($i < $type_num - 1)
                                            <li class="next float-end"><a href="javascript:;"
                                                    class="btn btn-primary">Selanjutnya</a></li>
                                        @else
                                            <li class="float-end"><button type="submit" class="btn btn-success">Simpan
                                                    Pesanan</button></li>
                                        @endif
                                    </ul>
                                </div>
                            @endfor
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
