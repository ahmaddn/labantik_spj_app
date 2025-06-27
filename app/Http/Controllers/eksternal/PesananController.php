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
        $kegiatan = Kegiatan::find($request->kegiatanID);
        if (!$kegiatan) {
            return back()->withErrors(['error', 'Data Kegiatan Tidak Ditemukan!'])->withInput();
        }
        $request->validate([
            'invoice_num'   => 'required|unique:pesanan',
            'order_num'   => 'required|unique:pesanan',
            'note_num'   => 'required|unique:pesanan',
            'bast_num'   => 'required|unique:pesanan',
            'tax'   => 'required',
            'shipping_cost'   => 'required',
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
        $pesanan = Pesanan::with('barang')->where('userID', $userID)->findOrFail($id);
        $kegiatan = Kegiatan::where('userID', $userID)->get();
        $penyedia = Penyedia::where('userID', $userID)->get();
        $penerima = Penerima::where('userID', $userID)->get();
        $bendahara = Bendahara::where('userID', $userID)->get();

        session([
            'edit_pesanan' => array_merge($pesanan->toArray(), ['type_num' => $pesanan->type_num]),
            'edit_barang' => $pesanan->barang,
        ]);
        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'bendahara'));
    }

    public function editBarang(Request $request)
    {
        $kegiatan = Kegiatan::findOrFail($request->kegiatanID);

        $validated = $request->validate([
            'invoice_num'   => 'required',
            'order_num'   => 'required',
            'note_num'   => 'required',
            'bast_num'   => 'required',
            'type_num'   => 'required',
            'tax'   => 'required',
            'shipping_cost'   => 'required',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'accepted'          => "required|date|after_or_equal:$kegiatan->order",
            'billing'          => "nullable|date",
            'paid'          => "required|date|after_or_equal:$kegiatan->order",
        ]);
        session(['data_editPesanan' => $validated]);


        $pesanan = session('edit_pesanan');
        $pesanan = (object) array_merge((array) $pesanan, ['type_num' => $validated['type_num']]);
        session(['edit_pesanan' => $pesanan]);
        $barang = session('edit_barang');

        return view('eksternal.pesanan.editBarang', compact('pesanan', 'barang'));
    }

    public function update(Request $request, $id)
    {

        $editPesanan = session('data_editPesanan');
        if (!$editPesanan) {
            return back()->withErrors(['error' => 'Data pesanan tidak ditemukan di session.'])->withInput();
        }
        $items = $request->input('items', []);

        DB::transaction(function () use ($editPesanan, $items, $id) {
            $pesanan = Pesanan::with('barang')->findOrFail($id);
            $pesanan->update($editPesanan);

            $existingIds = $pesanan->barang->pluck('id')->toArray();
            $incomingIds = [];

            foreach ($items as $item) {
                if (isset($item['id'])) {

                    $barang = $pesanan->barang()->where('id', $item['id'])->first();

                    if ($barang) {
                        $barang->update([
                            'name' => $item['name'],
                            'price' => $item['price'],
                            'amount' => $item['amount'],
                            'unit' => $item['unit'],
                            'total' => $item['total'],
                        ]);
                        $incomingIds[] = $item['id'];
                    }
                } else {
                    $pesanan->barang()->create([
                        'userID' => $pesanan->userID,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'amount' => $item['amount'],
                        'unit' => $item['unit'],
                        'total' => $item['total'],
                    ]);
                }
            }

            $barangToDelete = array_diff($existingIds, $incomingIds);
            Barang::whereIn('id', $barangToDelete)->delete();
        });

        session()->forget(['edit_pesanan', 'edit_barang', 'data_editPesanan']);

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


        return view('template', compact('pesanan', 'kepsek'));
    }
}
