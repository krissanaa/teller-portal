

<?php $__env->startSection('title', 'ແກ້ໄຂຄຳຂໍເປີດບັນຊີ'); ?>

<?php $__env->startSection('content'); ?>
<?php
$tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
?>
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
        color: #f59e0b;
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

    .form-group label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--apb-primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        outline: none;
    }

    /* Upload Section */
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

    .upload-section:hover {
        border-color: var(--apb-primary);
        background: #f0fdfa;
    }

    .upload-icon {
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

    .upload-text {
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
    }

    .upload-hint {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    /* File List */
    .file-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .file-item {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        cursor: pointer;
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    .file-item:hover {
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
        transform: translateY(-1px);
    }

    .file-preview-img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .file-details {
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }

    .file-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        word-break: break-word;
        overflow-wrap: break-word;
        line-height: 1.3;
        margin-bottom: 2px;
    }

    .file-size {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .remove-file {
        color: #ef4444;
        cursor: pointer;
        padding: 6px;
        border-radius: 4px;
        transition: all 0.2s;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .remove-file:hover {
        color: #dc2626;
        background: #fee2e2;
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
        text-decoration: none;
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
        background: #f59e0b;
        color: white;
    }

    .btn-submit:hover {
        background: #d97706;
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
    }

    /* Dark Preview Modal styles */
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

<div class="main-container">
    <div class="single-card">
        <div class="page-title">
            <i class="bi bi-pencil-square"></i>
            <span>ແກ້ໄຂຄຳຂໍເປີດບັນຊີ</span>
        </div>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-4" style="border-radius: 8px;">
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('teller.requests.update', $request->id)); ?>" method="POST" enctype="multipart/form-data" id="editForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">
                                <!-- Row 1 -->
                <div class="form-group">
                    <label>ຊື່ຮ້ານ <span class="required">*</span></label>
                    <input type="text" name="store_name" class="form-control" value="<?php echo e(old('store_name', $request->store_name)); ?>" required placeholder="ຊື່ຮ້ານຄ້າ">
                </div>

                <div class="form-group">
                    <label>ປະເພດທຸລະກິດ <span class="required">*</span></label>
                    <input type="text" name="business_type" class="form-control" value="<?php echo e(old('business_type', $request->business_type)); ?>" required placeholder="ຕົວຢ່າງ: ຮ້ານອາຫານ">
                </div>

                <div class="form-group col-span-2">
                    <label>ທີ່ຢູ່ຮ້ານຄ້າ <span class="required">*</span></label>
                    <textarea name="store_address" class="form-control" rows="2" required placeholder="ບ້ານ, ເມືອງ, ແຂວງ"><?php echo e(old('store_address', $request->store_address)); ?></textarea>
                </div>

                <!-- Row 2 -->
                <div class="form-group">
                    <label>ເລກບັນຊີທະນາຄານ</label>
                    <input type="text" name="bank_account" class="form-control" value="<?php echo e(old('bank_account', $request->bank_account)); ?>" placeholder="ເລກບັນຊີ (ຖ້າມີ)">
                </div>

                <div class="form-group">
                    <label style="margin-top:0;">CIF</label>
                    <input type="text" name="cif" class="form-control" placeholder="CIF" value="<?php echo e(old('cif', $request->cif)); ?>">
                </div>

                <div class="form-group">
                    <label>ວັນທີເອົາໄປຕິດຕັ້ງ <span class="required">*</span></label>
                    <input type="text" name="installation_date" class="form-control" value="<?php echo e(old('installation_date', $request->installation_date)); ?>" required placeholder="dd/mm/yyyy">
                </div>

                <div class="form-group">
                    <label>ຈຳນວນເຄື່ອງ POS <span class="required">*</span></label>
                    <input type="number" name="total_device_pos" class="form-control" required value="<?php echo e(old('total_device_pos', $request->total_device_pos)); ?>" placeholder="ຈຳນວນເຄື່ອງ" min="1">
                </div>


                <!-- Row 3: Existing Attachments -->
                <?php if(!empty($request->attachments)): ?>
                <div class="form-group col-span-4">
                    <label>ເອກະສານແນບທີ່ມີຢູ່</label>
                    <div class="file-preview-grid" style="margin-top: 8px;">
                        <?php $attachments = json_decode($request->attachments ?? '[]', true); ?>
                        <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $encodedPath = str_replace('%2F', '/', rawurlencode($path));
                        // Use relative URL
                        $fileUrl = '/storage-file/' . $encodedPath;
                        $fileName = basename($path);
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                        ?>
                        <div class="file-item" id="existing-file-<?php echo e($index); ?>"
                            data-preview-url="<?php echo e(route('storage.file', ['path' => $path])); ?>"
                            data-fallback-url="<?php echo e(asset('storage/' . $path)); ?>"
                            data-filename="<?php echo e($fileName); ?>"
                            data-ext="<?php echo e($extension); ?>">
                            <?php if(in_array($extension, ['jpg','jpeg','png'])): ?>
                        <img src="<?php echo e(route('storage.file', ['path' => $path])); ?>"
                                class="file-preview-img"
                                data-fallback-url="<?php echo e(asset('storage/' . $path)); ?>"
                                onerror="this.src=this.dataset.fallbackUrl; this.onerror=null;">
                        <?php elseif($extension === 'pdf'): ?>
                        <canvas data-pdf-thumb data-url="<?php echo e(route('storage.file', ['path' => $path])); ?>" data-fallback-url="<?php echo e(asset('storage/' . $path)); ?>" class="file-preview-img" style="background:#f1f5f9;"></canvas>
                        <?php else: ?>
                            <div class="file-preview-img d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-file-earmark-text" style="font-size: 1.5rem; color: #64748b;"></i>
                            </div>
                            <?php endif; ?>
                            <div class="file-details">
                                <div class="file-name" title="<?php echo e($fileName); ?>"><?php echo e($fileName); ?></div>
                                <div class="file-size"><?php echo e(strtoupper($extension)); ?></div>
                            </div>
                            <div class="remove-file" onclick="event.stopPropagation(); markFileForDeletion(<?php echo e($index); ?>, this)">
                                <i class="bi bi-trash"></i>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div id="deletedFilesContainer"></div>
                </div>
                <?php endif; ?>

                <!-- Row 4: New Uploads -->
                <div class="form-group col-span-4">
                    <label>ອັບໂຫລດເອກະສານເພີ່ມເຕີມ (PDF, JPG, PNG)</label>
                    <div class="upload-section" id="dropArea">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div>
                            <div class="upload-text">ຄລິກ ຫຼື ລາກໄຟລ໌ມາໃສ່ບ່ອນນີ້</div>
                            <div class="upload-hint">ຮອງຮັບໄຟລ໌ຮູບພາບ ແລະ PDF</div>
                        </div>
                        <input type="file" name="attachments[]" id="fileInput" multiple hidden accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div id="fileList" class="file-preview-grid"></div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content" style="border-radius: 12px; border: none;">
                        <div class="modal-body" style="padding: 24px; text-align: center;">
                            <div style="font-size: 2.5rem; color: #ef4444; margin-bottom: 12px;">
                                <i class="bi bi-trash-fill"></i>
                            </div>
                            <h6 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: 6px;">ລົບໄຟລ໌ນີ້?</h6>
                            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 20px;">ບໍ່ສາມາດຍົກເລີກໄດ້</p>
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                                    ຍົກເລີກ
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">
                                    ລົບ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo e(route('teller.requests.show', $request->id)); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> ຍົກເລີກ
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> ບັນທຶກການແກ້ໄຂ
                </button>
            </div>
        </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr
        flatpickr("input[name='installation_date']", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            defaultDate: "<?php echo e($request->installation_date); ?>",
            allowInput: true
        });

        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        let selectedFiles = [];

        dropArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', e => handleFiles(e.target.files));

        const preventDefaults = (e) => {
            e.preventDefault();
            e.stopPropagation();
        };

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => {
            dropArea.addEventListener(ev, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(ev => {
            dropArea.addEventListener(ev, () => {
                dropArea.classList.add('dragover');
                dropArea.style.borderColor = '#14b8a6';
            }, false);
        });

        ['dragleave', 'drop'].forEach(ev => {
            dropArea.addEventListener(ev, () => {
                dropArea.classList.remove('dragover');
                dropArea.style.borderColor = '#cbd5e1';
            }, false);
        });

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

                const timestamp = Date.now();
                const previewId = `preview-${index}-${timestamp}`;
                const imgId = `img-preview-${index}-${timestamp}`;
                const ext = (file.name.split('.').pop() || '').toLowerCase();
                const safeName = escapeHtml(file.name);

                let iconHtml;
                if (file.type.startsWith('image/')) {
                    iconHtml = `<img id="${imgId}" src="" class="file-preview-img" style="background:#f1f5f9;" data-name="${safeName}" data-ext="${ext || 'image'}">`;
                } else if (file.type === 'application/pdf' || ext === 'pdf') {
                    const previewUrl = URL.createObjectURL(file);
                    iconHtml = `<canvas id="${previewId}" class="file-preview-img" style="background:#f1f5f9;" data-preview-url="${previewUrl}" data-ext="pdf" data-name="${safeName}"></canvas>`;
                    renderPdfPreview(file, previewId);
                } else {
                    iconHtml = `<i class="bi bi-${getFileIcon(file.type)}"></i>`;
                }

                div.innerHTML = `
                    ${iconHtml}
                    <div class="file-details">
                        <div class="file-name" title="${safeName}">${safeName}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                    <div class="remove-file"><i class="bi bi-trash"></i></div>
                `;
                fileList.appendChild(div);

                if (file.type.startsWith('image/')) {
                    const imgEl = div.querySelector('img');
                    loadImagePreview(file, imgEl);
                }

                const removeBtn = div.querySelector('.remove-file');
                removeBtn.addEventListener('click', (evt) => {
                    evt.stopPropagation();
                    removeFile(index);
                });

                // Attach click listener to the card for previewable files
                if (file.type.startsWith('image/') || file.type === 'application/pdf' || ext === 'pdf') {
                    div.addEventListener('click', () => {
                        const previewTarget = div.querySelector('[data-preview-url]');
                        if (previewTarget) {
                            const currentUrl = previewTarget.getAttribute('data-preview-url');
                            const currentName = decodeHtml(previewTarget.getAttribute('data-name') || file.name);
                            const currentExt = previewTarget.getAttribute('data-ext') || ext;
                            openPreview(currentUrl, currentName, currentExt);
                        }
                    });
                }
            });
        }

        window.removeFile = function(index) {
            selectedFiles.splice(index, 1);
            updateFileList();
            updateFileInput();
        };

        let pendingDeleteIndex = null;
        let pendingDeleteElement = null;

        window.markFileForDeletion = function(index, btnElement) {
            pendingDeleteIndex = index;
            pendingDeleteElement = btnElement;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        };

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (pendingDeleteIndex !== null && pendingDeleteElement !== null) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_attachments[]';
                input.value = pendingDeleteIndex;
                document.getElementById('deletedFilesContainer').appendChild(input);

                const fileItem = pendingDeleteElement.closest('.file-item');
                fileItem.style.opacity = '0';
                setTimeout(() => fileItem.remove(), 300);

                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                modal.hide();

                pendingDeleteIndex = null;
                pendingDeleteElement = null;
            }
        });

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 10) / 10 + ' ' + ['B', 'KB', 'MB', 'GB'][i];
        }

        function escapeHtml(str) {
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function decodeHtml(str) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = str;
            return textarea.value;
        }

        function getFileIcon(type) {
            if (type.includes('pdf')) return 'file-pdf-fill';
            if (type.includes('word')) return 'file-word-fill';
            if (type.includes('excel') || type.includes('spreadsheet')) return 'file-excel-fill';
            if (type.startsWith('image/')) return 'file-image-fill';
            return 'file-earmark-fill';
        }

        async function renderPdfPreview(source, canvasId) {
            try {
                let loadingTask;
                let dataUrlForPreview = null;
                if (typeof source === 'string') {
                    loadingTask = pdfjsLib.getDocument({
                        url: source
                    });
                } else {
                    const arrayBuffer = await source.arrayBuffer();
                    loadingTask = pdfjsLib.getDocument({
                        data: arrayBuffer
                    });
                    dataUrlForPreview = await new Promise((resolve) => {
                        const r = new FileReader();
                        r.onload = e => resolve(e.target?.result || '');
                        r.readAsDataURL(source);
                    });
                }
                const pdf = await loadingTask.promise;
                const page = await pdf.getPage(1);
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;

                const viewport = page.getViewport({
                    scale: 1
                });
                const scale = Math.min(48 / viewport.width, 48 / viewport.height) * 2;
                const scaledViewport = page.getViewport({
                    scale: scale
                });
                const context = canvas.getContext('2d');
                canvas.height = 48;
                canvas.width = 48;
                const renderContext = {
                    canvasContext: context,
                    viewport: scaledViewport,
                    transform: [1, 0, 0, 1, (48 - scaledViewport.width) / 2, (48 - scaledViewport.height) / 2]
                };
                await page.render(renderContext).promise;
                if (dataUrlForPreview && canvas) canvas.setAttribute('data-preview-url', dataUrlForPreview);
            } catch (error) {
                console.error('Error rendering PDF preview:', error);
                const canvas = document.getElementById(canvasId);
                if (canvas) canvas.replaceWith(document.createRange().createContextualFragment('<i class="bi bi-file-pdf-fill" style="font-size:1.5rem; color:#dc3545;"></i>'));
            }
        }

        function loadImagePreview(file, target) {
            const imgEl = (typeof target === 'string') ? document.getElementById(target) : target;
            if (!imgEl) return;
            const reader = new FileReader();
            reader.onload = e => {
                const dataUrl = e.target?.result || '';
                imgEl.src = dataUrl;
                imgEl.setAttribute('data-preview-url', dataUrl);
            };
            reader.readAsDataURL(file);
        }

        let currentPdfRenderId = 0;
        window.openPreview = function(url, name = 'Attachment Preview', ext = '', fallbackUrl = '') {
            if (!url && !fallbackUrl) return;
            const modalEl = document.getElementById('previewModal');
            const img = document.getElementById('previewImage');
            const frame = document.getElementById('previewFrame');
            const pdfWrap = document.getElementById('previewPdfCanvasWrap');
            const pdfPages = document.getElementById('previewPdfPages');
            const pdfStatus = document.getElementById('previewPdfStatus');

            img.classList.add('d-none');
            frame.classList.add('d-none');
            if (pdfWrap) pdfWrap.classList.add('d-none');
            img.src = '';
            frame.src = '';
            if (pdfPages) pdfPages.innerHTML = '';

            const isPdf = (ext || '').toLowerCase().includes('pdf');
            if (isPdf) {
                renderPdfInModal(url || fallbackUrl, pdfWrap, pdfPages, pdfStatus, frame, fallbackUrl);
            } else {
                const primary = url || fallbackUrl;
                img.onload = () => img.classList.remove('d-none');
                img.onerror = () => {
                    if (fallbackUrl && img.src !== fallbackUrl) {
                        img.onerror = null;
                        img.src = fallbackUrl;
                    }
                };
                img.src = primary;
            }
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        };

        async function renderPdfInModal(url, wrap, pagesContainer, status, iframeFallback, fallbackUrl = '') {
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
                    canvas.className = 'shadow-sm bg-white rounded';
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
                if (fallbackUrl) {
                    renderPdfInModal(fallbackUrl, wrap, pagesContainer, status, iframeFallback, '');
                    return;
                }
                if (iframeFallback) {
                    iframeFallback.src = url;
                    iframeFallback.classList.remove('d-none');
                }
            } finally {
                if (status && renderId === currentPdfRenderId) status.classList.add('d-none');
            }
        }

        // Render existing PDF thumbs
        const existingPdfThumbs = document.querySelectorAll('[data-pdf-thumb]');
        existingPdfThumbs.forEach(async (canvas) => {
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
                canvas.replaceWith(document.createRange().createContextualFragment('<div class="attachment-thumb pdf"><i class="bi bi-file-pdf-fill"></i></div>'));
            }
        });

        // Add listeners to existing attachment cards
        document.querySelectorAll('.file-item[data-preview-url]').forEach((card) => {
            card.addEventListener('click', () => {
                openPreview(card.dataset.previewUrl, card.dataset.filename, card.dataset.ext || '', card.dataset.fallbackUrl || '');
            });
        });

        // Handle clicking the modal backdrop to close
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
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/requests/edit.blade.php ENDPATH**/ ?>