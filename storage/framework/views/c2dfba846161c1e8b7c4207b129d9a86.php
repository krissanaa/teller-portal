<?php $__env->startSection('title', 'ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ'); ?>

<?php $__env->startSection('content'); ?>
<?php
$tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
?>
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

    .form-value {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        background: #f8fafc;
        color: #334155;
        min-height: 42px;
        display: flex;
        align-items: center;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-approved {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* File Preview Grid */
    .file-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 8px;
    }

    .file-item {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-item:hover {
        border-color: var(--apb-primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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

    .btn-back {
        background: white;
        border: 1px solid #cbd5e1;
        color: #64748b;
    }

    .btn-back:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
    }

    .btn-edit:hover {
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
            <i class="bi bi-file-text-fill"></i>
            <span>ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ</span>
            <div style="margin-left: auto;">
                <?php if ($request->approval_status == 'approved'): ?>
                    <span class="status-badge status-approved"><i class="bi bi-check-circle-fill"></i> ອະນຸມັດ</span>
                <?php elseif ($request->approval_status == 'pending'): ?>
                    <span class="status-badge status-pending"><i class="bi bi-clock-fill"></i> ລໍຖ້າອະນຸມັດ</span>
                <?php else: ?>
                    <span class="status-badge status-rejected"><i class="bi bi-x-circle-fill"></i> ປະຕິເສດ</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-grid">
            <!-- Row 1 -->
            <div class="form-group">
                <label>ຊື່ຮ້ານຄ້າ</label>
                <div class="form-value"><?php echo e($request->store_name); ?></div>
            </div>

            <div class="form-group">
                <label>ປະເພດທຸລະກິດ</label>
                <div class="form-value"><?php echo e($request->business_type); ?></div>
            </div>

            <div class="form-group">
                <label>ເລກບັນຊີທະນາຄານ</label>
                <div class="form-value"><?php echo e($request->bank_account ?? '-'); ?></div>
            </div>

            <div class="form-group">
                <label>ວັນທີຕິດຕັ້ງ</label>
                <div class="form-value"><?php echo e(\Carbon\Carbon::parse($request->installation_date)->format('d/m/Y')); ?></div>
            </div>

            <!-- Row 2 -->
            <div class="form-group col-span-2">
                <label>ທີ່ຢູ່ຮ້ານຄ້າ</label>
                <div class="form-value" style="height: auto; min-height: 42px;"><?php echo e($request->store_address); ?></div>
            </div>

            <div class="form-group">
                <label>ລະຫັດອ້າງອີງ</label>
                <div class="form-value"><?php echo e($request->refer_code); ?></div>
            </div>

            <div class="form-group">
                <label>ລະຫັດເຄື່ອງ POS</label>
                <div class="form-value"><?php echo e($request->pos_serial ?? '-'); ?></div>
            </div>

            <!-- Row 3: Attachments -->
            <?php if (!empty($request->attachments)): ?>
                <div class="form-group col-span-4">
                    <label>ເອກະສານແນບ</label>
                    <div class="file-preview-grid">
                        <?php $attachments = json_decode($request->attachments ?? '[]', true); ?>
                        <?php $__currentLoopData = $attachments;
                        $__env->addLoop($__currentLoopData);
                        foreach ($__currentLoopData as $filePath): $__env->incrementLoopIndices();
                            $loop = $__env->getLastLoop(); ?>
                            <?php
                            $fileUrl = asset('storage/' . $filePath);
                            $fileName = basename($filePath);
                            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            ?>
                            <div class="file-item" onclick="openPreview('<?php echo e($fileUrl); ?>', '<?php echo e($fileName); ?>', '<?php echo e($extension); ?>')">
                                <?php if (in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                    <img src="<?php echo e($fileUrl); ?>" class="file-preview-img">
                                <?php elseif ($extension === 'pdf'): ?>
                                    <i class="bi bi-file-pdf-fill" style="color: #ef4444; font-size: 1.5rem;"></i>
                                <?php else: ?>
                                    <i class="bi bi-file-earmark-text"></i>
                                <?php endif; ?>
                                <div class="file-details">
                                    <div class="file-name" title="<?php echo e($fileName); ?>"><?php echo e($fileName); ?></div>
                                    <div class="file-size"><?php echo e(strtoupper($extension)); ?></div>
                                </div>
                            </div>
                        <?php endforeach;
                        $__env->popLoop();
                        $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Admin Remark if rejected -->
            <?php if ($request->admin_remark): ?>
                <div class="form-group col-span-4">
                    <label>ໝາຍເຫດຈາກຜູ້ອະນຸມັດ</label>
                    <div class="form-value" style="background: #fff1f2; color: #991b1b; border-color: #fecaca;">
                        <?php echo e($request->admin_remark); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('teller.dashboard')); ?>" class="btn btn-back">
                <i class="bi bi-arrow-left"></i> ກັບຄືນ
            </a>
            <a href="<?php echo e(route('teller.requests.edit', $request->id)); ?>" class="btn btn-edit">
                <i class="bi bi-pencil-square"></i> ແກ້ໄຂຂໍ້ມູນ
            </a>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="height: 85vh; border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0 py-3 px-4" style="background: white; position: absolute; top: 0; left: 0; right: 0; z-index: 10;">
                <h5 class="modal-title text-dark fw-bold" id="previewTitle" style="font-size: 1.1rem;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background-color: #f1f5f9; padding: 10px; border-radius: 50%; opacity: 1;"></button>
            </div>
            <div class="modal-body p-0 bg-light d-flex align-items-center justify-content-center" id="previewContainer" style="padding-top: 60px !important;"></div>
        </div>
    </div>
</div>

<script>
    function openPreview(fileUrl, fileName, extension) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        document.getElementById('previewTitle').textContent = fileName;
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';

        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            container.innerHTML = `<img src="${fileUrl}" class="img-fluid shadow-sm" style="max-height: 100%; max-width: 100%; border-radius: 8px;">`;
        } else if (extension === 'pdf') {
            container.innerHTML = `<iframe src="${fileUrl}" width="100%" height="100%" style="border:0;"></iframe>`;
        } else {
            container.innerHTML = `
                <div class="text-center">
                    <div class="mb-3"><i class="bi bi-file-earmark-text text-secondary" style="font-size: 4rem;"></i></div>
                    <h5 class="text-secondary mb-3">ບໍ່ສາມາດສະແດງຕົວຢ່າງໄດ້</h5>
                    <a href="${fileUrl}" class="btn btn-primary px-4 rounded-pill" download>
                        <i class="bi bi-download me-2"></i> ດາວໂຫລດໄຟລ໌
                    </a>
                </div>`;
        }
        modal.show();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/requests/show.blade.php ENDPATH**/ ?>