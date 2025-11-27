

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
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--apb-primary);
        font-size: 1.2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .upload-text {
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
    }

    .upload-hint {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* File List */
    .file-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
                    <label>ຊື່ຮ້ານຄ້າ <span class="required">*</span></label>
                    <input type="text" name="store_name" class="form-control" value="<?php echo e(old('store_name', $request->store_name)); ?>" required placeholder="ໃສ່ຊື່ຮ້ານຄ້າ...">
                </div>

                <div class="form-group">
                    <label>ປະເພດທຸລະກິດ <span class="required">*</span></label>
                    <input type="text" name="business_type" class="form-control" value="<?php echo e(old('business_type', $request->business_type)); ?>" required placeholder="ປະເພດທຸລະກິດ...">
                </div>

                <div class="form-group">
                    <label>ເລກບັນຊີທະນາຄານ</label>
                    <input type="text" name="bank_account" class="form-control" value="<?php echo e(old('bank_account', $request->bank_account)); ?>" placeholder="ເລກບັນຊີ...">
                </div>

                <div class="form-group">
                    <label>ວັນທີຕິດຕັ້ງ <span class="required">*</span></label>
                    <input type="text" name="installation_date" class="form-control" value="<?php echo e(old('installation_date', $request->installation_date)); ?>" required placeholder="dd/mm/yyyy">
                </div>

                <!-- Row 2 -->
                <div class="form-group col-span-2">
                    <label>ທີ່ຢູ່ຮ້ານຄ້າ <span class="required">*</span></label>
                    <textarea name="store_address" class="form-control" rows="1" style="min-height: 42px; height: 42px;" required placeholder="ບ້ານ, ເມືອງ, ແຂວງ..."><?php echo e(old('store_address', $request->store_address)); ?></textarea>
                </div>

                <div class="form-group">
                    <label>ລະຫັດອ້າງອີງ</label>
                    <input type="text" name="refer_code" class="form-control" value="<?php echo e(old('refer_code', $request->refer_code)); ?>" placeholder="ລະຫັດ...">
                </div>

                <div class="form-group">
                    <label>ລະຫັດເຄື່ອງ POS</label>
                    <input type="text" name="pos_serial" class="form-control" value="<?php echo e(old('pos_serial', $request->pos_serial)); ?>" placeholder="S/N...">
                </div>

                <!-- Row 3: Existing Attachments -->
                <?php if(!empty($request->attachments)): ?>
                <div class="form-group col-span-4">
                    <label>ເອກະສານແນບທີ່ມີຢູ່</label>
                    <div class="file-list" style="margin-top: 8px;">
                        <?php $attachments = json_decode($request->attachments ?? '[]', true); ?>
                        <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $fileUrl = asset('storage/' . $filePath);
                        $fileName = basename($filePath);
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        ?>
                        <div class="file-item" id="existing-file-<?php echo e($index); ?>">
                            <?php if(in_array($extension, ['jpg','jpeg','png'])): ?>
                            <img src="<?php echo e($fileUrl); ?>" class="file-preview-img">
                            <?php elseif($extension === 'pdf'): ?>
                            <i class="bi bi-file-pdf-fill" style="color: #ef4444; font-size: 1.5rem;"></i>
                            <?php else: ?>
                            <i class="bi bi-file-earmark-text" style="font-size: 1.5rem; color: #64748b;"></i>
                            <?php endif; ?>
                            <div class="file-details">
                                <div class="file-name" title="<?php echo e($fileName); ?>"><?php echo e($fileName); ?></div>
                                <div class="file-size"><?php echo e(strtoupper($extension)); ?></div>
                            </div>
                            <div class="remove-file" onclick="markFileForDeletion(<?php echo e($index); ?>, this)">
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
                    <div id="fileList" class="file-list"></div>
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
                                <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="background: #f1f5f9; color: #64748b; padding: 8px 16px; border-radius: 6px; font-weight: 600; border: none;">
                                    ຍົກເລີກ
                                </button>
                                <button type="button" class="btn btn-sm" id="confirmDeleteBtn" style="background: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; border: none;">
                                    ລົບ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo e(route('teller.requests.show', $request->id)); ?>" class="btn btn-cancel">
                    <i class="bi bi-x-lg"></i> ຍົກເລີກ
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-lg"></i> ບັນທຶກການແກ້ໄຂ
                </button>
            </div>
        </form>
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
        fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.style.borderColor = '#14b8a6', false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.style.borderColor = '#cbd5e1', false);
        });

        dropArea.addEventListener('drop', (e) => handleFiles(e.dataTransfer.files));

        function handleFiles(files) {
            const newFiles = [...files];
            selectedFiles = [...selectedFiles, ...newFiles];
            updateFileInput();
            updateFileList();
        }

        function updateFileList() {
            fileList.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'file-item';
                const previewId = `preview-${index}`;

                let iconHtml;
                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    iconHtml = `<img src="${url}" class="file-preview-img" onload="URL.revokeObjectURL(this.src)">`;
                } else if (file.type === 'application/pdf') {
                    iconHtml = `<canvas id="${previewId}" class="file-preview-img" style="background:#f1f5f9;"></canvas>`;
                    renderPdfPreview(file, previewId);
                } else {
                    iconHtml = `<i class="bi bi-${getFileIcon(file.type)}" style="font-size:1.5rem; color:#64748b;"></i>`;
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

        window.removeFile = function(index) {
            selectedFiles.splice(index, 1);
            updateFileInput();
            updateFileList();
        }

        let pendingDeleteIndex = null;
        let pendingDeleteElement = null;

        window.markFileForDeletion = function(index, btnElement) {
            pendingDeleteIndex = index;
            pendingDeleteElement = btnElement;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

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

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                modal.hide();

                // Reset
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
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function getFileIcon(type) {
            if (type.includes('pdf')) return 'file-pdf';
            if (type.includes('word')) return 'file-word';
            if (type.includes('excel') || type.includes('spreadsheet')) return 'file-excel';
            return 'file-earmark';
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
                const scale = Math.min(40 / viewport.width, 40 / viewport.height) * 2;
                const scaledViewport = page.getViewport({
                    scale: scale
                });

                const context = canvas.getContext('2d');
                canvas.height = 40;
                canvas.width = 40;

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
                    canvas.replaceWith(document.createRange().createContextualFragment('<i class="bi bi-file-pdf-fill" style="font-size:1.5rem; color:#dc3545;"></i>'));
                }
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/requests/edit.blade.php ENDPATH**/ ?>