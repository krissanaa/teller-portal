@extends('layouts.teller')

@section('title', 'ສ້າງຄຳຂໍເປີດບັນຊີໃໝ່')

@section('content')
@php
$tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    :root {
        --apb-primary: #14b8a6;
        --apb-bg: #f1f5f9;
        --apb-border: #e2e8f0;
    }

    body {
        background: var(--apb-bg);
    }

    .main-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .single-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 30px;
        border: 1px solid white;
    }

    .page-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--apb-border);
    }

    .page-title i {
        color: var(--apb-primary);
        font-size: 1.4rem;
    }

    /* Compact Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .col-span-2 {
        grid-column: span 2;
    }

    .col-span-4 {
        grid-column: span 4;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    .required {
        color: #ef4444;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .form-control:focus {
        border-color: var(--apb-primary);
        background: white;
        outline: none;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }

    /* Compact Upload Area */
    .upload-section {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .upload-section:hover,
    .upload-section.dragover {
        background: #f0fdfa;
        border-color: var(--apb-primary);
    }

    .upload-icon-box {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--apb-primary);
        font-size: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .upload-info h6 {
        margin: 0;
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
    }

    .upload-info p {
        margin: 0;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .file-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .file-item {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .file-item i {
        font-size: 1.2rem;
        color: #64748b;
    }

    .file-preview-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
    }

    .file-details {
        flex: 1;
        overflow: hidden;
    }

    .file-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .remove-file {
        color: #ef4444;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
        font-size: 1.1rem;
    }

    .remove-file i {
        color: #ef4444;
    }

    .remove-file:hover {
        color: #dc2626;
        background: #fee2e2;
    }

    .remove-file:hover i {
        color: #dc2626;
    }

    /* Actions */
    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--apb-border);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .btn-cancel {
        background: white;
        border: 1px solid #cbd5e1;
        color: #64748b;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .btn-submit {
        background: var(--apb-primary);
        color: white;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(20, 184, 166, 0.3);
    }

    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .col-span-2,
        .col-span-4 {
            grid-column: span 2;
        }
    }

    @media (max-width: 576px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .col-span-2,
        .col-span-4 {
            grid-column: span 1;
        }

        .upload-section {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="main-container">
    <form method="POST" action="{{ route('teller.requests.store') }}" enctype="multipart/form-data" class="single-card" id="mainForm">
        @csrf

        <div class="page-title">
            <i class="bi bi-file-earmark-plus-fill"></i>
            <span>ສ້າງຄຳຂໍເປີດບັນຊີໃໝ່</span>
        </div>

        <div class="form-grid">




            <!-- Row 1 -->
            <div class="form-group">
                <label>ຊື່ຮ້ານຄ້າ <span class="required">*</span></label>
                <input type="text" name="store_name" class="form-control" required placeholder="ປ້ອນຊື່ຮ້ານຄ້າ" value="{{ old('store_name') }}">
            </div>

            <div class="form-group">
                <label>ປະເພດທຸລະກິດ <span class="required">*</span></label>
                <input type="text" name="business_type" class="form-control" required placeholder="ເຊັ່ນ: ຮ້ານອາຫານ" value="{{ old('business_type') }}">
            </div>

            <div class="form-group">
                <label>ເລກບັນຊີທະນາຄານ</label>
                <input type="text" name="bank_account" class="form-control" placeholder="ປ້ອນເລກບັນຊີ (ຖ້າມີ)" value="{{ old('bank_account') }}">
                <label style="margin-top:8px;">CIF</label>
                <input type="text" name="cif" class="form-control" placeholder="CIF" value="{{ old('cif') }}">
            </div>

            <div class="form-group">
                <label>ວັນທີໄປຕິດຕັ້ງ <span class="required">*</span></label>
                <input type="text" name="installation_date" class="form-control" required value="{{ old('installation_date', date('Y-m-d')) }}" placeholder="dd/mm/yyyy">
                <label style="margin-top:8px;">ຈຳນວນເຄື່ອງ POS <span class="required">*</span></label>
                <input type="number" name="total_device_pos" class="form-control" required value="{{ old('total_device_pos') }}" placeholder="ລະບຸຈຳນວນເຄື່ອງ" min="1">
            </div>

            <!-- Row 2 -->
            <div class="form-group col-span-4">
                <label>ທີ່ຢູ່ຮ້ານຄ້າ <span class="required">*</span></label>
                <textarea name="store_address" class="form-control" rows="2" required placeholder="ປ້ອນທີ່ຢູ່ຮ້ານຄ້າແບບລະອຽດ">{{ old('store_address') }}</textarea>
            </div>

            <!-- Row 3: Compact Upload -->
            <div class="form-group col-span-4">
                <label>ເອກະສານແນບ</label>
                <div class="upload-section" id="dropArea">
                    <input type="file" name="attachments[]" id="fileInput" class="d-none" accept=".pdf,.jpg,.jpeg,.png" multiple>
                    <div class="upload-icon-box">
                        <i class="bi bi-cloud-upload"></i>
                    </div>
                    <div class="upload-info">
                        <h6>ຄລິກ ຫຼື ລາກໄຟລ໌ມາວາງທີ່ນີ້</h6>
                        <p>ຮອງຮັບ PDF, JPG, PNG </p>
                    </div>
                </div>
                <div class="file-preview-grid" id="fileList"></div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg"></i> ຍົກເລີກ
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send-fill"></i> ສົ່ງຄຳຂໍ
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr
        flatpickr("input[name='installation_date']", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            defaultDate: "today",
            allowInput: true
        });

        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        let selectedFiles = [];

        dropArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', e => handleFiles(e.target.files));

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => {
            dropArea.addEventListener(ev, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });
        ['dragenter', 'dragover'].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.add('dragover')));
        ['dragleave', 'drop'].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.remove('dragover')));
        dropArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));

        function handleFiles(files) {
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 5 * 1024 * 1024;
            [...files].forEach(file => {
                if (!validTypes.includes(file.type)) return alert(`ໄຟລ໌ ${file.name} ບໍ່ຖືກຕ້ອງ.`);
                if (file.size > maxSize) return alert(`ໄຟລ໌ ${file.name} ໃຫຍ່ເກີນ 5MB.`);
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });
            updateFileList();
            updateFileInput();
        }

        function updateFileList() {
            fileList.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'file-item';

                // Unique ID for the preview container
                const previewId = `preview-${index}`;

                let iconHtml;
                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    iconHtml = `<img src="${url}" class="file-preview-img" onload="URL.revokeObjectURL(this.src)">`;
                } else if (file.type === 'application/pdf') {
                    // Placeholder canvas for PDF
                    iconHtml = `<canvas id="${previewId}" class="file-preview-img" style="background:#f1f5f9;"></canvas>`;
                    // Trigger async render
                    renderPdfPreview(file, previewId);
                } else {
                    iconHtml = `<i class="bi bi-${getFileIcon(file.type)}"></i>`;
                }

                div.innerHTML = `
                ${iconHtml}
                <div class="file-details">
                    <div class="file-name" title="${file.name}">${file.name}</div>
                    <div class="file-size">${formatFileSize(file.size)}</div>
                </div>
                <div class="remove-file" onclick="removeFile(${index})"><i class="bi bi-trash"></i></div>
            `;
                fileList.appendChild(div);
            });
        }

        async function renderPdfPreview(file, canvasId) {
            try {
                const arrayBuffer = await file.arrayBuffer();
                const pdf = await pdfjsLib.getDocument(arrayBuffer).promise;
                const page = await pdf.getPage(1);

                const canvas = document.getElementById(canvasId);
                if (!canvas) return;

                const viewport = page.getViewport({
                    scale: 1
                });
                // Scale to fit 40x40 thumbnail while maintaining aspect ratio
                const scale = Math.min(40 / viewport.width, 40 / viewport.height) * 2; // *2 for better resolution
                const scaledViewport = page.getViewport({
                    scale: scale
                });

                const context = canvas.getContext('2d');
                canvas.height = 40;
                canvas.width = 40;

                // Center the page in the square canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: scaledViewport,
                    transform: [1, 0, 0, 1, (40 - scaledViewport.width) / 2, (40 - scaledViewport.height) / 2]
                };

                await page.render(renderContext).promise;
            } catch (error) {
                console.error('Error rendering PDF preview:', error);
                const canvas = document.getElementById(canvasId);
                if (canvas) {
                    canvas.replaceWith(document.createRange().createContextualFragment('<i class="bi bi-file-pdf-fill" style="font-size:1.2rem; color:#dc3545;"></i>'));
                }
            }
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }

        window.removeFile = function(index) {
            selectedFiles.splice(index, 1);
            updateFileList();
            updateFileInput();
        };

        function getFileIcon(type) {
            if (type === 'application/pdf') return 'file-pdf-fill';
            if (type.startsWith('image/')) return 'file-image-fill';
            return 'file-earmark-fill';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 10) / 10 + ' ' + ['B', 'KB', 'MB'][i];
        }
    });
</script>
@endsection