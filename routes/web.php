<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\internal\KepsekController;
use App\Http\Controllers\internal\BendaharaController;
use App\Http\Controllers\internal\PenerimaController;

use App\Http\Controllers\eksternal\KegiatanController;
use App\Http\Controllers\eksternal\BarangController;
use App\Http\Controllers\eksternal\PenyediaController;
use App\Http\Controllers\eksternal\PesananController;



Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);


Route::get('/login', [LoginUserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginUserController::class, 'login']);
Route::post('/logout', [LoginUserController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::get('/template', function () {
    return view('template');
})->middleware('auth')->name('template');

Route::prefix('internal')->name('internal.')->group(function () {
    //Route Kepsek
    Route::resource('kepsek', KepsekController::class)->except(['show']);
    Route::get('/kepsek', [KepsekController::class, 'index'])->name('kepsek.index');
    Route::get('kepsek/add', [KepsekController::class, 'add'])->name('kepsek.add');
    Route::get('kepsek/edit/{id}', [KepsekController::class, 'edit'])->name('kepsek.edit');
    Route::post('kepsek/tambah', [KepsekController::class, 'AddKepsek'])->name('kepsek.AddKepsek');
    Route::post('/kepsek/update/{id}', [KepsekController::class, 'update'])->name('internal.kepsek.update');
    Route::delete('kepsek/deletekepsek/{id}', [KepsekController::class, 'deleteKepsek'])->name('kepsek.deleteKepsek');

    //Route Bendahara
    Route::resource('bendahara', BendaharaController::class)->except(['show']);
    Route::get('/bendahara', [BendaharaController::class, 'index'])->name('bendahara.index');
    Route::get('bendahara/add', [BendaharaController::class, 'add'])->name('bendahara.add');
    Route::get('bendahara/{id}/edit', [BendaharaController::class, 'edit'])->name('bendahara.edit');
    Route::post('bendahara/tambah', [BendaharaController::class, 'addBendahara'])->name('bendahara.addBendahara');    
    Route::delete('bendahara/deletebendahara/{id}', [BendaharaController::class, 'deleteBendahara'])->name('bendahara.deleteBendahara');
    Route::post('/bendahara/{id}/update', [BendaharaController::class, 'update'])->name('internal.bendahara.update');

    // Custom routes
    Route::resource('penerima', PenerimaController::class)->except(['show']);
    Route::get('/penerima', [PenerimaController::class, 'index'])->name('penerima.index');
    Route::get('penerima/add', [PenerimaController::class, 'add'])->name('penerima.add');
    Route::get('penerima/{id}/edit', [PenerimaController::class, 'edit'])->name('penerima.edit');
    Route::post('penerima/tambah', [PenerimaController::class, 'addPenerima'])->name('penerima.addPenerima');
    Route::post('/penerima/{id}/update', [PenerimaController::class, 'update'])->name('internal.penerima.update');
    Route::delete('penerima/deletepenerima/{id}', [PenerimaController::class, 'deletePenerima'])->name('penerima.deletePenerima');
});

Route::prefix('eksternal')->name('eksternal.')->group(function () {
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/add', [KegiatanController::class, 'add'])->name('kegiatan.add');
    Route::post('/add', [KegiatanController::class, 'addKegiatan'])->name('kegiatan.addKegiatan');
    Route::get('/edit/{id}', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/update/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/delete/{id}', [KegiatanController::class, 'deleteKegiatan'])->name('kegiatan.deleteKegiatan');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/add', [BarangController::class, 'add'])->name('barang.add');
    Route::post('/barang/add', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/penyedia', [PenyediaController::class, 'index'])->name('penyedia.index');
    Route::get('/penyedia/add', [PenyediaController::class, 'add'])->name('penyedia.add');
    Route::post('/penyedia/add', [PenyediaController::class, 'addPenyedia'])->name('penyedia.store');
    Route::get('/penyedia/edit/{id}', [PenyediaController::class, 'edit'])->name('penyedia.edit');
    Route::put('/penyedia/update/{id}', [PenyediaController::class, 'update'])->name('penyedia.update');
    Route::delete('/penyedia/delete/{id}', [PenyediaController::class, 'deletePenyedia'])->name('penyedia.destroy');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('pesanan/add', [PesananController::class, 'add'])->name('pesanan.add');
    Route::post('pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('pesanan/edit/{id}', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::post('pesanan/update/{id}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::delete('pesanan/delete/{id}', [PesananController::class, 'delete'])->name('pesanan.delete');
    Route::get('/eksternal/pesanan/export/{id}', [PesananController::class, 'export'])->name('pesanan.export');

});
