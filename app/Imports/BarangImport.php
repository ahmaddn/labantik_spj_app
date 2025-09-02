<?php
namespace App\Imports;

use Illuminate\Support\Carbon;
use App\Models\Pesanan;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Exceptions\ExcelImportException;
use App\Helpers\SpreadsheetHelper;
use Illuminate\Support\Facades\Log;

class BarangImport
{
    protected $errors = [];
    protected $processedRows = 0;
    protected $totalRows = 0;

    public function import($filePath)
    {
        $startTime = microtime(true);
        $userId = Auth::id();

        try {
            // Validate file first
            $fileInfo = SpreadsheetHelper::validateFile($filePath);
            $this->totalRows = $fileInfo['totalRows'] - 1; // Exclude header

            SpreadsheetHelper::logImport($userId, basename($filePath), 'started', [
                'total_rows' => $this->totalRows,
                'file_size' => filesize($filePath),
                'memory_before' => SpreadsheetHelper::getMemoryInfo()
            ]);

            DB::beginTransaction();

            // Load spreadsheet
            $reader = SpreadsheetHelper::createReader($filePath);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get dimensions
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            if ($highestRow <= 1) {
                throw new \Exception('File Excel kosong atau tidak valid');
            }

            // Create pesanan
            $pesanan = $this->createPesanan($userId, $highestRow - 1);

            // Process headers
            $headers = $this->extractHeaders($worksheet, $highestColumn);
            $columnMapping = SpreadsheetHelper::mapHeaders($headers);

            // Validate required columns
            $this->validateRequiredColumns($columnMapping);

            // Process data rows
            $totalBarang = $this->processDataRows($worksheet, $pesanan, $columnMapping, $highestRow, $highestColumn);

            // Update pesanan total
            $pesanan->update(['total' => $totalBarang]);

            DB::commit();

            $endTime = microtime(true);
            $processingTime = round($endTime - $startTime, 2);

            SpreadsheetHelper::logImport($userId, basename($filePath), 'completed', [
                'processed_rows' => $this->processedRows,
                'total_amount' => $totalBarang,
                'processing_time' => $processingTime,
                'memory_after' => SpreadsheetHelper::getMemoryInfo(),
                'errors_count' => count($this->errors)
            ]);

            // Clean up memory
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            if (!empty($this->errors)) {
                $exception = new ExcelImportException("Import completed with errors", $this->errors);
                foreach ($this->errors as $error) {
                    $exception->addError($error['row'], $error['column'], $error['message']);
                }
                throw $exception;
            }

        } catch (ExcelImportException $e) {
            DB::rollBack();
            SpreadsheetHelper::logImport($userId, basename($filePath), 'failed_with_errors', [
                'errors' => $this->errors,
                'processing_time' => isset($processingTime) ? $processingTime : 0
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            SpreadsheetHelper::logImport($userId, basename($filePath), 'failed', [
                'error' => $e->getMessage(),
                'processing_time' => isset($processingTime) ? $processingTime : 0
            ]);
            throw $e;
        }
    }

    protected function createPesanan($userId, $totalRows)
    {
        return Pesanan::create([
            'userID' => $userId,
            'invoice_num' => 'IMP-' . time() . '-' . rand(1000, 9999),
            'order_num' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'note_num' => 'NOT-' . time() . '-' . rand(1000, 9999),
            'bast_num' => 'BST-' . time() . '-' . rand(1000, 9999),
            'type_num' => $totalRows,
            'tax' => 0,
            'shipping_cost' => 0,
            'total' => 0,
            'order_date' => Carbon::now(),
            'paid' => Carbon::now()->addDays(30),
            'accepted' => Carbon::now(),
            'prey' => Carbon::now(),
            'pic' => 'Import Excel - ' . Carbon::now()->format('Y-m-d H:i:s'),
            'kegiatanID' => null,
            'penyediaID' => null,
            'penerimaID' => null,
            'bendaharaID' => null,
            'kepsekID' => null,
            'billing' => null
        ]);
    }

    protected function extractHeaders($worksheet, $highestColumn)
    {
        $headers = [];
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $headerValue = $worksheet->getCell($col . '1')->getCalculatedValue();
            if (!empty($headerValue)) {
                $headers[$col] = strtolower(trim(str_replace([' ', '_', '-'], '', $headerValue)));
            }
        }
        return $headers;
    }

    protected function validateRequiredColumns($columnMapping)
    {
        $required = ['nama_barang', 'quantity', 'price'];
        $missing = [];

        foreach ($required as $field) {
            if (!isset($columnMapping[$field])) {
                $missing[] = $field;
            }
        }

        if (!empty($missing)) {
            throw new \Exception('Kolom wajib tidak ditemukan: ' . implode(', ', $missing));
        }
    }

    protected function processDataRows($worksheet, $pesanan, $columnMapping, $highestRow, $highestColumn)
    {
        $totalBarang = 0;
        $userId = Auth::id();
        $maxErrors = config('phpspreadsheet.errors.max_errors_per_import', 50);

        for ($row = 2; $row <= $highestRow; $row++) {
            try {
                // Check if we've hit the max errors limit
                if (count($this->errors) >= $maxErrors) {
                    $this->errors[] = [
                        'row' => $row,
                        'column' => 'general',
                        'message' => "Terlalu banyak error. Import dihentikan pada baris {$row}."
                    ];
                    break;
                }

                // Get row data
                $rowData = [];
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cellValue = $worksheet->getCell($col . $row)->getCalculatedValue();
                    $rowData[$col] = $cellValue;
                }

                // Extract data using column mapping
                $namaBarang = $this->getValueFromColumnMapping($rowData, $columnMapping, 'nama_barang');
                $qty = $this->getNumericValueFromColumnMapping($rowData, $columnMapping, 'quantity');
                $satuan = $this->getValueFromColumnMapping($rowData, $columnMapping, 'unit', 'unit'); // default value
                $harga = $this->getNumericValueFromColumnMapping($rowData, $columnMapping, 'price');

                // Skip completely empty rows
                if (empty($namaBarang) && $qty == 0 && $harga == 0) {
                    continue;
                }

                // Validate data
                $errors = $this->validateRowData($namaBarang, $qty, $harga, $row);
                if (!empty($errors)) {
                    $this->errors = array_merge($this->errors, $errors);

                    if (config('phpspreadsheet.errors.stop_on_error', false)) {
                        break;
                    }
                    continue;
                }

                $total = $qty * $harga;
                $totalBarang += $total;

                // Create barang
                Barang::create([
                    'pesananID' => $pesanan->id,
                    'userID' => $userId,
                    'name' => $namaBarang,
                    'price' => $harga,
                    'amount' => $qty,
                    'unit' => $satuan,
                    'total' => $total
                ]);

                $this->processedRows++;

            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $row,
                    'column' => 'general',
                    'message' => 'Error processing row: ' . $e->getMessage()
                ];

                if (config('phpspreadsheet.errors.stop_on_error', false)) {
                    break;
                }
            }
        }

        return $totalBarang;
    }

    protected function getValueFromColumnMapping($rowData, $columnMapping, $field, $default = '')
    {
        if (isset($columnMapping[$field]) && isset($rowData[$columnMapping[$field]])) {
            $value = trim($rowData[$columnMapping[$field]]);
            return !empty($value) ? $value : $default;
        }
        return $default;
    }

    protected function getNumericValueFromColumnMapping($rowData, $columnMapping, $field)
    {
        if (isset($columnMapping[$field]) && isset($rowData[$columnMapping[$field]])) {
            return SpreadsheetHelper::cleanNumericValue($rowData[$columnMapping[$field]]);
        }
        return 0;
    }

    protected function validateRowData($namaBarang, $qty, $harga, $rowNumber)
    {
        $errors = [];

        if (empty($namaBarang)) {
            $errors[] = [
                'row' => $rowNumber,
                'column' => 'nama_barang',
                'message' => 'Nama barang tidak boleh kosong'
            ];
        }

        if ($qty <= 0) {
            $errors[] = [
                'row' => $rowNumber,
                'column' => 'quantity',
                'message' => "Quantity harus lebih dari 0. Nilai: {$qty}"
            ];
        }

        if ($harga < 0) {
            $errors[] = [
                'row' => $rowNumber,
                'column' => 'price',
                'message' => "Harga tidak boleh negatif. Nilai: {$harga}"
            ];
        }

        return $errors;
    }

    public function getProcessedRows()
    {
        return $this->processedRows;
    }

    public function getTotalRows()
    {
        return $this->totalRows;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
