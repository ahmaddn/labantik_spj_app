@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Daftar Penerima</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Penerima</li>
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
                <a href="{{ route('internal.penerima.add') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Penerima
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-2">Data Penerima</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Nama Penerima</th>
                                            <th class="px-4 py-2">NIP</th>
                                            <th class="px-4 py-2">Jabatan</th>
                                            <th class="px-4 py-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penerima as $row)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2">{{ $row->name }}</td>
                                                <td class="px-4 py-2">{{ $row->nip }}</td>
                                                <td class="px-4 py-2">{{ $row->position ?? '' }}</td>
                                                <td class="px-4 py-2">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('internal.penerima.edit', $row->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('internal.penerima.deletePenerima', $row->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($penerima->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada
                                                    data penerima.</td>
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
