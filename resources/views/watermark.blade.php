<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Watermark Editor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .preview-container {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            
            min-height: 100px;
            /* Diperkecil */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            overflow: auto;
            /* Tambahkan scroll jika perlu */
        }

        .preview-container.has-content {
            border-color: #007bff;
            background-color: #fff;
            padding: 0;
        }

        .preview-image {
            max-width: 100%;
            max-height: 500px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .upload-zone {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-zone:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .upload-zone.dragover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }

        .upload-zone.loading {
            border-color: #007bff;
            background-color: #f8f9fa;
            pointer-events: none;
        }

        .settings-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .file-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .loading-text {
            color: #007bff;
            font-size: 14px;
            margin-top: 10px;
        }

        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }

        .success-text {
            color: #28a745;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .processing-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            z-index: 10;
        }

        /* PDF Viewer Styles */
        #pdfViewer {
            width: 100%;
            max-height: 80vh;
            overflow: auto;
            background-color: #f0f0f0;
            display: none;
        }

        #pdfViewer canvas {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Navigation Controls */
        .pdf-navigation {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .page-info {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
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
                                <input class="form-check-input" type="radio" name="mode" id="foreground"
                                    value="foreground" checked>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // Set the worker path
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

        // Setup CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Global variables
        let currentPdfPath = null;
        let currentWatermarkPath = null;
        let currentWatermarkedPath = null;
        let isProcessing = false;
        let currentPdf = null;
        let currentPage = 1;
        let totalPages = 1;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        function setupEventListeners() {
            // PDF Upload
            const pdfUploadZone = document.getElementById('pdfUploadZone');
            const pdfFile = document.getElementById('pdfFile');

            pdfUploadZone.addEventListener('click', () => {
                if (!isProcessing) pdfFile.click();
            });
            pdfUploadZone.addEventListener('dragover', handleDragOver);
            pdfUploadZone.addEventListener('drop', handlePdfDrop);
            pdfFile.addEventListener('change', handlePdfUpload);

            // Watermark Upload
            const watermarkUploadZone = document.getElementById('watermarkUploadZone');
            const watermarkFile = document.getElementById('watermarkFile');

            watermarkUploadZone.addEventListener('click', () => {
                if (!isProcessing) watermarkFile.click();
            });
            watermarkUploadZone.addEventListener('dragover', handleDragOver);
            watermarkUploadZone.addEventListener('drop', handleWatermarkDrop);
            watermarkFile.addEventListener('change', handleWatermarkUpload);

            // Settings
            document.getElementById('opacity').addEventListener('input', updateOpacityValue);
            document.getElementById('scale').addEventListener('input', updateScaleValue);
            document.getElementById('applyWatermark').addEventListener('click', applyWatermark);
            document.getElementById('downloadBtn').addEventListener('click', downloadPDF);

            // Navigation buttons
            document.getElementById('prevPage').addEventListener('click', goToPrevPage);
            document.getElementById('nextPage').addEventListener('click', goToNextPage);

            // Auto-apply watermark when settings change
            document.querySelectorAll('input[name="mode"], #opacity, #scale').forEach(input => {
                input.addEventListener('change', autoApplyWatermark);
            });
        }   

        function handleDragOver(e) {
            e.preventDefault();
            if (!isProcessing) {
                e.currentTarget.classList.add('dragover');
            }
        }

        function handlePdfDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
            if (!isProcessing) {
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type === 'application/pdf') {
                    handlePdfFile(files[0]);
                }
            }
        }

        function handleWatermarkDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
            if (!isProcessing) {
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    handleWatermarkFile(files[0]);
                }
            }
        }

        function handlePdfUpload(e) {
            const file = e.target.files[0];
            if (file && !isProcessing) {
                handlePdfFile(file);
            }
        }

        function handleWatermarkUpload(e) {
            const file = e.target.files[0];
            if (file && !isProcessing) {
                handleWatermarkFile(file);
            }
        }

        function showUploadStatus(elementId, message, type = 'info') {
            const statusElement = document.getElementById(elementId);
            let className = 'loading-text';
            let icon = '<i class="fas fa-spinner fa-spin"></i>';

            if (type === 'success') {
                className = 'success-text';
                icon = '<i class="fas fa-check"></i>';
            } else if (type === 'error') {
                className = 'error-text';
                icon = '<i class="fas fa-exclamation-triangle"></i>';
            }

            statusElement.innerHTML = `<div class="${className}">${icon} ${message}</div>`;
        }

        function handlePdfFile(file) {
            const formData = new FormData();
            formData.append('pdf_file', file);

            isProcessing = true;
            document.getElementById('pdfUploadZone').classList.add('loading');
            showUploadStatus('pdfUploadStatus', 'Mengupload PDF...', 'info');

            fetch('/upload-pdf', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentPdfPath = data.pdf_path;
                        updatePdfPreview(data.preview_path);
                        updatePdfInfo(file.name, file.size);
                        showUploadStatus('pdfUploadStatus', 'PDF berhasil diupload!', 'success');
                        checkCanApplyWatermark();
                    } else {
                        showUploadStatus('pdfUploadStatus', 'Error: ' + (data.message || 'Gagal upload PDF'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUploadStatus('pdfUploadStatus', 'Error: ' + error.message, 'error');
                })
                .finally(() => {
                    isProcessing = false;
                    document.getElementById('pdfUploadZone').classList.remove('loading');
                });
        }

        function handleWatermarkFile(file) {
            const formData = new FormData();
            formData.append('watermark_file', file);

            isProcessing = true;
            document.getElementById('watermarkUploadZone').classList.add('loading');
            showUploadStatus('watermarkUploadStatus', 'Mengupload watermark...', 'info');

            fetch('/upload-watermark', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentWatermarkPath = data.watermark_path;
                        updateWatermarkInfo(file.name, file.size);
                        showUploadStatus('watermarkUploadStatus', 'Watermark berhasil diupload!', 'success');
                        checkCanApplyWatermark();
                        autoApplyWatermark();
                    } else {
                        showUploadStatus('watermarkUploadStatus', 'Error: ' + (data.message ||
                            'Gagal upload watermark'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUploadStatus('watermarkUploadStatus', 'Error: ' + error.message, 'error');
                })
                .finally(() => {
                    isProcessing = false;
                    document.getElementById('watermarkUploadZone').classList.remove('loading');
                });
        }

        function updatePdfPreview(pdfPath) {
            const preview = document.getElementById('pdfPreview');
            const pdfViewer = document.getElementById('pdfViewer');
            const pdfPlaceholder = document.getElementById('pdfPlaceholder');
            const previewProcessing = document.getElementById('previewProcessing');
            const pdfNavigation = document.getElementById('pdfNavigation');
            const pageInfo = document.getElementById('pageInfo');

            // Reset state
            currentPdf = null;
            currentPage = 1;
            totalPages = 1;

            // Tampilkan loading
            previewProcessing.style.display = 'flex';

            // Sembunyikan placeholder
            pdfPlaceholder.style.display = 'none';

            // Kosongkan viewer sebelumnya
            pdfViewer.innerHTML = '';
            pdfViewer.style.display = 'block';

            // Sembunyikan navigasi sementara
            pdfNavigation.style.display = 'none';
            pageInfo.style.display = 'none';

            // Load PDF menggunakan PDF.js
            const loadingTask = pdfjsLib.getDocument(`/storage/${pdfPath}`);

            loadingTask.promise.then(function(pdf) {
                // Simpan objek PDF
                currentPdf = pdf;
                totalPages = pdf.numPages;

                // Update info halaman
                document.getElementById('currentPage').textContent = currentPage;
                document.getElementById('totalPages').textContent = totalPages;

                // Tampilkan navigasi jika lebih dari 1 halaman
                if (totalPages > 1) {
                    pdfNavigation.style.display = 'flex';
                    pageInfo.style.display = 'flex';
                }

                // Render halaman pertama
                return renderPage(1);
            }).then(function() {
                preview.classList.add('has-content');
            }).catch(function(error) {
                console.error('PDF preview error:', error);
                // Jika gagal, tampilkan placeholder
                pdfViewer.style.display = 'none';
                pdfPlaceholder.style.display = 'block';
                pdfPlaceholder.innerHTML = `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                        <p class="text-warning">Gagal memuat preview PDF</p>
                        <small class="text-muted">${error.message}</small>
                        <button class="btn btn-sm btn-primary mt-2" onclick="updatePdfPreview('${pdfPath}')">
                            <i class="fas fa-redo"></i> Coba Lagi
                        </button>
                    </div>
                `;
            }).finally(function() {
                // Sembunyikan loading
                previewProcessing.style.display = 'none';
            });
        }

        function renderPage(pageNum) {
            if (!currentPdf) return Promise.reject('PDF not loaded');

            return currentPdf.getPage(pageNum).then(function(page) {
                const pdfViewer = document.getElementById('pdfViewer');
                const scale = 1.5; // Skala tetap
                const viewport = page.getViewport({
                    scale: scale
                });

                // Siapkan canvas
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Kosongkan viewer
                pdfViewer.innerHTML = '';

                // Render halaman PDF ke canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                return page.render(renderContext).promise.then(function() {
                    // Tambahkan canvas ke viewer
                    pdfViewer.appendChild(canvas);

                    // Update info halaman
                    document.getElementById('currentPage').textContent = pageNum;
                    currentPage = pageNum;

                    // Update status tombol navigasi
                    document.getElementById('prevPage').disabled = (pageNum <= 1);
                    document.getElementById('nextPage').disabled = (pageNum >= totalPages);

                    // SESUAIKAN UKURAN CONTAINER
                    pdfViewer.style.height = viewport.height + 'px';
                });
            });
        }

        function goToPrevPage() {
            if (currentPage > 1) {
                renderPage(currentPage - 1);
            }
        }

        function goToNextPage() {
            if (currentPage < totalPages) {
                renderPage(currentPage + 1);
            }
        }

        function updatePdfInfo(filename, size) {
            const info = document.getElementById('pdfInfo');
            info.innerHTML = `
                <strong>File:</strong> ${filename}<br>
                <strong>Size:</strong> ${formatFileSize(size)}
            `;
            info.style.display = 'block';
        }

        function updateWatermarkInfo(filename, size) {
            const info = document.getElementById('watermarkInfo');
            info.innerHTML = `
                <strong>File:</strong> ${filename}<br>
                <strong>Size:</strong> ${formatFileSize(size)}
            `;
            info.style.display = 'block';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function updateOpacityValue() {
            const opacity = document.getElementById('opacity');
            document.getElementById('opacityValue').textContent = opacity.value;
        }

        function updateScaleValue() {
            const scale = document.getElementById('scale');
            document.getElementById('scaleValue').textContent = scale.value;
        }

        function checkCanApplyWatermark() {
            const applyBtn = document.getElementById('applyWatermark');
            applyBtn.disabled = !(currentPdfPath && currentWatermarkPath) || isProcessing;
        }

        function autoApplyWatermark() {
            if (currentPdfPath && currentWatermarkPath && !isProcessing) {
                setTimeout(() => {
                    applyWatermark();
                }, 500);
            }
        }

        function applyWatermark() {
            if (!currentPdfPath || !currentWatermarkPath || isProcessing) return;

            const formData = new FormData();
            const opacity = document.getElementById('opacity').value;
            const scale = document.getElementById('scale').value;

            formData.append('pdf_path', currentPdfPath);
            formData.append('watermark_path', currentWatermarkPath);
            formData.append('opacity', opacity);
            formData.append('scale', scale);
            formData.append('as_background', document.querySelector('input[name="mode"]:checked').value === 'background');

            const pagesValue = document.getElementById('watermarkPages') ? document.getElementById('watermarkPages').value
                .trim() : '';
            if (pagesValue) {
                formData.append('pages', pagesValue);
            }

            isProcessing = true;
            document.getElementById('previewProcessing').style.display = 'flex';
            document.getElementById('applyBtnText').textContent = 'Memproses...';
            document.getElementById('applyWatermark').disabled = true;

            showUploadStatus('watermarkStatus', 'Menerapkan watermark...', 'info');

            fetch('/apply-watermark', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentWatermarkedPath = data.watermarked_pdf;
                        updatePdfPreview(data.preview_path);
                        document.getElementById('downloadBtn').disabled = false;
                        showUploadStatus('watermarkStatus', 'Watermark berhasil diterapkan!', 'success');
                    } else {
                        showUploadStatus('watermarkStatus', 'Error: ' + (data.error || 'Gagal menerapkan watermark'),
                            'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUploadStatus('watermarkStatus', 'Error: ' + error.message, 'error');
                })
                .finally(() => {
                    isProcessing = false;
                    document.getElementById('previewProcessing').style.display = 'none';
                    document.getElementById('applyBtnText').textContent = 'Apply Watermark';
                    checkCanApplyWatermark();
                });
        }

        function downloadPDF() {
            if (currentWatermarkedPath) {
                const filename = currentWatermarkedPath.split('/').pop();
                window.location.href = `/download/${filename}`;
            }
        }

        function showSimplePreview() {
            const preview = document.getElementById('pdfPreview');
            const pdfViewer = document.getElementById('pdfViewer');
            const pdfPlaceholder = document.getElementById('pdfPlaceholder');
            const pdfNavigation = document.getElementById('pdfNavigation');

            pdfViewer.style.display = 'none';
            pdfNavigation.style.display = 'none';
            pdfPlaceholder.style.display = 'block';
            pdfPlaceholder.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-file-pdf fa-4x text-primary mb-3"></i>
                    <p class="text-primary">PDF Berhasil Diproses</p>
                    <small class="text-muted">Preview tidak tersedia</small>
                </div>
            `;
        }
    </script>
</body>

</html>
=======
>>>>>>> 4bb1752ea88d59b452969d8f21b486585e5655e8
