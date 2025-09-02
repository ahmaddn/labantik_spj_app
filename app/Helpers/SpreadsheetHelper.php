<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Log;

class SpreadsheetHelper
{
    /**
     * Detect file format and create appropriate reader
     */
    public static function createReader($filePath)
    {
        try {
            $inputFileType = IOFactory::identify($filePath);
            $reader = IOFactory::createReader($inputFileType);

            // Configure reader for better performance
            if ($inputFileType === 'Csv' && $reader instanceof \PhpOffice\PhpSpreadsheet\Reader\Csv) {
                $reader->setDelimiter(config('phpspreadsheet.csv.delimiter', ','));
                $reader->setEnclosure(config('phpspreadsheet.csv.enclosure', '"'));
                $reader->setInputEncoding(config('phpspreadsheet.csv.input_encoding', 'UTF-8'));
            }

            // Set read data only (no formatting) for better performance
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);

            return $reader;
        } catch (\Exception $e) {
            Log::error('SpreadsheetHelper: Failed to create reader', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get file info without fully loading it
     */
    public static function getFileInfo($filePath)
    {
        try {
            $reader = self::createReader($filePath);
            $spreadsheet = $reader->load($filePath);
            $worksheetData = [];
            foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                $worksheetData[] = [
                    'worksheetName' => $worksheet->getTitle(),
                    'totalRows' => $worksheet->getHighestRow(),
                    'totalColumns' => \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($worksheet->getHighestColumn()),
                ];
            }

            return [
                'worksheetCount' => count($worksheetData),
                'worksheets' => $worksheetData,
                'totalRows' => $worksheetData[0]['totalRows'] ?? 0,
                'totalColumns' => $worksheetData[0]['totalColumns'] ?? 0,
            ];
        } catch (\Exception $e) {
            Log::error('SpreadsheetHelper: Failed to get file info', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Validate file before processing
     */
    public static function validateFile($filePath, $maxSizeKB = null)
    {
        $maxSize = $maxSizeKB ?? config('phpspreadsheet.import.max_file_size', 2048);

        // Check file exists
        if (!file_exists($filePath)) {
            throw new \Exception('File tidak ditemukan');
        }

        // Check file size
        $fileSizeKB = filesize($filePath) / 1024;
        if ($fileSizeKB > $maxSize) {
            throw new \Exception("Ukuran file terlalu besar. Maksimal {$maxSize}KB, file Anda {$fileSizeKB}KB");
        }

        // Check file extension
        $allowedExtensions = config('phpspreadsheet.import.allowed_extensions', ['xlsx', 'xls', 'csv']);
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Format file tidak didukung. Format yang diizinkan: ' . implode(', ', $allowedExtensions));
        }

        // Try to get basic info
        $info = self::getFileInfo($filePath);

        if ($info['totalRows'] <= 1) {
            throw new \Exception('File kosong atau hanya memiliki header');
        }

        return $info;
    }

    /**
     * Clean and convert numeric values
     */
    public static function cleanNumericValue($value)
    {
        // Handle Excel date values
        if (Date::isDateTime($value)) {
            return 0; // or convert to appropriate numeric value
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        if (!is_string($value)) {
            return 0;
        }

        // Remove currency symbols and extra spaces
        $cleaned = preg_replace('/[^\d.,\-+]/', '', trim($value));

        // Handle empty string
        if (empty($cleaned)) {
            return 0;
        }

        // Handle negative numbers
        $isNegative = strpos($value, '-') !== false;

        // Remove leading/trailing non-numeric chars except decimal separators
        $cleaned = preg_replace('/^[^\d]*/', '', $cleaned);
        $cleaned = preg_replace('/[^\d]*$/', '', $cleaned);

        if (empty($cleaned)) {
            return 0;
        }

        // Handle different decimal formats
        $dotCount = substr_count($cleaned, '.');
        $commaCount = substr_count($cleaned, ',');

        if ($dotCount === 0 && $commaCount === 0) {
            // Simple integer
            $result = (float) $cleaned;
        } elseif ($dotCount === 0 && $commaCount === 1) {
            // Format: 1000,50 (comma as decimal separator)
            $result = (float) str_replace(',', '.', $cleaned);
        } elseif ($dotCount === 1 && $commaCount === 0) {
            // Format: 1000.50 (dot as decimal separator)
            $result = (float) $cleaned;
        } elseif ($dotCount > 1 && $commaCount === 1) {
            // Format: 1.000.000,50 (European format)
            $parts = explode(',', $cleaned);
            $integerPart = str_replace('.', '', $parts[0]);
            $decimalPart = $parts[1] ?? '0';
            $result = (float) ($integerPart . '.' . $decimalPart);
        } elseif ($commaCount > 1 && $dotCount === 1) {
            // Format: 1,000,000.50 (US format)
            $result = (float) str_replace(',', '', $cleaned);
        } elseif ($dotCount === 1 && $commaCount === 1) {
            // Ambiguous: could be 1.000,50 or 1,000.50
            $lastCommaPos = strrpos($cleaned, ',');
            $lastDotPos = strrpos($cleaned, '.');

            if ($lastCommaPos > $lastDotPos) {
                // Format: 1.000,50 (European)
                $parts = explode(',', $cleaned);
                $integerPart = str_replace('.', '', $parts[0]);
                $decimalPart = $parts[1] ?? '0';
                $result = (float) ($integerPart . '.' . $decimalPart);
            } else {
                // Format: 1,000.50 (US)
                $result = (float) str_replace(',', '', $cleaned);
            }
        } else {
            // Fallback: remove all separators except the last one as decimal
            $cleaned = preg_replace('/[,.]/', '', $cleaned);
            $result = (float) $cleaned;
        }

        return $isNegative ? -abs($result) : $result;
    }

    /**
     * Map column headers to expected fields
     */
    public static function mapHeaders($headers)
    {
        $mapping = config('phpspreadsheet.validation.required_columns', []);
        $mapped = [];

        foreach ($headers as $column => $header) {
            $cleanHeader = strtolower(str_replace([' ', '_', '-', '/'], '', $header));

            foreach ($mapping as $field => $possibleNames) {
                foreach ($possibleNames as $possibleName) {
                    $cleanPossible = strtolower(str_replace([' ', '_', '-', '/'], '', $possibleName));
                    if ($cleanHeader === $cleanPossible) {
                        $mapped[$field] = $column;
                        break 2;
                    }
                }
            }
        }

        return $mapped;
    }

    /**
     * Log import activity
     */
    public static function logImport($userId, $fileName, $status, $details = [])
    {
        if (!config('phpspreadsheet.errors.log_errors', true)) {
            return;
        }

        $logData = [
            'user_id' => $userId,
            'file_name' => $fileName,
            'status' => $status,
            'timestamp' => now(),
            'details' => $details
        ];

        $channel = config('phpspreadsheet.errors.log_channel', 'daily');
        Log::channel($channel)->info('Excel Import', $logData);
    }

    /**
     * Get memory usage info
     */
    public static function getMemoryInfo()
    {
        return [
            'current' => memory_get_usage(true),
            'current_formatted' => self::formatBytes(memory_get_usage(true)),
            'peak' => memory_get_peak_usage(true),
            'peak_formatted' => self::formatBytes(memory_get_peak_usage(true)),
            'limit' => ini_get('memory_limit'),
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private static function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $base = log($size, 1024);
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
    }
}
