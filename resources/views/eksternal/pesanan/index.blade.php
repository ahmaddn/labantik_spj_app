@extends('layouts.app')

@section('content')
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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade-show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">

                    <div class="card-header">
                        <div class="flex justify-between mb-4">
                            <a href="{{ route('eksternal.pesanan.addSession') }}"
                                class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                                Tambah Pesanan
                            </a>
                        </div>
                        <h4 class="card-title">Daftar Pesanan</h4>

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
                                        <th>Tanggal Bayar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kegiatan->name ?? '-' }}</td>
                                            <td>{{ $item->penyedia->company ?? '-' }}</td>
                                            <td>{{ $item->penerima->name ?? '-' }}</td>
                                            <td class="text-wrap" style="white-space: normal">
                                                <ol style="list-style: decimal; margin-left: 1rem">
                                                    @foreach ($item->barang->pluck('name') as $barang)
                                                        <li>{{ $barang ?? '-' }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($item->paid)->translatedFormat('d F Y') }}</td>
                                            <td class="px-4 py-2">
                                                <a href="{{ route('eksternal.pesanan.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('eksternal.pesanan.export', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>

                                                <form action="{{ route('eksternal.pesanan.delete', $item->id) }}"
                                                    method="POST" class="d-inline-block"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($pesanan->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data
                                                pesanan.</td>
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
@endsection
