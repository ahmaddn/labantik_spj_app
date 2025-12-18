<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Expenditure;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function index(Request $request)
    {
    // Ambil pesanan terbaru dulu (newest -> oldest)
    $query = Pesanan::where('userID', Auth::id())->with(['kegiatan', 'penerima'])->orderByDesc('order_date');

        // Apply date filters
        if ($request->start_date) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $pesanan = $query->get();
        $totalKeuntungan = $pesanan->sum('profit');


        return view('report.index', compact('pesanan', 'totalKeuntungan'));
    }

    public function exportExcel(Request $request)
    {
        // Query untuk pesanan dengan filter
    // Untuk export Excel: ambil pesanan terbaru terlebih dahulu
    $pesananQuery = Pesanan::where('userID', Auth::id())->with(['kegiatan', 'penerima'])->orderByDesc('order_date');

        if ($request->start_date) {
            $pesananQuery->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $pesananQuery->whereDate('order_date', '<=', $request->end_date);
        }

        $pesanan = $pesananQuery->get();

        // Query untuk expenditure dengan filter yang sama
    // Ambil pengeluaran terbaru terlebih dahulu
    $expenditureQuery = Expenditure::where('user_id', Auth::id())->orderByDesc('date');

        if ($request->start_date) {
            $expenditureQuery->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $expenditureQuery->whereDate('date', '<=', $request->end_date);
        }

        $expenditure = $expenditureQuery->get();

        // Gabungkan data dan urutkan berdasarkan tanggal
        $allTransactions = collect();

        // Tambahkan data pesanan (pemasukan)
        foreach ($pesanan as $p) {
            $allTransactions->push([
                'date' => $p->order_date,
                'type' => 'income',
                'project_name' => $p->kegiatan->name ?? '',
                'responsible_person' => $p->pic ?? '',
                'nominal' => $p->total,
                'expense' => 0,
                'profit' => $p->profit,
                'description' => $p->kegiatan->info ?? ''
            ]);
        }

        // Tambahkan data pengeluaran
        foreach ($expenditure as $e) {
            $allTransactions->push([
                'date' => $e->date,
                'type' => 'expense',
                'project_name' => $e->type,
                'responsible_person' => $e->pic ?? '',
                'nominal' => 0,
                'expense' => $e->nominal,
                'profit' => -$e->nominal, // pengeluaran mengurangi saldo
                'description' => ''
            ]);
        }

        // Urutkan gabungan transaksi: terbaru (desc) -> lama
        $allTransactions = $allTransactions->sortByDesc(function ($t) {
            return $t['date'] ?? null;
        })->values();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerRow = 1;

        $headers = [
            'A' . $headerRow => 'No',
            'B' . $headerRow => 'Tanggal',
            'C' . $headerRow => 'Nama Projek/Kegiatan',
            'D' . $headerRow => 'Penanggung Jawab Projek',
            'E' . $headerRow => 'Nominal Keseluruhan',
            'F' . $headerRow => 'Pemasukan',
            'G' . $headerRow => 'Pengeluaran',
            'H' . $headerRow => 'Saldo',
            'I' . $headerRow => 'Keterangan'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        // Set style untuk header tabel utama
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E6E6FA');

        // Border untuk header
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Inisialisasi saldo
        $currentBalance = 0;
        $row = $headerRow + 1; // Mulai dari baris setelah header

        // Isi data tabel utama
        foreach ($allTransactions as $index => $transaction) {
            $sheet->setCellValue('A' . $row, $index + 1);

            // Format tanggal menggunakan Carbon dengan translatedFormat
            $dateFormatted = Carbon::parse($transaction['date'])->translatedFormat('d F Y');
            $sheet->setCellValue('B' . $row, $dateFormatted);

            $sheet->setCellValue('C' . $row, $transaction['project_name']);
            $sheet->setCellValue('D' . $row, $transaction['responsible_person']);

            // Nominal keseluruhan dan pemasukan/pengeluaran
            if ($transaction['type'] == 'income') {
                $sheet->setCellValue('E' . $row, 'Rp ' . number_format($transaction['nominal'], 0, ',', '.'));
                $sheet->setCellValue('F' . $row, 'Rp ' . number_format($transaction['profit'], 0, ',', '.'));
                $sheet->setCellValue('G' . $row, 'Rp -');
                $currentBalance += $transaction['profit']; // Gunakan profit untuk saldo
            } else {
                $sheet->setCellValue('E' . $row, 'Rp -');
                $sheet->setCellValue('F' . $row, 'Rp -');
                $sheet->setCellValue('G' . $row, 'Rp ' . number_format($transaction['expense'], 0, ',', '.'));
                $currentBalance -= $transaction['expense'];
            }

            $sheet->setCellValue('H' . $row, 'Rp ' . number_format($currentBalance, 0, ',', '.'));
            $sheet->setCellValue('I' . $row, $transaction['description']);

            // Border untuk setiap baris
            $sheet->getStyle('A' . $row . ':I' . $row)->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $row++;
        }

        // TABEL SUMMARY TERPISAH
        if ($allTransactions->count() > 0) {
            // Beri jarak 2 baris kosong antara tabel utama dan tabel summary
            $summaryStartRow = $row + 2;

            $sheet->getStyle('A' . $summaryStartRow)->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A' . $summaryStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $summaryStartRow . ':C' . $summaryStartRow)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('D3D3D3');

            $summaryHeaderRow = $summaryStartRow + 1;

            // Header kolom untuk tabel summary
            $sheet->setCellValue('A' . $summaryHeaderRow, 'Keterangan');
            $sheet->setCellValue('B' . $summaryHeaderRow, 'Jumlah');

            // Style untuk header tabel summary
            $sheet->getStyle('A' . $summaryHeaderRow . ':B' . $summaryHeaderRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $summaryHeaderRow . ':B' . $summaryHeaderRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $summaryHeaderRow . ':B' . $summaryHeaderRow)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E6E6FA');
            $sheet->getStyle('A' . $summaryHeaderRow . ':B' . $summaryHeaderRow)->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $summaryDataRow = $summaryHeaderRow + 1;

            // Baris total pemasukan
            $sheet->setCellValue('A' . $summaryDataRow, 'TOTAL PEMASUKAN');
            $sheet->setCellValue('B' . $summaryDataRow, 'Rp ' . number_format($allTransactions->where('type', 'income')->sum('profit'), 0, ',', '.'));

            // Style untuk baris total pemasukan
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFont()->setBold(true);
            $sheet->getStyle('B' . $summaryDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E8F5E8');
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $summaryDataRow++;

            // Baris total pengeluaran
            $sheet->setCellValue('A' . $summaryDataRow, 'TOTAL PENGELUARAN');
            $sheet->setCellValue('B' . $summaryDataRow, 'Rp ' . number_format($allTransactions->where('type', 'expense')->sum('expense'), 0, ',', '.'));

            // Style untuk baris total pengeluaran
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFont()->setBold(true);
            $sheet->getStyle('B' . $summaryDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFE8E8');
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $summaryDataRow++;

            // Baris saldo akhir
            $sheet->setCellValue('A' . $summaryDataRow, 'SALDO AKHIR');
            $sheet->setCellValue('B' . $summaryDataRow, 'Rp ' . number_format($currentBalance, 0, ',', '.'));

            // Style untuk baris saldo akhir
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFont()->setBold(true);
            $sheet->getStyle('B' . $summaryDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E8E8FF');
            $sheet->getStyle('A' . $summaryDataRow . ':B' . $summaryDataRow)->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }

        // Auto size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set style untuk angka (align right)
        if ($row > $headerRow + 1) {
            $sheet->getStyle('E' . ($headerRow + 1) . ':H' . ($row - 1))->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        $filename = 'Laporan_Keuangan';

        if ($request->start_date && $request->end_date) {
            $filename .= '_' . $request->start_date . '_sampai_' . $request->end_date;
        } elseif ($request->start_date) {
            $filename .= '_dari_' . $request->start_date;
        } elseif ($request->end_date) {
            $filename .= '_sampai_' . $request->end_date;
        } else {
            $filename .= '_Semua_Data';
        }

        $filename .= '_' . date('Y-m-d') . '.xlsx';

        // Set headers untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    // Method export Excel dengan filter daterange
    public function dataExcel(Request $request)
    {
        // Query untuk pesanan dengan filter
        $pesananQuery = Pesanan::where('userID', Auth::id())->with(['kegiatan', 'penerima'])->orderBy('order_date');

        if ($request->start_date) {
            $pesananQuery->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $pesananQuery->whereDate('order_date', '<=', $request->end_date);
        }

        $pesanan = $pesananQuery->get();

        // Query untuk expenditure dengan filter yang sama
        $expenditureQuery = Expenditure::where('user_id', Auth::id())->orderBy('date');

        if ($request->start_date) {
            $expenditureQuery->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $expenditureQuery->whereDate('date', '<=', $request->end_date);
        }

        $expenditure = $expenditureQuery->get();

        // Gabungkan data dan urutkan berdasarkan tanggal
        $allTransactions = collect();

        // Tambahkan data pesanan (pemasukan)
        foreach ($pesanan as $p) {
            $allTransactions->push([
                'date' => $p->order_date,
                'type' => 'income',
                'project_name' => $p->kegiatan->name ?? '',
                'responsible_person' => $p->pic ?? '',
                'nominal' => $p->total,
                'expense' => 0,
                'profit' => $p->profit,
                'description' => $p->kegiatan->info ?? ''
            ]);
        }

        // Tambahkan data pengeluaran
        foreach ($expenditure as $e) {
            $allTransactions->push([
                'date' => $e->date,
                'type' => 'expense',
                'project_name' => $e->type,
                'responsible_person' => $e->pic ?? '',
                'nominal' => 0,
                'expense' => $e->nominal,
                'profit' => -$e->nominal, // pengeluaran mengurangi saldo
                'description' => ''
            ]);
        }

        $allTransactions = $allTransactions->sortBy('date')->values();

        // Buat HTML untuk tampilan
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .report-title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th {
            background-color: #E6E6FA;
            border: 1px solid #ccc;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            color: #333;
            white-space: nowrap;
        }
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            white-space: nowrap;
        }
        .number {
            text-align: right;
            white-space: nowrap;
            min-width: 120px;
        }
        .center {
            text-align: center;
            white-space: nowrap;
        }
        .summary-table {
            width: 300px;
            margin-top: 30px;
        }
        .summary-header {
            background-color: #E6E6FA !important;
        }
        .income-row {
            background-color: #E8F5E8;
        }
        .expense-row {
            background-color: #FFE8E8;
        }
        .balance-row {
            background-color: #E8E8FF;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-btn:hover {
            background-color: #45a049;
        }
        .description {
            white-space: normal;
            max-width: 200px;
            padding: 12px 15px;
            line-height: 1.5;
        }
        @media print {
            .print-btn { display: none; }
            body { background-color: white; }
        }
    </style>
</head>
<body>

    <a class="print-btn" href="' . route('report.index') . '">Kembali</a>
    <h1 class="report-title">LAPORAN KEUANGAN';

        if ($request->start_date && $request->end_date) {
            $html .= '<br><small>Periode: ' . $request->start_date . ' s/d ' . $request->end_date . '</small>';
        } elseif ($request->start_date) {
            $html .= '<br><small>Mulai dari: ' . $request->start_date . '</small>';
        } elseif ($request->end_date) {
            $html .= '<br><small>Sampai: ' . $request->end_date . '</small>';
        } else {
            $html .= '<br><small>Semua Data</small>';
        }

        $html .= '</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Projek/Kegiatan</th>
                <th>Penanggung Jawab Projek</th>
                <th>Nominal Keseluruhan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>';

        $currentBalance = 0;

        foreach ($allTransactions as $index => $transaction) {
            $html .= '<tr>';
            $html .= '<td class="center">' . ($index + 1) . '</td>';

            $dateFormatted = Carbon::parse($transaction['date'])->translatedFormat('d F Y');
            $html .= '<td class="center">' . $dateFormatted . '</td>';

            $html .= '<td>' . $transaction['project_name'] . '</td>';
            $html .= '<td>' . $transaction['responsible_person'] . '</td>';

            if ($transaction['type'] == 'income') {
                $html .= '<td class="number">Rp ' . number_format($transaction['nominal'], 0, ',', '.') . '</td>';
                $html .= '<td class="number">Rp ' . number_format($transaction['profit'], 0, ',', '.') . '</td>';
                $html .= '<td class="number">Rp -</td>';
                $currentBalance += $transaction['profit'];
            } else {
                $html .= '<td class="number">Rp -</td>';
                $html .= '<td class="number">Rp -</td>';
                $html .= '<td class="number">Rp ' . number_format($transaction['expense'], 0, ',', '.') . '</td>';
                $currentBalance -= $transaction['expense'];
            }

            $html .= '<td class="number">Rp ' . number_format($currentBalance, 0, ',', '.') . '</td>';
            $html .= '<td class="description">' . $transaction['description'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // TABEL SUMMARY
        if ($allTransactions->count() > 0) {
            $totalIncome = $allTransactions->where('type', 'income')->sum('profit');
            $totalExpense = $allTransactions->where('type', 'expense')->sum('expense');

            $html .= '
    <table class="summary-table">
        <thead>
            <tr>
                <th class="summary-header">Keterangan</th>
                <th class="summary-header">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr class="income-row">
                <td><strong>TOTAL PEMASUKAN</strong></td>
                <td class="number"><strong>Rp ' . number_format($totalIncome, 0, ',', '.') . '</strong></td>
            </tr>
            <tr class="expense-row">
                <td><strong>TOTAL PENGELUARAN</strong></td>
                <td class="number"><strong>Rp ' . number_format($totalExpense, 0, ',', '.') . '</strong></td>
            </tr>
            <tr class="balance-row">
                <td><strong>SALDO AKHIR</strong></td>
                <td class="number"><strong>Rp ' . number_format($currentBalance, 0, ',', '.') . '</strong></td>
            </tr>
        </tbody>
    </table>';
        }

        $html .= '
</body>
</html>';
        // Return response dengan HTML
        return response($html)->header('Content-Type', 'text/html');
    }
}
