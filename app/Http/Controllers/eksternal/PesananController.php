<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Kegiatan;
use App\Models\Penyedia;
use App\Models\Penerima;
use App\Models\Barang;
use App\Models\Kepsek;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['kegiatan', 'penyedia', 'penerima', 'barang'])->get();
        return view('eksternal.pesanan.index', compact('pesanan'));
    }

    public function add()
    {
        $kegiatan = Kegiatan::all();
        $penyedia = Penyedia::all();
        $penerima = Penerima::all();
        $barang = Barang::all();
        return view('eksternal.pesanan.add', compact('kegiatan', 'penyedia', 'penerima', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_num'   => 'required',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'barangID'      => 'required|exists:barang,id',
            'budget'        => 'required|integer',
            'paid'          => 'required|date|after_or_equeal:2025-01-01',
        ]);

        Pesanan::create($request->all());

        return redirect()->route('eksternal.pesanan.index')
                         ->with('success', 'Data Pesanan berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('eksternal.pesanan.index')
                         ->with('success', 'Data Pesanan berhasil dihapus.');
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $kegiatan = Kegiatan::all();
        $penyedia = Penyedia::all();
        $penerima = Penerima::all();
        $barang = Barang::all();
        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_num'   => 'required|integer',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:users,id',
            'barangID'      => 'required|exists:barang,id',
            'budget'        => 'required|integer',
            'paid'          => 'required|date',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update($request->all());

        return redirect()->route('eksternal.pesanan.index')
                         ->with('success', 'Data Pesanan berhasil diperbarui.');
    }
    // PesananController.php
public function export($id)
{
    $pesanan = Pesanan::with(['barang', 'penyedia'])->findOrFail($id);
    // return response()->json($pesanan);
    $kepsek = Kepsek::latest()->first(); // Ambil data kepala sekolah terakhir (atau sesuaikan)
    $barang = Barang::all(); // Ambil data kepala sekolah terakhir (atau sesuaikan)

    return view('template', compact('pesanan', 'kepsek', 'barang'));
}


}
