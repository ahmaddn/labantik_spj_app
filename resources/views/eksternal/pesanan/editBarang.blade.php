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
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div id="basic-pills-wizard" class="twitter-bs-wizard wizard">
                    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                        @php
                            $totalSteps = $pesanan->type_num;
                            $existingCount = count($barang);
                            if ($existingCount > $totalSteps) {
                                $totalSteps = $existingCount;
                            }
                        @endphp

                        @for ($i = 0; $i < $totalSteps; $i++)
                            <li class="nav-item">
                                <a class="nav-link {{ $i === 0 ? 'active' : '' }}" href="#step{{ $i }}"
                                    data-toggle="tab">
                                    <span class="step-icon">{{ $i + 1 }}</span>
                                </a>
                            </li>
                        @endfor
                    </ul>

                    <form action="{{ route('eksternal.pesanan.update', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content twitter-bs-wizard-tab-content mt-4">
                            @for ($i = 0; $i < $totalSteps; $i++)
                                @php $item = $barang[$i] ?? null; @endphp
                                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="step{{ $i }}">
                                    <div class="row mb-3 pb-3 border-bottom form-item">
                                        @if ($item)
                                            <input type="hidden" name="items[{{ $i }}][id]"
                                                value="{{ $item->id }}">
                                        @endif

                                        <div class="col-md-6 mb-2">
                                            <label>Nama Barang</label>
                                            <input type="text" name="items[{{ $i }}][name]"
                                                class="form-control" value="{{ old("items.$i.name", $item->name ?? '') }}">
                                            @error("items.$i.name")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Harga Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number" name="items[{{ $i }}][price]"
                                                    class="form-control harga"
                                                    value="{{ old("items.$i.price", $item->price ?? '') }}">
                                            </div>
                                            @error("items.$i.price")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Jumlah Barang</label>
                                            <input type="number" name="items[{{ $i }}][amount]"
                                                class="form-control jumlah"
                                                value="{{ old("items.$i.amount", $item->amount ?? '') }}">
                                            @error("items.$i.amount")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Satuan Barang</label>
                                            @php
                                                $units = ['unit', 'paket', 'set', 'pcs', 'box', 'kg', 'liter'];
                                                $oldUnit = old("items.$i.unit", $item->unit ?? '');
                                                $isOtherSelected = !in_array($oldUnit, $units) && !empty($oldUnit);
                                            @endphp
                                            <select name="items[{{ $i }}][unit]" class="form-control"
                                                id="satuan-barang">
                                                <option value="">-- Pilih Satuan --</option>
                                                <option value="unit"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'unit' ? 'selected' : '' }}>
                                                    Unit</option>
                                                <option value="paket"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'paket' ? 'selected' : '' }}>
                                                    Paket</option>
                                                <option value="set"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'set' ? 'selected' : '' }}>
                                                    Set
                                                </option>
                                                <option value="pcs"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'pcs' ? 'selected' : '' }}>
                                                    Pcs
                                                </option>
                                                <option value="box"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'box' ? 'selected' : '' }}>
                                                    Box</option>
                                                <option value="kg"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'kg' ? 'selected' : '' }}>
                                                    Kg
                                                </option>
                                                <option value="liter"
                                                    {{ old("items.$i.unit", $item->unit ?? '') == 'liter' ? 'selected' : '' }}>
                                                    Liter</option>
                                                <option value="Other" {{ $isOtherSelected ? 'selected' : '' }}>Lainnya...
                                                </option>
                                            </select>
                                            @error('items.$i.unit')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Total Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" name="items[{{ $i }}][total]"
                                                    class="form-control total" readonly inputmode="numeric"
                                                    value="{{ old("items.$i.total", $item->total ?? '') }}">
                                            </div>
                                            @error("items.$i.total")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2" id="other-satuan" style="display: none;">
                                            <label>Satuan Lainnya</label>
                                            <input type="text" class="form-control" name="other"
                                                value="{{ old("items.$i.unit", $item->unit ?? '') }}">
                                            @error('other')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <ul class="pager wizard twitter-bs-wizard-pager-link mt-3">
                                        @if ($i > 0)
                                            <li class="previous me-2"><a href="javascript:;"
                                                    class="btn btn-primary">Sebelumnya</a></li>
                                        @endif
                                        @if ($i < $totalSteps - 1)
                                            <li class="next float-end"><a href="javascript:;"
                                                    class="btn btn-primary">Selanjutnya</a></li>
                                        @else
                                            <li class="float-end"><button type="submit" class="btn btn-success">Perbarui
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
