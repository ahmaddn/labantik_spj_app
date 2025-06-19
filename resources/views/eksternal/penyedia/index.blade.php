@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Data Penyedia</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Penyedia</li>
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
                <a href="{{ route('eksternal.penyedia.add') }}"
                    class="btn btn-primary text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Penyedia
                </a>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h5 class="card-title mb-2">Daftar Penyedia</h5>
                            <p class="card-text">
                                Berikut adalah daftar penyedia yang terdaftar dalam sistem.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Perusahaan</th>
                                            <th class="px-4 py-2">NPWP</th>
                                            <th class="px-4 py-2">Alamat</th>
                                            <th class="px-4 py-2">Nama Delegasi</th>
                                            <th class="px-4 py-2">Jabatan</th>
                                            <th class="px-4 py-2">No Rekening</th>
                                            <th class="px-4 py-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penyedia as $item)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2">{{ $item->company }}</td>
                                                <td class="px-4 py-2">{{ $item->npwp }}</td>
                                                <td class="px-4 py-2">{{ $item->address }}</td>
                                                <td class="px-4 py-2">{{ $item->delegation_name }}</td>
                                                <td class="px-4 py-2">{{ $item->delegate_position }}</td>
                                                <td class="px-4 py-2">{{ $item->account }}</td>
                                                <td class="px-4 py-2">
                                                    <a href="{{ route('eksternal.penyedia.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>

                                                    <form action="{{ route('eksternal.penyedia.destroy', $item->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($penyedia->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-gray-500">Belum ada data
                                                    penyedia.</td>
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
