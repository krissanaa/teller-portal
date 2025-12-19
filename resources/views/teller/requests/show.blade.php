@extends('layouts.teller')

@section('title', 'ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ')

@section('content')
@php
$tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
@endphp
<style>
    .att-card {
        width: 210px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        background: #fff;
    }

    .att-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .att-preview {
        width: 100%;
        height: 130px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .att-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .att-preview canvas {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .att-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .att-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
    }

    .att-ext {
        background: #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 999px;
        font-weight: 700;
    }

    /* Dark Preview Modal styles (match admin) */
    .modal-preview-dark .modal-content {
        background-color: transparent;
        box-shadow: none;
        border: none;
        height: 100vh;
        pointer-events: none;
    }

    .modal-preview-dark .modal-body {
        background-color: transparent;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        height: 100%;
        pointer-events: auto;
        cursor: pointer;
    }

    .modal-preview-dark .preview-container {
        cursor: default;
        background: #1e293b;
        border-radius: 12px;
        padding: 2px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        display: inline-block;
        position: relative;
        max-width: 100%;
        max-height: 90vh;
    }

    .modal-preview-dark .modal-header {
        position: fixed;
        top: 20px;
        right: 20px;
        left: auto;
        width: auto;
        border: none;
        background: transparent;
        padding: 0;
        z-index: 1056;
    }

    .modal-preview-dark .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.8;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        padding: 10px;
        background-size: 10px;
    }

    .modal-preview-dark .btn-close:hover {
        opacity: 1;
        background-color: rgba(0, 0, 0, 0.8);
    }
</style>
<div class="container-fluid">
    <h4 class="mb-3">ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                @if(auth()->user()->isBranchAdmin() || auth()->user()->isAdmin())
                <h5 class="mb-0 text-primary">
                    <i class="bi bi-person-badge me-1"></i>
                    {{ $request->teller->teller_id ?? $request->teller_id }} - {{ $request->teller->name ?? 'Unknown' }}
                </h5>

                @else

                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>ຊື່ຮ້ານ:</strong> {{ $request->store_name }}</p>
                    <p><strong>ປະເພດທຸລະກິດ:</strong> {{ $request->business_type }}</p>
                    <p><strong>ເລກບັນຊີທະນາຄານ:</strong> {{ $request->bank_account ?? '-' }}</p>
                    <p><strong>ວັນທີຕິດຕັ້ງ:</strong> {{ \Carbon\Carbon::parse($request->installation_date)->format('d/m/Y') }}</p>
                    <p><strong>ສະຖານະ:</strong>
                        @if($request->approval_status == 'approved')
                        <span class="badge bg-success">ອະນຸມັດແລ້ວ</span>
                        @elseif($request->approval_status == 'pending')
                        <span class="badge bg-warning text-dark">ລໍຖ້າອະນຸມັດ</span>
                        @else
                        <span class="badge bg-danger">ປະຕິເສດ</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>ທີ່ຢູ່ຮ້ານ:</strong> {{ $request->store_address }}</p>
                    <p><strong>ລະຫັດຜູ້ແນະນຳ:</strong> {{ $request->refer_code }}</p>
                    <p><strong>ເລກຊີຣີ POS:</strong> {{ $request->pos_serial ?? '-' }}</p>
                    <p><strong>ວັນທີສ້າງ:</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            @if(!empty($request->attachments))
            <hr>
            <h6 class="fw-bold mb-3">ເອກະສານແນບ</h6>
            <div class="d-flex flex-wrap gap-3">
                @php $attachments = json_decode($request->attachments ?? '[]', true); @endphp
                @foreach($attachments as $filePath)
                @php
                $encodedPath = str_replace('%2F', '/', rawurlencode($filePath));
                // Use relative URL to avoid port mismatch issues (e.g. 8081 vs 80)
                $fileUrl = '/storage-file/' . $encodedPath;
                $fileName = basename($filePath);
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                @endphp
                @php $publicUrl = asset('storage/' . ltrim($filePath, '/')); @endphp
                <div class="att-card" onclick="openPreview('{{ route('storage.file', ['path' => $filePath]) }}', '{{ $fileName }}', '{{ $extension }}', '{{ asset('storage/' . $filePath) }}')">
                    <div class="att-preview">
                        @if(in_array($extension, ['jpg','jpeg','png']))
                        <img src="{{ route('storage.file', ['path' => $filePath]) }}"
                            class="rounded"
                            data-fallback-url="{{ asset('storage/' . $filePath) }}"
                            alt="{{ $fileName }}"
                            onerror="this.src=this.dataset.fallbackUrl; this.onerror=null;">
                        @elseif($extension === 'pdf')
                        <canvas class="rounded" data-pdf-thumb data-url="{{ route('storage.file', ['path' => $filePath]) }}" style="background:#f8fafc;"></canvas>
                        @else
                        <i class="bi bi-file-earmark text-secondary fs-1"></i>
                        @endif
                    </div>
                    <div class="att-name" title="{{ $fileName }}">{{ $fileName }}</div>
                    <div class="att-meta">
                        <span class="text-muted small">Preview</span>
                        <span class="att-ext">{{ strtoupper($extension) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($request->admin_remark)
            <div class="alert alert-danger mt-3">
                <strong>ໝາຍເຫດຈາກຜູ້ດູແລ:</strong> {{ $request->admin_remark }}
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('teller.requests.edit', $request->id) }}" class="btn btn-warning">ແກ້ໄຂຄຳຂໍ</a>
        <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">ກັບຄືນໜ້າຫຼັກ</a>
    </div>
</div>

<!-- Dark Preview Modal -->
<div class="modal fade modal-preview-dark" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="preview-container" style="min-width: 300px; min-height: 200px;">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid d-none rounded" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                    <div id="previewPdfCanvasWrap" class="d-none rounded bg-white" style="width: 100%; height: 80vh; overflow: auto;">
                        <div id="previewPdfStatus" class="sticky-top bg-warning text-dark small py-1 shadow-sm">Loading PDF...</div>
                        <div id="previewPdfPages" class="d-flex flex-column align-items-center gap-3 p-3 bg-dark"></div>
                    </div>
                    <iframe id="previewFrame" src="" class="w-100 d-none rounded bg-white" style="height: 80vh; border: 0;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Render existing PDF thumbs
        const pdfThumbs = document.querySelectorAll('[data-pdf-thumb]');
        pdfThumbs.forEach(async (canvas) => {
            const url = canvas.dataset.url;
            if (!url) return;
            try {
                const pdf = await pdfjsLib.getDocument(url).promise;
                const page = await pdf.getPage(1);
                const viewport = page.getViewport({
                    scale: 1
                });
                const maxSize = 48;
                const scale = Math.min(maxSize / viewport.width, maxSize / viewport.height) * 2;
                const scaledViewport = page.getViewport({
                    scale: scale
                });
                const ctx = canvas.getContext('2d');
                canvas.width = maxSize;
                canvas.height = maxSize;
                const renderContext = {
                    canvasContext: ctx,
                    viewport: scaledViewport,
                    transform: [1, 0, 0, 1, (maxSize - scaledViewport.width) / 2, (maxSize - scaledViewport.height) / 2]
                };
                await page.render(renderContext).promise;
            } catch (e) {
                canvas.replaceWith(document.createRange().createContextualFragment('<div class="d-flex align-items-center justify-content-center attachment-thumb pdf"><i class="bi bi-file-pdf text-danger fs-2"></i></div>'));
            }
        });

        // Close modal on backdrop click
        const previewModal = document.getElementById('previewModal');
        if (previewModal) {
            previewModal.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-body') || e.target.classList.contains('modal-content')) {
                    const instance = bootstrap.Modal.getInstance(previewModal);
                    if (instance) instance.hide();
                }
            });
        }
    });

    window.openPreview = function(fileUrl, fileName, extension, fallbackUrl = '') {
        const modalEl = document.getElementById('previewModal');
        const img = document.getElementById('previewImage');
        const frame = document.getElementById('previewFrame');
        const wrap = document.getElementById('previewPdfCanvasWrap');
        const pagesContainer = document.getElementById('previewPdfPages');
        const status = document.getElementById('previewPdfStatus');


        // Reset state
        img.classList.add('d-none');
        frame.classList.add('d-none');
        if (wrap) wrap.classList.add('d-none');
        img.src = '';
        frame.src = '';
        if (pagesContainer) pagesContainer.innerHTML = '';

        const ext = (extension || '').toLowerCase();
        if (ext === 'pdf') {
            const primary = fileUrl || fallbackUrl;
            renderPdfInModal(primary, wrap, pagesContainer, status, frame);
        } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
            const primary = fileUrl || fallbackUrl;
            img.onerror = () => {
                if (fallbackUrl && img.src !== fallbackUrl) {
                    img.onerror = null;
                    img.src = fallbackUrl;
                }
            };
            img.src = primary;
            img.classList.remove('d-none');
        } else {
            frame.src = fileUrl || fallbackUrl;
            frame.classList.remove('d-none');
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    };

    let currentPdfRenderId = 0;
    async function renderPdfInModal(url, wrap, pagesContainer, status, iframeFallback) {
        const renderId = ++currentPdfRenderId;
        if (!wrap || !pagesContainer) {
            if (iframeFallback) {
                iframeFallback.src = url;
                iframeFallback.classList.remove('d-none');
            }
            return;
        }

        wrap.classList.remove('d-none');
        pagesContainer.innerHTML = '';
        if (status) {
            status.textContent = 'Loading PDF...';
            status.classList.remove('d-none');
        }

        try {
            const loadingTask = pdfjsLib.getDocument({
                url,
                withCredentials: false
            });
            const pdf = await loadingTask.promise;
            if (renderId !== currentPdfRenderId) return;

            if (status) status.textContent = `Rendering ${pdf.numPages} page(s)...`;

            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                if (renderId !== currentPdfRenderId) return;
                const page = await pdf.getPage(pageNum);
                const viewport = page.getViewport({
                    scale: 1.5
                });
                const canvas = document.createElement('canvas');
                canvas.className = 'shadow-sm bg-white rounded mb-3';
                canvas.style.maxWidth = '100%';
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                pagesContainer.appendChild(canvas);
                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;
            }
            if (status && renderId === currentPdfRenderId) status.classList.add('d-none');
        } catch (err) {
            if (renderId !== currentPdfRenderId) return;
            console.error('PDF preview failed, falling back to iframe:', err);
            wrap.classList.add('d-none');
            if (iframeFallback) {
                iframeFallback.src = url;
                iframeFallback.classList.remove('d-none');
            }
        } finally {
            if (status && renderId === currentPdfRenderId) status.classList.add('d-none');
        }
    }
</script>
@endsection