<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::id();
        $kategori = $request->input('kategori', 'harian');
        $tanggal = $request->input('tanggal', now()->toDateString());

        $list_tahun = Pesanan::where('userID', $userID)
            ->selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $query = Pesanan::with('barang', 'kegiatan', 'penyedia', 'penerima')
            ->where('userID', $userID);

        if ($kategori === 'harian') {
            $query->whereBetween('created_at', [
                Carbon::parse($tanggal)->startOfDay(),
                Carbon::parse($tanggal)->endOfDay()
            ]);
        } elseif ($kategori === 'bulanan') {
            $query->whereMonth('created_at', Carbon::parse($tanggal)->month)
                ->whereYear('created_at', Carbon::parse($tanggal)->year);
        } elseif ($kategori === 'tahunan') {
            $query->whereYear('created_at', Carbon::parse($tanggal)->year);
        }

        $data = $query->get();

        return view('riwayat', compact('data', 'kategori', 'tanggal', 'list_tahun'));
    }
}
