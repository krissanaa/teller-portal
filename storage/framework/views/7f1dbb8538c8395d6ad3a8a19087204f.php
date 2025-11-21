<?php $__env->startSection('title', ''); ?>
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
        color: #000000;
        margin-bottom: 1.5rem;
    }

    .branch-card label {
        font-weight: 600;
        color: #0f172a;
    }

    .branch-card .form-control,
    .branch-card textarea {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        padding: 0.75rem 1rem;
    }
</style>

<div class="branch-shell">
    <div class="branch-card">
        <h4>Add New Branch</h4>
        <form method="POST" action="<?php echo e(route('admin.branches.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Branch Code *</label>
                <input type="text" name="branch_code" class="form-control" value="<?php echo e(old('branch_code')); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Branch Name *</label>
                <input type="text" name="branch_name" class="form-control" value="<?php echo e(old('branch_name')); ?>" required>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save
                </button>
                <a href="<?php echo e(route('admin.branches.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/branches/create.blade.php ENDPATH**/ ?>