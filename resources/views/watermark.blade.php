@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Watermark PDF</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Watermark</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-file-pdf"></i> PDF Preview</h5>
                        <div class="page-info" id="pageInfo" style="display: none;">
                            <span id="currentPage">1</span> / <span id="totalPages">1</span>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="pdf-navigation" id="pdfNavigation" style="display: none;">
                            <button class="btn btn-sm btn-outline-primary" id="prevPage">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                            <button class="btn btn-sm btn-outline-primary" id="nextPage">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div id="pdfPreview" class="preview-container">
                            <div class="text-center" id="pdfPlaceholder">
                                <i class="fas fa-file-pdf fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Upload PDF untuk melihat preview</p>
                            </div>
                        </div>
                        <div id="pdfViewer"></div>
                        <div id="previewProcessing" class="processing-overlay" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 mb-0">Memproses PDF...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="settings-card mb-4">
                    <h5><i class="fas fa-upload"></i> Upload PDF</h5>
                    <div class="upload-zone" id="pdfUploadZone">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                        <p>Drag & drop PDF file atau klik untuk browse</p>
                        <input type="file" id="pdfFile" accept=".pdf" style="display: none;">
                        <div id="pdfUploadStatus"></div>
                    </div>
                    <div id="pdfInfo" class="file-info" style="display: none;"></div>
                </div>

                <div class="settings-card mb-4">
                    <h5><i class="fas fa-image"></i> Watermark</h5>
                    <div class="upload-zone" id="watermarkUploadZone">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <p>Upload gambar watermark (PNG/JPG)</p>
                        <input type="file" id="watermarkFile" accept=".png,.jpg,.jpeg" style="display: none;">
                        <div id="watermarkUploadStatus"></div>
                    </div>
                    <div id="watermarkInfo" class="file-info" style="display: none;"></div>
                </div>

                <div class="settings-card mb-4">
                    <h5><i class="fas fa-cog"></i> Settings</h5>

                    <div class="mb-3">
                        <label class="form-label">Mode Tampilan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="foreground" value="foreground"
                                checked>
                            <label class="form-check-label" for="foreground">
                                Foreground (Di Atas Konten)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="background"
                                value="background">
                            <label class="form-check-label" for="background">
                                Background (Di Belakang Konten)
                            </label>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="opacity" class="form-label">Opacity: <span id="opacityValue">0.5</span></label>
                        <input type="range" class="form-range" id="opacity" min="0.1" max="1"
                            step="0.1" value="0.5">
                    </div>

                    <div class="mb-3">
                        <label for="scale" class="form-label">Scale: <span id="scaleValue">30</span>%</label>
                        <input type="range" class="form-range" id="scale" min="1" max="100"
                            value="30">
                    </div>

                    <div class="mb-3">
                        <label for="watermarkPages" class="form-label">Halaman yang diberi watermark <small>(misal:
                                1,2,4-6)</small></label>
                        <input type="text" class="form-control" id="watermarkPages" placeholder="Contoh: 1,2,4-6"
                            autocomplete="off">
                        <div class="form-text">Pisahkan dengan koma untuk beberapa halaman, gunakan tanda minus untuk
                            rentang.</div>
                    </div>

                    <button id="applyWatermark" class="btn btn-success w-100" disabled>
                        <i class="fas fa-magic"></i> <span id="applyBtnText">Apply Watermark</span>
                    </button>
                    <div id="watermarkStatus" class="mt-2"></div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-download"></i> Download</h5>
                    <button id="downloadBtn" class="btn btn-primary w-100" disabled>
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
