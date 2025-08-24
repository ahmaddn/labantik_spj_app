<?php

namespace App\Http\Controllers;

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
        $query = Pesanan::with(['kegiatan', 'penerima'])->orderBy('order_date');

        // Apply date filters
        if ($request->start_date) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $pesanan = $query->get();

        return view('report.index', compact('pesanan'));
    }

    // Method export Excel dengan filter daterange
    public function exportExcel(Request $request)
    {
        // Query untuk pesanan dengan filter
        $pesananQuery = Pesanan::with(['kegiatan', 'penerima'])->orderBy('order_date');

        if ($request->start_date) {
            $pesananQuery->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $pesananQuery->whereDate('order_date', '<=', $request->end_date);
        }

        $pesanan = $pesananQuery->get();

        // Query untuk expenditure dengan filter yang sama
        $expenditureQuery = Expenditure::orderBy('date');

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
                'responsible_person' => $p->penerima->name ?? '',
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
                'description' => $e->qty ?? ''
            ]);
        }

        $allTransactions = $allTransactions->sortBy('date')->values();

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
            $dateFormatted = \Carbon\Carbon::parse($transaction['date'])->translatedFormat('d F Y');
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

            // Header untuk tabel summary
            $sheet->setCellValue('A' . $summaryStartRow, 'RINGKASAN KEUANGAN');
            $sheet->mergeCells('A' . $summaryStartRow . ':C' . $summaryStartRow);
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
}
