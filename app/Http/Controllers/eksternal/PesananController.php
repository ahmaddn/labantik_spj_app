<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Kegiatan;
use App\Models\Penyedia;
use App\Models\Penerima;
use App\Models\Barang;
use App\Models\Bendahara;
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
        $bendahara = Bendahara::all(); // Ambil data bendahara (kepala sekolah)
        return view('eksternal.pesanan.add', compact('kegiatan', 'penyedia', 'penerima', 'barang', 'bendahara'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_num'   => 'required|unique:pesanan',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'barangID'      => 'required|exists:barang,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'budget'        => 'required|integer',
            'paid'          => 'required|date|after_or_equal:2025-01-01',
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
        $bendahara = Bendahara::all(); // Ambil data bendahara (kepala sekolah)
        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'barang', 'bendahara'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_num'   => 'required|unique:pesanan',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:users,id',
            'barangID'      => 'required|exists:barang,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
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
        $pesanan = Pesanan::with(['barang', 'penyedia', 'bendahara'])->findOrFail($id);
        // return response()->json($pesanan);
        $kepsek = Kepsek::latest()->first(); // Ambil data kepala sekolah terakhir (atau sesuaikan)
        $barang = Barang::all(); // Ambil data kepala sekolah terakhir (atau sesuaikan)
         // Ambil data bendahara (kepala sekolah)

        return view('template', compact('pesanan', 'kepsek', 'barang'));
    }

    public function addSubmission($id)
    {
        $pesanan = Pesanan::with('barang')->find($id);

        return view('eksternal.pesanan.submission', compact('pesanan'));
    }

    public function storeSubmission(Request $request)
    {
        $pesanan = Pesanan::with('barang')->findOrFail($request->pesananID);


        $request->validate([
            'pesananID' => 'required|exists:pesanan,id',
            'amount' => 'required|numeric|max:' . $pesanan->barang->amount,
            'condition' => 'required',
            'accepted' => 'required|date_format:Y-m-d\TH:i',
            'billing' => 'nullable|date',
        ]);


        $pesanan->update([
            'amount' => $request->amount,
            'condition' => $request->condition,
            'accepted' => $request->accepted,
            'billing' => $request->billing,
            'status' => 'done'
        ]);

        return redirect()->route('eksternal.pesanan.index')->with('success', 'Pesanan berhasil dikonfirmasi');
    }
}
