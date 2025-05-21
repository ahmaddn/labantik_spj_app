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
                                        <th>Action</th>
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
                                        <td class="px-4 py-2 flex space-x-2">
                                                        <a href="{{ route('eksternal.pesanan.edit', $item->id) }}"
                                                           class="btn btn-warning text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>

                                                        <form action="{{ route('eksternal.pesanan.delete', $item->id) }}" method="POST"
                                                              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                                        </form>
                                                        <a href="{{ route('eksternal.pesanan.export', $item->id) }}"
                                                           class="btn btn-primary text-white px-3 py-1 rounded hover:bg-yellow-600">Print</a>
                                                    </td>
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
