@extends('layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Profil Pengguna</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Notifikasi Sukses / Error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> Ada beberapa kesalahan pengisian form. Silakan cek kembali.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <!-- Header Profil -->
                <div class="profile-header bg-white p-4 rounded shadow-sm border mb-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @php
                                $nama = $user->namalengkap ?? '';
                                $inisial = collect(explode(' ', $nama))
                                    ->take(2)
                                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                    ->implode('');
                            @endphp
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px; font-size: 32px; font-weight: 700; box-shadow: 0 4px 10px rgba(0,123,255,0.2);">
                                {{ $inisial }}
                            </div>
                        </div>
                        <div class="col ms-3">
                            <h4 class="user-name mb-1" style="font-weight: 700; color: #232b38;">{{ $user->namalengkap }}</h4>
                            <span class="badge bg-light text-primary border px-3 py-2 mb-2" style="font-size: 11px; font-weight: 600;">
                                <i class="fas fa-user-shield me-1"></i> {{ strtoupper($user->level ?? 'ADMIN') }}
                            </span>
                            <div class="text-muted" style="font-size: 13px;">
                                <i class="fas fa-at me-1"></i> Username: <strong>{{ $user->username }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigasi Tab -->
                <div class="profile-menu mb-4">
                    <ul class="nav nav-tabs nav-tabs-solid border-0 bg-white p-2 rounded border shadow-sm" style="display: inline-flex; gap: 8px;">
                        <li class="nav-item">
                            <a class="nav-link active border-0 px-4 py-2" style="border-radius: 6px; font-weight: 600;" data-bs-toggle="tab" href="#profile_tab">
                                <i class="fas fa-user-edit me-2"></i> Detail Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0 px-4 py-2" style="border-radius: 6px; font-weight: 600;" data-bs-toggle="tab" href="#password_tab">
                                <i class="fas fa-key me-2"></i> Ganti Password
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Konten Tab -->
                <div class="tab-content profile-tab-cont">
                    <!-- Tab Detail Profil -->
                    <div id="profile_tab" class="tab-pane fade show active">
                        <div class="card border shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0" style="font-weight: 700; color: #232b38;">
                                    <i class="fas fa-id-card text-primary me-2"></i> Perbarui Informasi Profil
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" style="font-weight: 600; color: #495057;">Nama Lengkap</label>
                                                <input type="text" name="namalengkap" class="form-control @error('namalengkap') is-invalid @enderror" 
                                                    value="{{ old('namalengkap', $user->namalengkap) }}" placeholder="Masukkan nama lengkap" required style="border-radius: 6px; padding: 10px 14px;">
                                                @error('namalengkap')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-4">
                                                <label class="form-label" style="font-weight: 600; color: #495057;">Username</label>
                                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                                    value="{{ old('username', $user->username) }}" placeholder="Masukkan username" required style="border-radius: 6px; padding: 10px 14px;">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button class="btn btn-primary px-4" type="submit" style="border-radius: 6px; padding: 10px 20px; font-weight: 600;">
                                                <i class="fas fa-save me-2"></i> Simpan Profil
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Ganti Password -->
                    <div id="password_tab" class="tab-pane fade">
                        <div class="card border shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0" style="font-weight: 700; color: #232b38;">
                                    <i class="fas fa-shield-alt text-primary me-2"></i> Ganti Password Akun
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('profile.password') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" style="font-weight: 600; color: #495057;">Password Lama</label>
                                                <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" 
                                                    placeholder="Masukkan password lama" required style="border-radius: 6px; padding: 10px 14px;">
                                                @error('old_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label" style="font-weight: 600; color: #495057;">Password Baru</label>
                                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" 
                                                    placeholder="Masukkan password baru (minimal 6 karakter)" required style="border-radius: 6px; padding: 10px 14px;">
                                                @error('new_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-4">
                                                <label class="form-label" style="font-weight: 600; color: #495057;">Konfirmasi Password Baru</label>
                                                <input type="password" name="new_password_confirmation" class="form-control" 
                                                    placeholder="Ulangi password baru" required style="border-radius: 6px; padding: 10px 14px;">
                                            </div>

                                            <button class="btn btn-primary px-4" type="submit" style="border-radius: 6px; padding: 10px 20px; font-weight: 600;">
                                                <i class="fas fa-key me-2"></i> Perbarui Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
