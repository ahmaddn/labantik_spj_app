@extends('layouts.app')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Data Barang</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
                    </ul>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade-show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4 bg-white rounded shadow">
            <div class="flex justify-between mb-4">
                <a href="{{ route('eksternal.barang.add') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Barang
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-2">Daftar Barang</h5>
                            <p class="card-text">
                                Ini adalah daftar barang yang telah dicatat.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Nama Barang</th>
                                            <th class="px-4 py-2">Jumlah</th>
                                            <th class="px-4 py-2">Harga</th>
                                            <th class="px-4 py-2">Total</th>
                                            <th class="px-4 py-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barang as $row)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2">{{ $row->name }}</td>
                                                <td class="px-4 py-2">{{ $row->amount . ' ' . $row->unit }}</td>
                                                <td class="px-4 py-2">Rp {{ number_format($row->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-2">Rp {{ number_format($row->total, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    <a href="{{ route('eksternal.barang.edit', $row->id) }}"
                                                        class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>

                                                    <form action="{{ route('eksternal.barang.destroy', $row->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($barang->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data
                                                    barang.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
