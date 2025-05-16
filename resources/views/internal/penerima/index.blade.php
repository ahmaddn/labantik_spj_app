@extends('layouts.app')
@include('layouts.topbar')
@include('layouts.sidebar')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Data Penerima</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Penerima</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card p-4 bg-white rounded shadow">
                <div class="flex justify-between mb-4">
                    <input type="text" class="form-input px-2 py-1 border rounded w-1/3" placeholder="Search...">
                    <a href="{{ route('internal.penerima.add') }}" class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                        Tambah Penerima
                    </a>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-2">Daftar Penerima</h5>
                                <p class="card-text">
                                    Ini adalah daftar data penerima. Gunakan <code>.datatable</code> class untuk inisialisasi.
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="min-w-full text-left text-sm">
                                        <thead>
                                            <tr class="bg-gray-200 text-gray-700">
                                                <th class="px-4 py-2">No</th>
                                                <th class="px-4 py-2">Nama Penerima</th>
                                                <th class="px-4 py-2">NIP</th>
                                                <th class="px-4 py-2">Tahun Ajaran</th>
                                                <th class="px-4 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penerima as $row)
                                                <tr class="border-b">
                                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                    <td class="px-4 py-2">{{ $row->name }}</td>
                                                    <td class="px-4 py-2">{{ $row->nip }}</td>
                                                    <td class="px-4 py-2">{{ $row->school }}</td>
                                                    <td class="px-4 py-2 flex space-x-4">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('internal.penerima.edit', $row->id) }}" class="btn btn-warning text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('internal.penerima.deletePenerima', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                                                        </form>
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

        </div>
        @include('layouts.footer')
    </div>
@endsection
