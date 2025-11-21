<?php $__env->startSection('title', 'Edit Branch'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .branch-shell {
        max-width: 900px;
        margin: 0 auto;
        padding: 2.5rem 1rem 3rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .branch-card {
        border-radius: 24px;
        border: 1px solid rgba(28, 114, 75, 0.12);
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        padding: 2rem;
    }

    .branch-card h4 {
        font-weight: 800;
        color: #1c724b;
        margin-bottom: 1.5rem;
    }

    .branch-card label {
        font-weight: 600;
        color: #0f172a;
    }

    .branch-card .form-control,
    .branch-card textarea,
    .branch-card select {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        padding: 0.75rem 1rem;
    }
    .unit-table thead {
        background: #0f766e;
        color: #fff;
    }

    .unit-table tbody tr:hover {
        background: rgba(20, 184, 166, 0.08);
    }

    .unit-form input {
        border-radius: 10px;
    }
</style>

<div class="branch-shell">
    <div class="branch-card">
        <h4>Edit Branch</h4>
        <form method="POST" action="<?php echo e(route('admin.branches.update', $branch->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label class="form-label">Branch Code *</label>
                <input type="text" name="branch_code" class="form-control" value="<?php echo e(old('branch_code', $branch->code)); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Branch Name *</label>
                <input type="text" name="branch_name" class="form-control" value="<?php echo e(old('branch_name', $branch->name)); ?>" required>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
                <a href="<?php echo e(route('admin.branches.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>

    <div class="branch-card mt-4">
        <h4>Manage Units</h4>

        <table class="table unit-table align-middle mb-4">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th width="80"></th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $branch->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td colspan="4">
                        <form method="POST" action="<?php echo e(route('admin.branches.units.update', [$branch->id, $unit->id])); ?>" class="row g-2 unit-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="col-md-4">
                                <input type="text" name="unit_code" value="<?php echo e(old('unit_code', $unit->unit_code)); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="unit_name" value="<?php echo e(old('unit_name', $unit->unit_name)); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-1 d-grid">
                                <button class="btn btn-sm btn-primary"><i class="bi bi-save"></i></button>
                            </div>
                        </form>
                        <form method="POST" action="<?php echo e(route('admin.branches.units.destroy', [$branch->id, $unit->id])); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger mt-2" onclick="return confirm('Delete this unit?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-muted fst-italic">No units for this branch yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <form method="POST" action="<?php echo e(route('admin.branches.units.store', $branch->id)); ?>" class="row g-3">
            <?php echo csrf_field(); ?>
            <div class="col-md-4">
                <label class="form-label">New Unit Code</label>
                <input type="text" name="unit_code" class="form-control" required placeholder="400201">
            </div>
            <div class="col-md-6">
                <label class="form-label">New Unit Name</label>
                <input type="text" name="unit_name" class="form-control" required placeholder="Unit Description">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-plus-circle"></i> Add Unit
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/branches/edit.blade.php ENDPATH**/ ?>