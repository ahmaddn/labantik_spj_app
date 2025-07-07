<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\Tcpdf\Fpdi;

class PDFWatermarkController extends Controller
{
    public function index()
    {
        return view('watermark');

    }

    public function uploadPDF(Request $request)
    {
        try {
            $request->validate([
                'pdf_file' => 'required|mimes:pdf|max:10240', // 10MB max
            ]);

            $file = $request->file('pdf_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('temp/pdfs', $filename, 'public');

            // Generate preview (convert first page to image)
            $previewPath = $this->generatePDFPreview($path);

            return response()->json([
                'success' => true,
                'pdf_path' => $path,
                'preview_path' => $path, // Kembalikan path PDF asli
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            Log::error('PDF Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadWatermark(Request $request)
    {
        try {
            $request->validate([
                'watermark_file' => 'required|mimes:png,jpg,jpeg|max:5120', // 5MB max
            ]);

            $file = $request->file('watermark_file');
            $filename = time() . '_watermark_' . $file->getClientOriginalName();
            $path = $file->storeAs('temp/watermarks', $filename, 'public');

            return response()->json([
                'success' => true,
                'watermark_path' => $path,
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            Log::error('Watermark Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload watermark: ' . $e->getMessage()
            ], 500);
        }
    }

    public function applyWatermark(Request $request)
    {
        try {
            $request->validate([
                'pdf_path' => 'required|string',
                'watermark_path' => 'required|string',
                'vertical_position' => 'sometimes|in:top,center,bottom',
                'horizontal_position' => 'sometimes|in:left,center,right',
                'opacity' => 'required|numeric|min:0|max:1',
                'as_background' => 'sometimes|string|in:true,false',
                'scale' => 'required|numeric|min:1|max:100',
                'full_cover' => 'sometimes|string|in:true,false'
            ]);

            $pdfPath = storage_path('app/public/' . $request->pdf_path);
            $watermarkPath = storage_path('app/public/' . $request->watermark_path);

            if (!file_exists($pdfPath)) {
                throw new \Exception('PDF file tidak ditemukan');
            }

            if (!file_exists($watermarkPath)) {
                throw new \Exception('Watermark file tidak ditemukan');
            }

            // Konversi PDF ke format yang lebih kompatibel
            $convertedPdfPath = $this->convertPDF($pdfPath);
            if (!$convertedPdfPath) {
                throw new \Exception('Gagal mengkonversi PDF');
            }

            $asBackground = $request->as_background === 'true';
            $fullCover = $request->full_cover === 'true';

            $outputPath = $this->addWatermarkToPDF(
                $convertedPdfPath,
                $watermarkPath,
                $request->vertical_position ?? 'top',
                $request->horizontal_position ?? 'right',
                $request->opacity,
                $asBackground,
                $fullCover,
                $scale = $request->scale ?? 100
            );
            return response()->json([
                'success' => true,
                'watermarked_pdf' => $outputPath,
                'preview_path' => $outputPath // Pastikan menggunakan path yang sama
            ]);

            // Hapus file hasil konversi
            if ($convertedPdfPath != $pdfPath) {
                @unlink($convertedPdfPath);
            }

            // Generate new preview
            $previewPath = $this->generatePDFPreview($outputPath);

            return response()->json([
                'success' => true,
                'watermarked_pdf' => $outputPath,
                'preview_path' => $previewPath
            ]);
        } catch (\Exception $e) {
            Log::error('Apply Watermark Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function convertPDF($pdfPath)
    {
        // Cek apakah Ghostscript tersedia
        if (!$this->hasGhostscript()) {
            return $pdfPath; // Gunakan as-is jika tidak ada Ghostscript
        }

        try {
            $outputPath = tempnam(sys_get_temp_dir(), 'conv_') . '.pdf';

            $command = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite " .
                "-dCompatibilityLevel=1.7 -dPDFSETTINGS=/prepress " .
                "-sOutputFile=" . escapeshellarg($outputPath) . " " .
                escapeshellarg($pdfPath);

            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {



            }
            if ($returnCode !== 0) {
                throw new \Exception("Ghostscript error: $returnCode");
            }

            if (!file_exists($outputPath) || filesize($outputPath) === 0) {
                throw new \Exception('File hasil konversi tidak valid');
             }
         return $outputPath;
        } catch (\Exception $e) {
            Log::error('PDF Conversion Error: ' . $e->getMessage());
        }

        return $pdfPath; // Fallback ke file asli jika konversi gagal
    }

    private function addWatermarkToPDF($pdfPath, $watermarkPath, $vPos, $hPos, $opacity, $asBackground, $fullCover,$scale
)
    {
        try {
            $pdf = new Fpdi();

            // Set PDF parser options
            $pdf->setSourceFile($pdfPath);
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Get watermark image info
            $imageInfo = getimagesize($watermarkPath);
            if (!$imageInfo) {
                throw new \Exception('Tidak dapat membaca informasi watermark image');
            }

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                try {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

                    // Full Cover Watermark
                    if ($fullCover) {
                        $pdf->SetAlpha($opacity);
                        $pdf->Image($watermarkPath, 0, 0, $size['width'], $size['height']);
                        $pdf->SetAlpha(1);
                        $pdf->useTemplate($templateId);
                    }
                    // Normal Watermark
                    else {
                        // Calculate watermark position
                        $positions = $this->calculateWatermarkPosition(
                            $size['width'],
                            $size['height'],
                            $imageInfo[0],
                            $imageInfo[1],
                            $vPos,
                            $hPos,
                                                    $scale // TAMBAHKAN PARAMETER SCALE

                        );

                        if ($asBackground) {
                            // Add watermark first (as background)
                            $pdf->SetAlpha($opacity);
                            $pdf->Image($watermarkPath, $positions['x'], $positions['y'], $positions['width'], $positions['height']);
                            $pdf->SetAlpha(1);
                            // Then add original PDF content
                            $pdf->useTemplate($templateId);
                        } else {
                            // Add original PDF content first
                            $pdf->useTemplate($templateId);
                            // Then add watermark on top
                            $pdf->SetAlpha($opacity);
                            $pdf->Image($watermarkPath, $positions['x'], $positions['y'], $positions['width'], $positions['height']);
                            $pdf->SetAlpha(1);
                        }
                    }
                } catch (\Exception $pageError) {
                    Log::error("Error processing page $pageNo: " . $pageError->getMessage());
                    continue;
                }
            }

            $outputFilename = 'watermarked_' . time() . '.pdf';
            $outputPath = 'temp/watermarked/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);

            // Create directory if not exists
            if (!file_exists(dirname($fullOutputPath))) {
                mkdir(dirname($fullOutputPath), 0755, true);
            }

            $pdf->Output($fullOutputPath, 'F');

            // Simpan ke file sementara dulu
            $tempOutputPath = tempnam(sys_get_temp_dir(), 'watermarked_') . '.pdf';
            $pdf->Output($tempOutputPath, 'F');

            // Validasi file output
            if (!file_exists($tempOutputPath) || filesize($tempOutputPath) === 0) {
                throw new \Exception('Output PDF tidak valid');
            }

            // Pindahkan ke storage publik
            $outputFilename = 'watermarked_' . time() . '.pdf';
            $outputPath = 'temp/watermarked/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);

            rename($tempOutputPath, $fullOutputPath);
            return $outputPath;
        } catch (\Exception $e) {
            Log::error('Add Watermark Error: ' . $e->getMessage());
            throw new \Exception('Gagal menerapkan watermark: ' . $e->getMessage());
        }
    }


    private function hasGhostscript()
    {
        exec('gs --version', $output, $returnCode);
        return $returnCode === 0;
    }

    private function calculateWatermarkPosition($pageWidth, $pageHeight, $imgWidth, $imgHeight, $vPos, $hPos, $scale)
{
    // Hitung ukuran berdasarkan skala (persentase dari lebar halaman)
    $maxWidth = $pageWidth * ($scale / 100);
    $maxHeight = $pageHeight * ($scale / 100);

    // Hitung rasio skala untuk mempertahankan aspect ratio
    $scaleRatio = min($maxWidth / $imgWidth, $maxHeight / $imgHeight);

    $width = $imgWidth * $scaleRatio;
    $height = $imgHeight * $scaleRatio;

    // Hitung posisi berdasarkan pilihan user
    $x = match($hPos) {
        'left' => 0,
        'center' => ($pageWidth - $width) / 2,
        'right' => $pageWidth - $width,
        default => 0
    };

    $y = match($vPos) {
        'top' => 0,
        'center' => ($pageHeight - $height) / 2,
        'bottom' => $pageHeight - $height,
        default => 0
    };

    return [
        'x' => $x,
        'y' => $y,
        'width' => $width,
        'height' => $height
    ];
}
    private function generatePDFPreview($pdfPath)
    {
        try {
            // Selalu gunakan fallback preview tanpa ImageMagick
            return $this->generateFallbackPreview($pdfPath);
        } catch (\Exception $e) {
            Log::error('PDF Preview generation error: ' . $e->getMessage());
            return null;
        }
    }

    private function generateFallbackPreview($pdfPath)
    {
        try {
            $previewPath = 'temp/previews/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '.png';
            $fullPreviewPath = storage_path('app/public/' . $previewPath);

            // Create directory if not exists
            if (!file_exists(dirname($fullPreviewPath))) {
                mkdir(dirname($fullPreviewPath), 0755, true);
            }

            // Buat placeholder sederhana
            $width = 600;
            $height = 800;
            $image = imagecreatetruecolor($width, $height);

            // Warna
            $white = imagecolorallocate($image, 255, 255, 255);
            $lightGray = imagecolorallocate($image, 240, 240, 240);
            $darkGray = imagecolorallocate($image, 200, 200, 200);

            // Background
            imagefilledrectangle($image, 0, 0, $width, $height, $lightGray);

            // Border
            imagerectangle($image, 0, 0, $width - 1, $height - 1, $darkGray);

            // Text
            $text = "PDF Preview";
            $font = 5; // Built-in font
            $textWidth = imagefontwidth($font) * strlen($text);
            $textHeight = imagefontheight($font);

            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;

            imagestring($image, $font, $x, $y, $text, imagecolorallocate($image, 100, 100, 100));

            // Simpan gambar
            imagepng($image, $fullPreviewPath);
            imagedestroy($image);

            return $previewPath;
        } catch (\Exception $e) {
            Log::error('Fallback preview generation error: ' . $e->getMessage());
            return null;
        }
    }


    public function download($filename)
    {
        try {
            $path = storage_path('app/public/temp/watermarked/' . $filename);

            if (!file_exists($path)) {
                abort(404, 'File tidak ditemukan');
            }

            return response()->download($path);
        } catch (\Exception $e) {
            Log::error('Download Error: ' . $e->getMessage());
            abort(500, 'Gagal mendownload file');
        }
    }
}
