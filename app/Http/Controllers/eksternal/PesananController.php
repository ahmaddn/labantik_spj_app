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
use App\Models\Pesanan_barang;
use Illuminate\Support\Facades\DB;

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
        return view('eksternal.pesanan.add', compact('kegiatan', 'penyedia', 'penerima', 'barang' , 'bendahara'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_num'   => 'required|unique:pesanan',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'barangID'      => 'required|array',
            'barangID.*'      => 'exists:barang,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'budget'        => 'required|integer',
            'paid'          => 'required|date|after_or_equal:2025-01-01',
        ]);

        $totalHarga = Barang::whereIn('id', $request->barangID)->sum('total');

        if ($request->budget < $totalHarga) {
            return back()->withErrors([
                'budget' => 'Budget tidak boleh kurang dari total harga dari barang yang dipilih. (Total: Rp. ' . number_format($totalHarga, 0, ',', '.') . ')'
            ])->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $pesanan = Pesanan::create([
                    'invoice_num' => $request->invoice_num,
                    'kegiatanID' => $request->kegiatanID,
                    'penyediaID' => $request->penyediaID,
                    'penerimaID' => $request->penerimaID,
                    'bendaharaID' => $request->bendaharaID,
                    'budget' => $request->budget,
                    'paid' => $request->paid,
                ]);

                $pesanan->barangs()->attach($request->barangID);
            });

            return redirect()->route('eksternal.pesanan.index')
                            ->with('success', 'Data Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpanan pesanan: ' . $e->getMessage()]);
        }


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
        $pesanan = Pesanan::with('barangs')->findOrFail($id);
        $kegiatan = Kegiatan::all();
        $penyedia = Penyedia::all();
        $penerima = Penerima::all();
        $barang = Barang::all();
        $bendahara = Bendahara::all(); // Ambil data bendahara (kepala sekolah)
        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'barang', 'bendahara'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($request->kegiatanID);

        $request->validate([
            'invoice_num'   => 'required|min_digits:3',
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
                'kegiatanID' => $request->kegiatanID,
                'penyediaID' => $request->penyediaID,
                'penerimaID' => $request->penerimaID,
                'bendaharaID' => $request->bendaharaID,
                'budget' => $request->budget,
                'paid' => $request->paid,
            ]);

            $pesanan->barangs()->sync($request->barangID);
        });

        return redirect()->route('eksternal.pesanan.index')
                         ->with('success', 'Data Pesanan berhasil diperbarui.');
    }
    // PesananController.php
    public function export($id)
    {
        $pesanan = Pesanan::with(['barang', 'penyedia','bendahara'])->findOrFail($id);
        // return response()->json($pesanan);
        $kepsek = Kepsek::latest()->first(); // Ambil data kepala sekolah terakhir (atau sesuaikan)
        $barang = Barang::all(); // Ambil data kepala sekolah terakhir (atau sesuaikan)


        return view('template', compact('pesanan', 'kepsek', 'barang'));
    }

    public function addSubmission($id)
    {
        $pesanan = Pesanan::with('barangs')->find($id);

        return view('eksternal.pesanan.submission', compact('pesanan'));
    }

    public function storeSubmission(Request $request)
    {
        $pesanan = Pesanan::with('barangs')->findOrFail($request->pesananID);


        $request->validate([
            'pesananID' => 'required|exists:pesanan,id',
            'amount_accepted' => 'required|array',
            'condition' => 'required|array',
            'accepted' => 'required|date_format:Y-m-d\TH:i',
            'billing' => 'nullable|date',
        ]);

        foreach($request->amount_accepted as $barangID => $jumlah) {
            $barang = $pesanan->barangs->firstWhere('id', $barangID);

            if (!$barang) {
                return back()->withErrors([
                    "amount_accepted.$barangID" => "Barang tidak valid."
                ])->withInput();
            }

            if (!is_numeric($jumlah) || $jumlah < 0) {
                return back()->withErrors([
                    "amount_accepted.$barangID" => "Jumlah harus berupa angka positif."
                ])->withInput();
            }

            if ($jumlah > $barang->amount) {
                return back()->withErrors([
                    "amount_accepted.$barangID" => "Jumlah melebihi stok pesanan: $barang->amount."
                ])->withInput();
            }

            if (!isset($request->condition[$barangID]) || !in_array($request->condition[$barangID], ['Baik', 'Buruk'])) {
                return back()->withErrors([
                    "condition.$barangID" => "Kondisi tidak valid untuk barang ID $barangID."
                ])->withInput();
            }
        }

        $pesanan->update([
            'accepted' => $request->accepted,
            'billing' => $request->billing,
            'status' => 'done'
        ]);

        foreach ($request->amount_accepted as $barangID => $jumlah) {
            DB::table('pesanan_barang')
                ->where('pesananID', $pesanan->id)
                ->where('barangID', $barangID)
                ->update([
                    'amount_accepted' => $jumlah,
                    'condition' => $request->condition[$barangID],
                ]);
        }


        return redirect()->route('eksternal.pesanan.index')->with('success', 'Pesanan berhasil dikonfirmasi');
    }

}
