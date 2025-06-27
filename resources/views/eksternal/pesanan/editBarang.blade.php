@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Edit Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eksternal.pesanan.edit', $pesanan->id) }}">Edit
                                Pesanan</a></li>
                        <li class="breadcrumb-item active">Edit Barang</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Pesanan</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('eksternal.pesanan.update', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php
                        $existingCount = count($barang);
                        $targetCount = $pesanan->type_num;
                    @endphp
                    @foreach ($barang as $i => $item)
                        <div class="row mb-3 pb-3 border-bottom form-item">
                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">
                            <div class="col-md-6 mb-2">
                                <label>Nama Barang {{ $i + 1 }}</label>
                                <input type="text" name="items[{{ $i }}][name]" class="form-control"
                                    value="{{ old("items.$i.name", $item->name) }}">
                                @error("items.$i.name")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Harga Barang {{ $i + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" name="items[{{ $i }}][price]"
                                        class="form-control harga" value="{{ old("items.$i.price", $item->price) }}">
                                </div>
                                @error("items.$i.price")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Jumlah Barang {{ $i + 1 }}</label>
                                <input type="number" name="items[{{ $i }}][amount]" class="form-control jumlah"
                                    value="{{ old("items.$i.amount", $item->amount) }}">
                                @error("items.$i.amount")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Satuan Barang {{ $i + 1 }}</label>
                                <input type="text" name="items[{{ $i }}][unit]" class="form-control"
                                    value="{{ old("items.$i.unit", $item->unit) }}">
                                @error("items.$i.unit")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Total Barang {{ $i + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" name="items[{{ $i }}][total]"
                                        class="form-control total" readonly inputmode="numeric"
                                        value="{{ old("items.$i.total", $item->total) }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @for ($j = $existingCount; $j < $targetCount; $j++)
                        <div class="row mb-3 pb-3 border-bottom form-item">
                            <div class="col-md-6 mb-2">
                                <label>Nama Barang {{ $j + 1 }}</label>
                                <input type="text" name="items[{{ $j }}][name]" class="form-control"
                                    value="{{ old("items.$j.name") }}">
                                @error("items.$j.name")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Harga Barang {{ $j + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" name="items[{{ $j }}][price]"
                                        class="form-control harga" value="{{ old("items.$j.price") }}">
                                </div>
                                @error("items.$j.price")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Jumlah Barang {{ $j + 1 }}</label>
                                <input type="number" name="items[{{ $j }}][amount]" class="form-control jumlah"
                                    value="{{ old("items.$j.amount") }}">
                                @error("items.$j.amount")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Satuan Barang {{ $j + 1 }}</label>
                                <input type="text" name="items[{{ $j }}][unit]" class="form-control"
                                    value="{{ old("items.$j.unit") }}">
                                @error("items.$j.unit")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Total Barang {{ $j + 1 }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" name="items[{{ $j }}][total]"
                                        class="form-control total" readonly inputmode="numeric"
                                        value="{{ old("items.$j.total") }}">
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="mt-3">
                        <a href="{{ route('eksternal.pesanan.edit', $pesanan->id) }}"
                            class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Perbarui Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
