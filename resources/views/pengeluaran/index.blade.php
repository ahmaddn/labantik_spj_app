@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Data Pengeluaran</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pengeluaran</li>
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
                <a href="{{ route('pengeluaran.create') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Pengeluaran
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-2">Daftar Pengeluaran</h5>
                            <p class="card-text">
                                Ini adalah daftar pengeluaran yang telah dicatat.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jenis Pengeluaran</th>
                                            <th>Qty</th>
                                            <th>Nominal</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pengeluaran as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->date)->translatedFormat('d F Y') }}</td>
                                                <td>{{ $data->type }}</td>
                                                <td>{{ $data->qty }}</td>
                                                <td>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                                <td>{{ $data->pic }}</td>
                                                <td><a href="{{ route('pengeluaran.edit', $data->id) }}"
                                                        class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>

                                                    <form action="{{ route('pengeluaran.destroy', $data->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-gray-500">Belum Ada Data
                                                    Pengeluaran</td>
                                            </tr>
                                        @endforelse
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
