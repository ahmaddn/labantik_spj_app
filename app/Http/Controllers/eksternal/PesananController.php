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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $pesanan = Pesanan::with(['kegiatan', 'penyedia', 'penerima', 'barang'])->where('userID', $id)->get();
        return view('eksternal.pesanan.index', compact('pesanan'));
    }

    public function addSession()
    {
        $id = Auth::id();
        $kegiatan = Kegiatan::where('userID', $id)->get();
        $penyedia = Penyedia::where('userID', $id)->get();
        $penerima = Penerima::where('userID', $id)->get();
        $bendahara = Bendahara::where('userID', $id)->get();
        return view('eksternal.pesanan.add', compact('kegiatan', 'penyedia', 'penerima', 'bendahara'));
    }

    public function addForm()
    {
        $data = session('data');

        if (!$data || !isset($data['type_num'])) {
            return redirect()->route('eksternal.pesanan.addSession')->with('error', 'Isi jumlah jenis barang terlebih dahulu!');
        }

        return view('eksternal.pesanan.addForm', [
            'type_num' => $data['type_num']
        ]);
    }

    public function session(Request $request)
    {
        $kegiatan = Kegiatan::findOrFail($request->kegiatanID);
        $request->validate([
            'invoice_num'   => 'required|unique:pesanan',
            'order_num'   => 'required|unique:pesanan',
            'note_num'   => 'required|unique:pesanan',
            'bast_num'   => 'required|unique:pesanan',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'accepted'          => "required|date|after_or_equal:$kegiatan->order",
            'billing'          => "nullable|date",
            'paid'          => 'required|date|after_or_equal:2025-01-01',
        ]);

        session(['data' => $request->except('_token')]);

        return redirect()->route('eksternal.pesanan.addForm');
    }

    public function store(Request $request)
    {
        $type_num = session('data.type_num');
        $request->validate([
            'items' => "required|array|size:$type_num",
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|string|min:0',
            'items.*.amount' => 'required|string|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        $data = session('data');
        $items = $request->input('items');

        DB::beginTransaction();
        try {
            $id = Auth::id();
            $data['userID'] = $id;
            $pesanan = Pesanan::create($data);

            foreach ($items as $item) {
                $pesanan->barang()->create([
                    'pesananID' => $pesanan->id,
                    'userID' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'unit' => $item['unit'],
                    'amount' => $item['amount'],
                    'total' => $item['total'],
                ]);
            }
            DB::commit();
            session()->forget('step1_data');
            return redirect()->route('eksternal.pesanan.index')
                ->with('success', 'Data Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpanan pesanan: ' . $e->getMessage()])->withInput();
        }
    }

    public function delete($id)
    {
        $pesanan = Pesanan::with('barang')->findOrFail($id);
        $pesanan->barang()->delete();
        $pesanan->delete();

        return redirect()->route('eksternal.pesanan.index')
            ->with('success', 'Data Pesanan berhasil dihapus.');
    }

    public function edit($id)
    {
        $userID = Auth::id();
        $pesanan = Pesanan::with('barang')->findOrFail($id);
        $kegiatan = Kegiatan::where('userID', $userID)->get();
        $penyedia = Penyedia::where('userID', $userID)->get();
        $penerima = Penerima::where('userID', $userID)->get();
        $bendahara = Bendahara::where('userID', $userID)->get(); // Ambil data bendahara (kepala sekolah)
        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'barang', 'bendahara'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($request->kegiatanID);

        $request->validate([
            'invoice_num'   => 'required|min_digits:3',
            'order_num'   => 'required|min_digits:3',
            'note_num'   => 'required|min_digits:3',
            'bast_num'   => 'required|min_digits:3',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'barangID'      => 'required|array',
            'barangID.*'      => 'exists:barang,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'budget'        => 'required|integer',
            'paid'          => 'required|date|after_or_equal:' . $kegiatan->order,
        ]);


        DB::transaction(function () use ($request, $id) {
            $pesanan = Pesanan::with('barangs')->findOrFail($id);

            $pesanan->update([
                'invoice_num' => $request->invoice_num,
                'order_num' => $request->order_num,
                'note_num' => $request->note_num,
                'bast_num' => $request->bast_num,
                'kegiatanID' => $request->kegiatanID,
                'penyediaID' => $request->penyediaID,
                'penerimaID' => $request->penerimaID,
                'bendaharaID' => $request->bendaharaID,
                'budget' => $request->budget,
                'paid' => $request->paid,
            ]);
        });

        return redirect()->route('eksternal.pesanan.index')
            ->with('success', 'Data Pesanan berhasil diperbarui.');
    }
    // PesananController.php
    public function export($id)
    {
        $userID = Auth::id();
        $pesanan = Pesanan::with(['barang', 'penyedia', 'bendahara'])->findOrFail($id);
        // return response()->json($pesanan);
        $kepsek = Kepsek::where('userID', $userID)->first(); // Ambil data kepala sekolah terakhir (atau sesuaikan)


        return view('template', compact('pesanan', 'kepsek', 'barang'));
    }
}
