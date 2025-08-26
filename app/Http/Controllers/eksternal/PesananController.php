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
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Imports\BarangImport;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $pesanan = Pesanan::with(['kegiatan', 'penyedia', 'penerima', 'barang'])->where('userID', $id)->get();
        return view('eksternal.pesanan.index', compact('pesanan'));
    }

    public function dashboard()
    {
        $id = Auth::id();

        $pesanan = Pesanan::with(['kegiatan', 'penyedia', 'penerima', 'barang'])
            ->where('userID', $id)
            ->get();

        $totals = Pesanan::where('userID', $id)->sum('total');

        // Ambil data kegiatan dengan total per kegiatan
        $kegiatanData = Pesanan::with('kegiatan')
            ->where('userID', $id)
            ->select('kegiatanID', DB::raw('SUM(total) as total_per_kegiatan'), DB::raw('COUNT(*) as jumlah_pesanan'))
            ->groupBy('kegiatanID')
            ->get();

        return view('dashboard', compact('pesanan', 'totals', 'kegiatanData'));
    }

    public function addSession()
    {
        $lastInvoiceNum = Pesanan::where('userID', Auth::id())->max(DB::raw('CAST(invoice_num AS UNSIGNED)'));
        $lastOrderNum = Pesanan::where('userID', Auth::id())->max(DB::raw('CAST(order_num AS UNSIGNED)'));
        $lastNoteNum = Pesanan::where('userID', Auth::id())->max(DB::raw('CAST(note_num AS UNSIGNED)'));
        $lastBastNum = Pesanan::where('userID', Auth::id())->max(DB::raw('CAST(bast_num AS UNSIGNED)'));

        $lastInvoiceNum = $lastInvoiceNum ??= 0;
        $lastOrderNum = $lastOrderNum ??= 0;
        $lastNoteNum = $lastNoteNum ??= 0;
        $lastBastNum = $lastBastNum ??= 0;

        $id = Auth::id();
        $kegiatan = Kegiatan::where('userID', $id)->get();
        $penyedia = Penyedia::where('userID', $id)->get();
        $penerima = Penerima::where('userID', $id)->get();
        $bendahara = Bendahara::where('userID', $id)->get();
        $kepsek = Kepsek::where('userID', $id)->get();
        return view('eksternal.pesanan.add', compact('kegiatan', 'penyedia', 'kepsek', 'penerima', 'bendahara', 'lastInvoiceNum', 'lastOrderNum', 'lastNoteNum', 'lastBastNum'));
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
            'tax'   => 'required|numeric',
            'shipping_cost'   => 'required',
            'kegiatanID'    => 'required|exists:kegiatan,id',
            'penyediaID'    => 'required|exists:penyedia,id',
            'penerimaID'    => 'required|exists:penerima,id',
            'bendaharaID'   => 'required|exists:bendahara,id',
            'kepsekID'   => 'required|exists:kepsek,id',
            'accepted'          => "required|date|after_or_equal:$kegiatan->order",
            'billing'          => "nullable|date",
            'paid'          => 'required|date|after_or_equal:2025-01-01',
            'prey' => 'required|date',
            'order_date' => 'required|date',
            'pic' => 'required|string'
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

            // Simpan persentase pajak untuk perhitungan nanti
            $taxPercentage = $data['tax'];

            // Buat pesanan dengan total dan tax sementara = 0
            $data['total'] = 0;
            $data['tax'] = 0;

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

            $totalBarang = Barang::where('pesananID', $pesanan->id)->sum('total');

            $calculatedTax = ($totalBarang * $taxPercentage) / 100;

            $pesanan->update([
                'total' => $totalBarang,
                'tax' => $calculatedTax
            ]);

            DB::commit();
            session()->forget('step1_data');
            return redirect()->route('eksternal.pesanan.index')
                ->with('success', 'Data Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpanan pesanan: ' . $e->getMessage()])->withInput();
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ], [
            'excel_file.required' => 'File Excel wajib diupload',
            'excel_file.mimes' => 'Format file harus .xlsx, .xls, atau .csv',
            'excel_file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $file = $request->file('excel_file');
            $filePath = $file->getRealPath();

            Log::info('Processing file:', [
                'originalName' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'mimeType' => $file->getMimeType(),
                'realPath' => $filePath,
                'exists' => file_exists($filePath),
                'size' => file_exists($filePath) ? filesize($filePath) : 0
            ]);

            if (!file_exists($filePath)) {
                throw new \Exception('File upload tidak ditemukan di path: ' . $filePath);
            }

            // Langsung proses tanpa validasi extension di SpreadsheetHelper
            // karena Laravel sudah validasi di request
            DB::beginTransaction();

            try {
                // Load spreadsheet langsung
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
                $reader->setReadDataOnly(true);
                $reader->setReadEmptyCells(false);

                $spreadsheet = $reader->load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();

                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                if ($highestRow <= 1) {
                    throw new \Exception('File Excel kosong atau hanya memiliki header');
                }

                Log::info('Spreadsheet loaded:', [
                    'rows' => $highestRow,
                    'columns' => $highestColumn
                ]);

                // Buat pesanan
                $userId = Auth::id();
                $pesanan = Pesanan::create([
                    'userID' => $userId,
                    'invoice_num' => 'IMP-' . time() . '-' . rand(1000, 9999),
                    'order_num' => 'ORD-' . time() . '-' . rand(1000, 9999),
                    'note_num' => 'NOT-' . time() . '-' . rand(1000, 9999),
                    'bast_num' => 'BST-' . time() . '-' . rand(1000, 9999),
                    'type_num' => $highestRow - 1,
                    'tax' => 0,
                    'shipping_cost' => 0,
                    'total' => 0,
                    'order_date' => \Carbon\Carbon::now(),
                    'paid' => \Carbon\Carbon::now()->addDays(30),
                    'accepted' => \Carbon\Carbon::now(),
                    'prey' => \Carbon\Carbon::now(),
                    'pic' => 'Import Excel - ' . \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                    'kegiatanID' => null,
                    'penyediaID' => null,
                    'penerimaID' => null,
                    'bendaharaID' => null,
                    'kepsekID' => null,
                    'billing' => null
                ]);

                // Deteksi kolom dari header
                $columnMapping = [];
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $headerValue = trim($worksheet->getCell($col . '1')->getCalculatedValue());
                    if (empty($headerValue)) continue;

                    $cleanHeader = strtolower(str_replace([' ', '_', '-', '/', '.'], '', $headerValue));

                    if (in_array($cleanHeader, ['namabarang', 'nama', 'barang', 'item', 'produk'])) {
                        $columnMapping['nama'] = $col;
                    } elseif (in_array($cleanHeader, ['qty', 'quantity', 'jumlah', 'jml'])) {
                        $columnMapping['qty'] = $col;
                    } elseif (in_array($cleanHeader, ['satuan', 'unit', 'sat'])) {
                        $columnMapping['unit'] = $col;
                    } elseif (in_array($cleanHeader, ['harga', 'price', 'hargarp', 'rp'])) {
                        $columnMapping['harga'] = $col;
                    }
                }

                Log::info('Column mapping:', $columnMapping);

                // Validasi kolom wajib
                if (!isset($columnMapping['nama']) || !isset($columnMapping['qty']) || !isset($columnMapping['harga'])) {
                    throw new \Exception('Kolom wajib tidak ditemukan. Pastikan ada kolom: Nama Barang, Qty, Harga');
                }

                // Proses data
                $totalBarang = 0;
                $processedRows = 0;

                for ($row = 2; $row <= $highestRow; $row++) {
                    try {
                        $nama = trim($worksheet->getCell($columnMapping['nama'] . $row)->getCalculatedValue());
                        $qty = (float)$worksheet->getCell($columnMapping['qty'] . $row)->getCalculatedValue();
                        $harga = (float)$worksheet->getCell($columnMapping['harga'] . $row)->getCalculatedValue();

                        $unit = 'unit'; // default
                        if (isset($columnMapping['unit'])) {
                            $unitValue = trim($worksheet->getCell($columnMapping['unit'] . $row)->getCalculatedValue());
                            if (!empty($unitValue)) {
                                $unit = $unitValue;
                            }
                        }

                        // Skip baris kosong
                        if (empty($nama) && $qty == 0 && $harga == 0) {
                            continue;
                        }

                        if (empty($nama)) {
                            Log::warning("Row {$row}: Nama barang kosong");
                            continue;
                        }

                        if ($qty <= 0) $qty = 1;
                        if ($harga < 0) $harga = 0;

                        $total = $qty * $harga;
                        $totalBarang += $total;

                        Barang::create([
                            'pesananID' => $pesanan->id,
                            'userID' => $userId,
                            'name' => $nama,
                            'price' => $harga,
                            'amount' => $qty,
                            'unit' => $unit,
                            'total' => $total
                        ]);

                        $processedRows++;
                    } catch (\Exception $e) {
                        Log::error("Error processing row {$row}: " . $e->getMessage());
                        continue;
                    }
                }

                // Update total pesanan
                $pesanan->update(['total' => $totalBarang]);

                // Cleanup
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);

                DB::commit();

                Log::info('Import completed:', [
                    'processedRows' => $processedRows,
                    'totalAmount' => $totalBarang
                ]);

                return redirect()->route('eksternal.pesanan.index')
                    ->with('success', "Data berhasil diimport dari Excel. {$processedRows} item berhasil diproses. " .
                        'Silakan edit pesanan untuk melengkapi data Kegiatan, Penyedia, dan Penerima.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Import failed:', [
                'error' => $e->getMessage(),
                'file' => isset($file) ? $file->getClientOriginalName() : 'unknown'
            ]);

            return redirect()->route('eksternal.pesanan.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function saveTotal(Request $request, $id)
    {
        $request->validate([
            'profit' => 'required|numeric'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'profit' => $request->profit
        ]);

        return redirect()->route('eksternal.pesanan.index')
            ->with('success', 'Data Pesanan (Total) berhasil ditambahkan.');
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
        $kepsek = Kepsek::where('userID', $userID)->get();

        $totalBarang = $pesanan->barang->sum('total');
        $taxPercentage = 0;

        if ($totalBarang > 0 && $pesanan->tax > 0) {
            $taxPercentage = ($pesanan->tax / $totalBarang) * 100;
        }

        session([
            'edit_pesanan' => array_merge($pesanan->toArray(), [
                'type_num' => $pesanan->type_num,
                'tax_percentage' => $taxPercentage // Simpan persentase pajak
            ]),
            'edit_barang' => $pesanan->barang,
        ]);

        return view('eksternal.pesanan.edit', compact('pesanan', 'kegiatan', 'penyedia', 'penerima', 'bendahara', 'kepsek'));
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
            'kepsekID'   => 'required|exists:kepsek,id',
            'accepted'          => "required|date|after_or_equal:$kegiatan->order",
            'billing'          => "nullable|date",
            'paid'          => "required|date|after_or_equal:$kegiatan->order",
            'prey' => 'required|date',
            'order_date' => 'required|date',
            'pic' => 'required|string'
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

            $taxPercentage = $editPesanan['tax'];

            $editPesanan['total'] = 0;
            $editPesanan['tax'] = 0;

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
                    Barang::create([
                        'pesananID' => $pesanan->id,
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

            $totalBarang = Barang::where('pesananID', $pesanan->id)->sum('total');

            $calculatedTax = ($totalBarang * $taxPercentage) / 100;

            $pesanan->update([
                'total' => $totalBarang,
                'tax' => $calculatedTax
            ]);
        });

        session()->forget(['edit_pesanan', 'edit_barang', 'data_editPesanan']);

        return redirect()->route('eksternal.pesanan.index')
            ->with('success', 'Data Pesanan berhasil diperbarui.');
    }

    public function export($id)
    {
        $userID = Auth::id();
        $pesanan = Pesanan::with(['barang', 'penyedia', 'bendahara'])->findOrFail($id);
        // return response()->json($pesanan);
        $kepsek = Kepsek::where('userID', $userID)->first(); // Ambil data kepala sekolah terakhir (atau sesuaikan)

        return view('template', compact('pesanan', 'kepsek'));
    }
}
