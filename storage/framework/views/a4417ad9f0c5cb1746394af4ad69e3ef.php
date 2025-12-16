<?php $__env->startSection('title', 'Teller Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h4 class="mb-3">👁️ Teller Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <!-- View Mode -->
            <div id="view-mode">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0"><?php echo e($user->name); ?></h5>
                    <span class="badge
                        <?php if($user->status == 'approved'): ?> bg-success
                        <?php elseif($user->status == 'pending'): ?> bg-warning text-dark
                        <?php else: ?> bg-danger <?php endif; ?>">
                        <?php echo e(ucfirst($user->status)); ?>

                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Teller ID:</strong> <?php echo e($user->teller_id ?? 'N/A'); ?></p>
                        <p class="mb-2"><strong>Email:</strong> <?php echo e($user->email ?? 'N/A'); ?></p>
                        <p class="mb-2"><strong>Phone:</strong> <?php echo e($user->phone ?? 'N/A'); ?></p>
                        <p class="mb-2"><strong>Role:</strong>
                            <span class="badge bg-primary"><?php echo e(ucfirst($user->role ?? 'teller')); ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Branch:</strong> <?php echo e(optional($user->branch)->name ?? 'Not Assigned'); ?></p>
                        <p class="mb-2"><strong>Service Unit:</strong> <?php echo e(optional($user->unit)->name ?? 'Not Assigned'); ?></p>
                        <p class="mb-2"><strong>Created:</strong> <?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
                        <p class="mb-2"><strong>Last Updated:</strong> <?php echo e($user->updated_at->format('d/m/Y H:i')); ?></p>
                    </div>
                </div>

                <?php if(!empty($user->attachments)): ?>
                <hr>
                <h6 class="fw-bold mb-3">Attachments</h6>
                <div class="d-flex flex-wrap gap-2">
                    <?php $__currentLoopData = $user->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $fileUrl = asset('storage/' . $filePath);
                    $fileName = basename($filePath);
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    ?>
                    <div class="card p-2 shadow-sm d-flex flex-row align-items-center gap-2"
                        style="cursor: pointer; width: 220px; border: 1px solid #e2e8f0;"
                        onclick="openPreview('<?php echo e($fileUrl); ?>', '<?php echo e($fileName); ?>', '<?php echo e($extension); ?>')">

                        <?php if(in_array($extension, ['jpg','jpeg','png'])): ?>
                        <img src="<?php echo e($fileUrl); ?>" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        <?php elseif($extension === 'pdf'): ?>
                        <div class="d-flex align-items-center justify-content-center rounded bg-light" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-pdf-fill text-danger fs-4"></i>
                        </div>
                        <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center rounded bg-light" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-earmark-text text-secondary fs-4"></i>
                        </div>
                        <?php endif; ?>

                        <div class="text-truncate" style="flex: 1;">
                            <span class="d-block small fw-bold text-truncate" title="<?php echo e($fileName); ?>" style="color: #334155;"><?php echo e($fileName); ?></span>
                            <span class="d-block small text-muted" style="font-size: 0.75rem;"><?php echo e(strtoupper($extension)); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <?php if($user->status == 'pending'): ?>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Pending Approval:</strong> This teller account is awaiting approval.
                </div>
                <?php endif; ?>
            </div>

            <!-- Edit Form (Hidden by default) -->
            <form id="edit-mode" action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <h5 class="mb-3">✏️ Edit Teller Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($user->name); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo e($user->email); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e($user->phone); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Branch</label>
                        <select name="branch_id" class="form-select">
                            <option value="">-- Select Branch --</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>" <?php echo e($user->branch_id == $branch->id ? 'selected' : ''); ?>>
                                <?php echo e($branch->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Service Unit</label>
                        <select name="unit_id" class="form-select" id="unit-select">
                            <option value="">-- Select Unit --</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($unit->id); ?>"
                                data-branch-id="<?php echo e($unit->branch_id); ?>"
                                <?php echo e($user->unit_id == $unit->id ? 'selected' : ''); ?>>
                                <?php echo e($unit->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?php echo e($user->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="approved" <?php echo e($user->status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                            <option value="rejected" <?php echo e($user->status == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="toggleEdit()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex gap-2" id="action-buttons">
        <?php if($user->status == 'pending'): ?>
        <form action="<?php echo e(route('admin.users.updateStatus', $user->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success" onclick="return confirm('Approve this teller?')">
                ✅ Approve
            </button>
        </form>
        <form action="<?php echo e(route('admin.users.updateStatus', $user->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status" value="rejected">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this teller?')">
                ❌ Reject
            </button>
        </form>
        <?php endif; ?>

        <button type="button" class="btn btn-warning" onclick="toggleEdit()">✏️ Edit</button>

        <form action="<?php echo e(route('admin.users.resetPassword', $user->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-info" onclick="return confirm('Reset password for this user?')">
                🔑 Reset Password
            </button>
        </form>
        <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this teller?')">
                🗑️ Delete
            </button>
        </form>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">⬅️ Back</a>
    </div>
</div>

<script>
    function toggleEdit() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        const actionButtons = document.getElementById('action-buttons');

        if (editMode.classList.contains('d-none')) {
            // Switch to Edit Mode
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            actionButtons.classList.add('d-none');
        } else {
            // Switch to View Mode
            editMode.classList.add('d-none');
            viewMode.classList.remove('d-none');
            actionButtons.classList.remove('d-none');
        }
    }

    // Dynamic Branch-Unit Filtering
    document.addEventListener('DOMContentLoaded', function() {
        const branchSelect = document.querySelector('select[name="branch_id"]');
        const unitSelect = document.getElementById('unit-select');

        if (!branchSelect || !unitSelect) return;

        // Clone all options on load to preserve them
        const allOptions = Array.from(unitSelect.options).map(opt => opt.cloneNode(true));

        function filterUnits() {
            const selectedBranchId = branchSelect.value;
            const currentUnitId = unitSelect.value; // Capture current selection before clearing

            // Clear current options
            unitSelect.innerHTML = '';

            let foundSelected = false;

            allOptions.forEach(option => {
                // Always include placeholder
                if (option.value === "") {
                    unitSelect.appendChild(option.cloneNode(true));
                    return;
                }

                const unitBranchId = option.getAttribute('data-branch-id');

                // Logic: Show if no branch selected OR ID matches
                // Use loose comparison (==) to handle string vs number
                if (!selectedBranchId || unitBranchId == selectedBranchId) {
                    const newOption = option.cloneNode(true);
                    unitSelect.appendChild(newOption);

                    // Restore selection if it matches
                    if (newOption.value == currentUnitId) {
                        newOption.selected = true;
                        foundSelected = true;
                    }
                }
            });

            // If we didn't find the previously selected unit (e.g. branch changed), reset to placeholder
            if (!foundSelected) {
                unitSelect.value = "";
            }
        }

        // Event Listener
        branchSelect.addEventListener('change', filterUnits);

        // Initial Filter
        filterUnits();
    });
</script>

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
                    <h5 class="text-secondary mb-3">Unable to preview</h5>
                    <a href="${fileUrl}" class="btn btn-primary px-4 rounded-pill" download>
                        <i class="bi bi-download me-2"></i> Download File
                    </a>
                </div>`;
        }
        modal.show();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/show.blade.php ENDPATH**/ ?>