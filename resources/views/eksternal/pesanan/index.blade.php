@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Daftar Pesanan</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesanan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    
                    <div class="card-header">
                        <div class="flex justify-between mb-4">
                    <input type="text" class="form-input px-2 py-1 border rounded w-1/3" placeholder="Search...">
                    <a href="{{ route('eksternal.pesanan.add') }}" class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                        Tambah Pesanan
                    </a>
                </div>
                        <h4 class="card-title">Tabel Pesanan</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Penyedia</th>
                                        <th>Penerima</th>
                                        <th>Barang</th>
                                        <th>Jumlah Uang</th>
                                        <th>Tanggal Order</th>
                                        <th>Tanggal Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->kegiatan->name ?? '-' }}</td>
                                        <td>{{ $item->penyedia->company ?? '-' }}</td>
                                        <td>{{ $item->penerima->name ?? '-' }}</td>
                                        <td>{{ $item->barang->name ?? '-' }}</td>
                                        <td>{{ $item->money_total }}</td>
                                        <td>{{ $item->order }}</td>
                                        <td>{{ $item->paid }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('layouts.footer')
</div>
@endsection
