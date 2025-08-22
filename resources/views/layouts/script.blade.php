<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/timeline/horizontal-timeline.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    document.addEventListener('input', function() {
        const rows = document.querySelectorAll('.row.mb-3.pb-3');
        rows.forEach(row => {
            const hargaInput = row.querySelector('.harga');
            const jumlahInput = row.querySelector('.jumlah');
            const totalInput = row.querySelector('.total');

            const harga = parseInt(hargaInput?.value || 0);
            const jumlah = parseInt(jumlahInput?.value || 0);
            totalInput.value = harga * jumlah;


        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('satuan-select')) {
                const select = e.target;
                const index = select.getAttribute('data-index');
                const otherDiv = document.getElementById('other-satuan-' + index);
                const otherInput = otherDiv ? otherDiv.querySelector('input') : null;

                if (otherDiv && otherInput) {
                    if (select.value === 'Other') {
                        otherDiv.style.display = 'block';
                        otherInput.focus();

                        const itemIndex = select.name.match(/\[(\d+)\]/)[1];
                        otherInput.setAttribute('name', `items[${itemIndex}][unit]`);
                    } else {
                        otherDiv.style.display = 'none';
                        otherInput.value = '';

                        const itemIndex = select.name.match(/\[(\d+)\]/)[1];
                        otherInput.setAttribute('name', `items[${itemIndex}][other_unit]`);
                    }
                }
            }
        });

        document.querySelectorAll('.satuan-select').forEach(function(select) {
            const index = select.getAttribute('data-index');
            const otherDiv = document.getElementById('other-satuan-' + index);

            if (otherDiv) {
                if (select.value === 'Other') {
                    otherDiv.style.display = 'block';
                } else {
                    otherDiv.style.display = 'none';
                }
            }
        });

        function setupToggle(selectId, otherId) {
            const select = document.getElementById(selectId);
            const other = document.getElementById(otherId);
            if (!select || !other) return;

            function toggleInput() {
                if (select.value === 'Other') {
                    other.style.display = 'block';
                } else {
                    other.style.display = 'none';
                }
            }

            toggleInput();
            select.addEventListener('change', toggleInput);
        }

        // Panggil fungsi untuk elemen yang ada di halaman
        setupToggle('jenis-bendahara', 'other-bendahara');
    });
</script>

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
