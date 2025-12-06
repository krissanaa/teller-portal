<?php $__env->startSection('title', 'Edit Branch'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .branch-shell {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1rem 1rem 2rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .branch-card {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(28, 114, 75, 0.12);
        background: #fff;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
        padding: 1rem 1.25rem;
    }

    .branch-card h4 {
        font-weight: 700;
        color: #1c724b;
        margin-bottom: 0.875rem;
        font-size: 1.05rem;
    }

    .branch-card label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .branch-card .form-control,
    .branch-card textarea,
    .branch-card select {
        border-radius: 8px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }

    .unit-table {
        margin-bottom: 0.75rem;
    }

    .unit-table thead {
        background: #0f766e;
        color: #fff;
    }

    .unit-table tbody tr:hover {
        background: rgba(20, 184, 166, 0.08);
    }

    .unit-form input {
        border-radius: 8px;
        padding: 0.45rem 0.7rem;
        font-size: 0.9rem;
    }

    .unit-form .btn {
        padding: 0.4rem 0.7rem;
    }

    .branch-card .btn {
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="branch-shell">
    <div class="branch-card">
        <h4>Edit Branch</h4>
        <form method="POST" action="<?php echo e(route('admin.branches.update', $branch->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-2">
                <label class="form-label">Branch Code *</label>
                <input type="text" name="branch_code" class="form-control" value="<?php echo e(old('branch_code', $branch->code)); ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Branch Name *</label>
                <input type="text" name="branch_name" class="form-control" value="<?php echo e(old('branch_name', $branch->name)); ?>" required>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-success" style="padding: 0.5rem 1.15rem;">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
                <a href="<?php echo e(route('admin.branches.index')); ?>" class="btn btn-outline-secondary" style="padding: 0.5rem 1.15rem;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>

    <div class="branch-card mt-3">
        <h4>Manage Units</h4>

        <!-- Add New Unit Form -->
        <div class="mb-3 p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
            <form method="POST" action="<?php echo e(route('admin.branches.units.store', $branch->id)); ?>" class="row g-2 align-items-end">
                <?php echo csrf_field(); ?>
                <div class="col-md-2">
                    <label class="form-label" style="font-size: 0.8125rem; margin-bottom: 0.25rem;">New Unit Code</label>
                    <input type="text" name="unit_code" class="form-control" required placeholder="400201">
                </div>
                <div class="col-md-7">
                    <label class="form-label" style="font-size: 0.8125rem; margin-bottom: 0.25rem;">New Unit Name</label>
                    <input type="text" name="unit_name" class="form-control" required placeholder="Unit Description">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Add Unit
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Units List -->
        <div class="units-list">
            <?php $__empty_1 = true; $__currentLoopData = $branch->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="unit-row mb-2 p-2" style="background: white; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div class="row g-2 align-items-center">
                    <!-- Hidden Forms -->
                    <form id="update-unit-<?php echo e($unit->id); ?>" method="POST" action="<?php echo e(route('admin.branches.units.update', [$branch->id, $unit->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                    </form>
                    <form id="delete-unit-<?php echo e($unit->id); ?>" method="POST" action="<?php echo e(route('admin.branches.units.destroy', [$branch->id, $unit->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                    </form>

                    <div class="col-md-2">
                        <input type="text" name="unit_code" form="update-unit-<?php echo e($unit->id); ?>" value="<?php echo e(old('unit_code', $unit->unit_code)); ?>" class="form-control form-control-sm" required placeholder="Code">
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="unit_name" form="update-unit-<?php echo e($unit->id); ?>" value="<?php echo e(old('unit_name', $unit->unit_name)); ?>" class="form-control form-control-sm" required placeholder="Name">
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary flex-grow-1" form="update-unit-<?php echo e($unit->id); ?>">
                                <i class="bi bi-save"></i> Save
                            </button>
                            <button class="btn btn-sm btn-outline-danger flex-grow-1" form="delete-unit-<?php echo e($unit->id); ?>" onclick="return confirm('Delete this unit?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center p-3" style="background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0 mt-2">No units for this branch yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/branches/edit.blade.php ENDPATH**/ ?>