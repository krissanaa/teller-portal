<?php $__env->startSection('title', 'Onboarding Detail'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h4 class="mb-3">👁️ Onboarding Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-3"><?php echo e($req->store_name); ?></h5>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Store Name:</strong> <?php echo e($req->store_name); ?></p>
                    <p><strong>Business Type:</strong> <?php echo e($req->business_type); ?></p>
                    <p><strong>Bank Account:</strong> <?php echo e($req->bank_account ?? 'n/a'); ?></p>
                    <p><strong>Installation Date:</strong> <?php echo e(\Carbon\Carbon::parse($req->installation_date)->format('d/m/Y')); ?></p>
                    <p><strong>Status:</strong>
                        <?php if($req->approval_status == 'approved'): ?>
                        <span class="badge bg-success">Approved</span>
                        <?php elseif($req->approval_status == 'pending'): ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                        <?php else: ?>
                        <span class="badge bg-danger">Rejected</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Address:</strong> <?php echo e($req->store_address); ?></p>
                    <p><strong>Refer Code:</strong> <?php echo e($req->refer_code); ?></p>
                    <p><strong>POS Serial:</strong> <?php echo e($req->pos_serial ?? 'n/a'); ?></p>
                    <p><strong>Branch:</strong> <?php echo e(optional($req->branch)->name ?? 'n/a'); ?></p>
                    <p><strong>Service Unit:</strong> <?php echo e(optional($req->unit)->name ?? 'n/a'); ?></p>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <h6 class="fw-bold">Teller Info</h6>
                <p class="mb-1"><strong>Name:</strong> <?php echo e(optional($req->teller)->name ?? '-'); ?> (<?php echo e($req->teller_id ?? '-'); ?>)</p>
                <p class="mb-1"><strong>Phone:</strong> <?php echo e(optional($req->teller)->phone ?? '-'); ?></p>
            </div>

            <?php if(!empty($req->attachments)): ?>
            <hr>
            <h6 class="fw-bold mb-3">Attachments</h6>
            <div class="d-flex flex-wrap gap-2">
                <?php
                $attachments = is_array($req->attachments)
                ? $req->attachments
                : (is_string($req->attachments) ? json_decode($req->attachments ?? '[]', true) : []);
                ?>
                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $fileUrl = asset('storage/' . $filePath);
                $fileName = basename($filePath);
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                ?>
                <div class="card p-2 shadow-sm d-flex align-items-center gap-2" style="cursor: pointer; width: 200px;"
                    onclick="openPreview('<?php echo e($fileUrl); ?>', '<?php echo e($fileName); ?>', '<?php echo e($extension); ?>')">
                    <div class="fs-2 text-secondary">
                        <?php if(in_array($extension, ['jpg','jpeg','png'])): ?>
                        <i class="bi bi-file-image"></i>
                        <?php elseif($extension === 'pdf'): ?>
                        <i class="bi bi-file-pdf text-danger"></i>
                        <?php else: ?>
                        <i class="bi bi-file-earmark"></i>
                        <?php endif; ?>
                    </div>
                    <div class="text-truncate" style="flex: 1;">
                        <span class="d-block small fw-bold text-truncate" title="<?php echo e($fileName); ?>"><?php echo e($fileName); ?></span>
                        <span class="d-block small text-muted"><?php echo e(strtoupper($extension)); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <?php if($req->admin_remark): ?>
            <div class="alert alert-danger mt-3">
                <strong>Admin Remark:</strong> <?php echo e($req->admin_remark); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex gap-2">
        <?php if($req->approval_status == 'pending'): ?>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal"
            data-request-id="<?php echo e($req->id); ?>"
            data-store="<?php echo e($req->store_name); ?>"
            data-refer="<?php echo e($req->refer_code); ?>"
            data-pos-serial="<?php echo e($req->pos_serial); ?>">
            <i class="bi bi-check-circle"></i> Approve
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal"
            data-request-id="<?php echo e($req->id); ?>"
            data-store="<?php echo e($req->store_name); ?>"
            data-refer="<?php echo e($req->refer_code); ?>">
            <i class="bi bi-x-circle"></i> Reject
        </button>
        <?php endif; ?>
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
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

        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
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

    // Modal Logic
    const approveModal = document.getElementById('approveModal');
    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const requestId = button.getAttribute('data-request-id');
            const storeName = button.getAttribute('data-store');
            const referCode = button.getAttribute('data-refer');
            const posSerial = button.getAttribute('data-pos-serial');

            const infoText = `Approving request for <strong>${storeName}</strong> (Ref: ${referCode})`;
            document.getElementById('approve_request_info').innerHTML = infoText;

            const form = document.getElementById('approveForm');
            const baseAction = form.getAttribute('data-base-action');
            form.action = baseAction.replace('__REQUEST_ID__', requestId);

            const posInput = document.getElementById('modal_pos_serial');
            if (posSerial) {
                posInput.value = posSerial;
            } else {
                posInput.value = '';
            }
        });
    }

    const rejectModal = document.getElementById('rejectModal');
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const requestId = button.getAttribute('data-request-id');
            const storeName = button.getAttribute('data-store');
            const referCode = button.getAttribute('data-refer');

            const infoText = `Rejecting request for <strong>${storeName}</strong> (Ref: ${referCode})`;
            document.getElementById('modal_request_info').innerHTML = infoText;
            document.getElementById('modal_request_id').value = requestId;

            const form = document.getElementById('rejectForm');
            const baseAction = form.getAttribute('data-base-action');
            form.action = baseAction.replace('__REQUEST_ID__', requestId);
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/onboarding/show.blade.php ENDPATH**/ ?>