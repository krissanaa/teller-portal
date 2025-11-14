<?php $__env->startSection('title', 'ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ'); ?>

<?php $__env->startSection('content'); ?>
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .page-header {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--apb-accent);
    }

    .page-header h4 {
        margin: 0;
        color: #212529;
        font-weight: 700;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .card-header-custom {
        background: #f8f9fa;
        padding: 20px 28px;
        border-bottom: 1px solid #e9ecef;
    }

    .card-header-custom h5 {
        margin: 0;
        color: #212529;
        font-weight: 700;
        font-size: 1.6rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-body-custom {
        padding: 28px;
    }

    .detail-section {
        margin-bottom: 28px;
    }

    .section-title {
        color: #212529;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--apb-accent);
        font-size: 1.2rem;
    }

    .detail-row {
        display: flex;
        padding: 14px 0;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.2s ease;
    }

    .detail-row:hover {
        background: #f8f9fa;
        padding-left: 12px;
        margin-left: -12px;
        padding-right: 12px;
        margin-right: -12px;
        border-radius: 6px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .detail-label i {
        color: #6c757d;
    }

    .detail-value {
        flex: 1;
        color: #000000;
        font-weight: 600;
        font-size: 1rem;   s
    }

    .detail-value.empty {
        color: #9e9e9e;
        font-style: italic;
    }

    .info-badge {
        background: #f8f9fa;
        color: #212529;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    /* Status Badge */
    .status-badge-large {
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge-large.approved {
        background: #d4edda;
        color: #155724;
        border: 2px solid #28a745;
    }

    .status-badge-large.pending {
        background: #fff3cd;
        color: #856404;
        border: 2px solid #ffc107;
    }

    .status-badge-large.rejected {
        background: #f8d7da;
        color: #721c24;
        border: 2px solid #dc3545;
    }

    /* Attachment Section */
    .attachment-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border: 2px dashed #ced4da;
        margin-top: 20px;
    }

    .attachment-header {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #212529;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 14px;
    }

    .attachment-header i {
        color: var(--apb-accent);
    }

    .attachment-preview {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 14px;
    }

    .attachment-preview img {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 10px;
    }

    .pdf-viewer {
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    /* Action Buttons */
    .action-buttons {
        padding: 20px 28px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-edit {
        background: #ffc107;
        border: none;
        color: #000;
        padding: 11px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        color: #000;
    }

    .btn-back {
        background: rgb(255, 255, 255);
        border: 2px solid #f70000;
        color: #000000;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-size: 1rem;
    }

    .btn-back:hover {
        background: rgb(255, 0, 0);
        border: 2px solid #ff0000;
        color: #ffffff;
        transform: translateY(-3px);
    }

    .btn-pdf {
        background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .detail-row {
            flex-direction: column;
            gap: 6px;
        }

        .detail-label {
            flex: none;
        }

        .card-body-custom, .action-buttons {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons > * {
            width: 100%;
            justify-content: center;
        }
    }
    .drive-style-section {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e9ecef;
}
.drive-header {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #2D5F3F;
    font-size: 1.1rem;
}
.drive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
}
.drive-card {
    position: relative;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow: hidden;
    cursor: pointer;
    transition: all 0.25s ease;
}
.drive-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 14px rgba(0,0,0,0.12);
}
.drive-thumb {
    height: 160px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}
.drive-thumb img,
.drive-thumb iframe {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: none;
}
.drive-type {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,0.8);
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 0.85rem;
    font-weight: bold;
}
.drive-type.pdf { color: #dc3545; }
.drive-icon i {
    font-size: 3rem;
    color: #adb5bd;
}
.drive-name {
    padding: 10px 12px;
    font-size: 0.9rem;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
}
.modal-xl {
    max-width: 98vw !important;
}
#previewModal .modal-content {
    height: 96vh;
    border-radius: 12px;
    overflow: hidden;
}
#previewModal .modal-body {
    padding: 0;
    height: calc(100vh - 80px);
}


</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h4>
            <i class="bi bi-file-text"></i>
            ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ
        </h4>
        <p class="page-subtitle">ຂໍ້ມູນລະອຽດຂອງຮ້ານຄ້າ ແລະ ສະຖານະການອະນຸມັດ</p>
    </div>

    <!-- Main Details Card -->
    <div class="detail-card">
        <div class="card-header-custom">
            <h5>
                <i class="bi bi-shop-window"></i>
                <?php echo e($request->store_name); ?>

            </h5>
        </div>

        <div class="card-body-custom">
            <!-- Section 1: Basic Information -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    ຂໍ້ມູນພື້ນຖານ
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-hash"></i>
                        ລະຫັດອ້າງອີງ
                    </div>
                    <div class="detail-value">
                        <span class="info-badge">
                            <i class="bi bi-tag"></i>
                            <?php echo e($request->refer_code); ?>

                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-briefcase"></i>
                        ປະເພດທຸລະກິດ
                    </div>
                    <div class="detail-value"><?php echo e($request->business_type); ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-geo-alt"></i>
                        ທີ່ຢູ່
                    </div>
                    <div class="detail-value"><?php echo e($request->store_address); ?></div>
                </div>
            </div>

            <!-- Section 2: POS & Banking -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-credit-card"></i>
                    ຂໍ້ມູນ POS ແລະ ທະນາຄານ
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-upc-scan"></i>
                        ລະຫັດເຄື່ອງ POS
                    </div>
                    <div class="detail-value">
                        <span class="info-badge"><?php echo e($request->pos_serial); ?></span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-bank"></i>
                        ເລກບັນຊີທະນາຄານ
                    </div>
                    <div class="detail-value <?php echo e(!$request->bank_account ? 'empty' : ''); ?>">
                        <?php echo e($request->bank_account ?? 'ບໍ່ມີຂໍ້ມູນ'); ?>

                    </div>
                </div>
            </div>

            <!-- Section 3: Installation Details -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-calendar-check"></i>
                    ຂໍ້ມູນການຕິດຕັ້ງ
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-calendar3"></i>
                        ວັນທີຕິດຕັ້ງ
                    </div>
                    <div class="detail-value">
                        <i class="bi bi-calendar-event text-primary me-2"></i>
                        <?php echo e(\Carbon\Carbon::parse($request->installation_date)->format('d/m/Y')); ?>

                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-pin-map"></i>
                        ສາຂາ
                    </div>
                    <div class="detail-value <?php echo e(!$request->branch ? 'empty' : ''); ?>">
                        <?php echo e($request->branch->name ?? 'ບໍ່ມີຂໍ້ມູນ'); ?>

                    </div>
                </div>
            </div>

            <!-- Section 4: Status -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-check-circle"></i>
                    ສະຖານະການອະນຸມັດ
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-flag"></i>
                        ສະຖານະ
                    </div>
                    <div class="detail-value">
                        <?php if($request->approval_status == 'approved'): ?>
                            <span class="status-badge-large approved">
                                <i class="bi bi-check-circle-fill"></i>
                                ອະນຸມັດແລ້ວ
                            </span>
                        <?php elseif($request->approval_status == 'pending'): ?>
                            <span class="status-badge-large pending">
                                <i class="bi bi-clock-fill"></i>
                                ລໍຖ້າອະນຸມັດ
                            </span>
                        <?php else: ?>
                            <span class="status-badge-large rejected">
                                <i class="bi bi-x-circle-fill"></i>
                                ປະຕິເສດ
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-chat-dots"></i>
                        ໝາຍເຫດ
                    </div>
                    <div class="detail-value <?php echo e(!$request->admin_remark ? 'empty' : ''); ?>">
                        <?php echo e($request->admin_remark ?? ''); ?>

                    </div>
                </div>
            </div>


<!-- Attachment Section -->
<?php if(!empty($request->attachments)): ?>
    <?php
        $attachments = json_decode($request->attachments ?? '[]', true);
    ?>

    <?php if(!empty($attachments)): ?>
        <div class="drive-style-section mt-4">
            <div class="drive-header mb-3">
                <i class="bi bi-paperclip"></i>
                ເອກະສານແນບ (ຄລິກທີ່ໂລໂກເພື່ອເບິ່ງ)
            </div>

            <div class="drive-grid">
                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fileUrl = asset('storage/' . $filePath);
                        $fileName = basename($filePath);
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    ?>

                    <div class="drive-card" onclick="openPreview('<?php echo e($fileUrl); ?>', '<?php echo e($fileName); ?>', '<?php echo e($extension); ?>')">
                        <div class="drive-thumb">
                            <?php if(in_array($extension, ['jpg','jpeg','png'])): ?>
                                <img src="<?php echo e($fileUrl); ?>" alt="<?php echo e($fileName); ?>">
                            <?php elseif($extension === 'pdf'): ?>
                                <iframe src="<?php echo e($fileUrl); ?>" title="<?php echo e($fileName); ?>"></iframe>
                            <?php else: ?>
                                <div class="drive-icon">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                            <?php endif; ?>
                            <div class="drive-type <?php echo e($extension); ?>"><?php echo e(strtoupper($extension)); ?></div>
                        </div>
                        <div class="drive-name"><?php echo e($fileName); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-3">
            <i class="bi bi-exclamation-triangle me-2"></i>
            ບໍ່ພົບໄຟລ໌ແນບໃນລາຍການນີ້
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- 🔍 Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewTitle" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen"> <!-- 👈 ใช้ fullscreen modal -->
        <div class="modal-content bg-dark text-white border-0">
            <div class="modal-header border-0 bg-success py-2">
                <h5 class="modal-title text-white" id="previewTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="previewContainer">
                <!-- Preview will load dynamically -->
            </div>
        </div>
    </div>
</div>


        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">


            <a href="<?php echo e(route('teller.dashboard')); ?>" class="btn-back">
                <i class="bi bi-arrow-left-circle"></i>
                ກັບຄືນ
            </a>


                <a href="<?php echo e(route('teller.requests.edit', $request->id)); ?>" class="btn-edit">
                    <i class="bi bi-pencil-square"></i>
                    ແກ້ໄຂຂໍ້ມູນ
                </a>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<script>
function openPreview(fileUrl, fileName, extension) {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    const title = document.getElementById('previewTitle');
    const container = document.getElementById('previewContainer');

    title.textContent = fileName;
    container.innerHTML = '';

    if (['jpg', 'jpeg', 'png'].includes(extension)) {
        container.innerHTML = `
            <div class="d-flex justify-content-center align-items-center bg-black" style="height:100vh;">
                <img src="${fileUrl}" class="img-fluid rounded shadow">
            </div>`;
    }
    else if (extension === 'pdf') {
        container.innerHTML = `
            <iframe src="${fileUrl}"
                width="100%"
                height="100%"
                style="border:0; display:block;"
                class="bg-dark">
            </iframe>`;
    }
    else {
        container.innerHTML = `
            <div class="d-flex flex-column justify-content-center align-items-center text-center text-white-50" style="height:100vh;">
                <i class="bi bi-file-earmark fs-1"></i>
                <p class="mt-3">ບໍ່ສາມາດເບິ່ງໄຟລ໌ນີ້ໄດ້<br>
                <a href="${fileUrl}" target="_blank" class="text-success fw-bold">ດາວໂຫລດ</a></p>
            </div>`;
    }

    modal.show();
}
</script>







<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/requests/show.blade.php ENDPATH**/ ?>