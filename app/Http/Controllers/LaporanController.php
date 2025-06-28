<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::id();

        $kategori = $request->input('kategori', 'harian');
        $tanggal = $request->input('tanggal');

        $list_tahun = Pesanan::where('userID', $userID)->selectRaw('Year(created_at) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $query = Pesanan::with('barang', 'kegiatan', 'penyedia', 'penerima')->where('userID', $userID);

        if ($kategori == 'harian') {
            $tanggal_akhir = Carbon::parse($tanggal ?? now())->endOfDay();
            $tanggal_awal = Carbon::parse($tanggal ?? now())->startOfDay();
            $query->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($kategori === 'bulan') {
            $query->whereMonth('created_at', Carbon::parse($tanggal ?? now())->month)
                ->whereYear('created_at', Carbon::parse($tanggal ?? now())->year);
        } elseif ($kategori === 'tahunan') {
            $query->whereYear('created_at', Carbon::parse($tanggal ?? now())->year);
        }

        $data = $query->get();

        return view('laporan', [
            'data' => $data,
            'kategori' => $kategori,
            'list_tahun' => $list_tahun
        ]);
    }
}
