<?php $__env->startSection('title', 'Branch Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --apb-primary: #14b8a6;
        --apb-secondary: #0f766e;
        --apb-accent: #2dd4bf;
        --apb-dark: #0d5c56;
        --bg-color: #f1f5f9;
        --card-bg: #ffffff;
        --text-dark: #334155;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body {
        font-family: 'Inter', 'Noto Sans Lao', sans-serif;
        background: var(--bg-color);
        color: var(--text-dark);
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .page-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        gap: 0.75rem;
        text-align: center;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.25rem;
        border: 1px solid var(--border-color);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.35rem;
        font-size: 0.875rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.5rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--apb-accent);
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }

    .btn-filter {
        background: var(--apb-primary);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background: var(--apb-secondary);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.2);
    }

    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
        min-height: 400px;
        display: flex;
        flex-direction: column;
    }

    .table-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    .table-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
        font-size: 1.1rem;
    }

    .meta {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
        background: #e2e8f0;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
    }

    .table-modern {
        width: 100%;
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 0.875rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-modern tbody td {
        padding: 0.875rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.9375rem;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-action {
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        border-radius: 6px;
        transition: all 0.2s;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-weight: 500;
    }

    .btn-action.edit {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }

    .btn-action.edit:hover {
        background: #bae6fd;
        transform: translateY(-1px);
    }

    .btn-action.delete {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .btn-action.delete:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    /* Pagination - Teller Style */
    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        color: #64748b;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        min-width: 28px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.4);
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
        pointer-events: none;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        transform: none;
        box-shadow: none;
    }

    .create-btn {
        background: var(--apb-primary);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .create-btn:hover {
        background: var(--apb-secondary);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.2);
    }

    .unit-card {
        border: 1px solid rgba(15, 118, 110, 0.15);
        border-radius: 8px;
        padding: 8px 12px;
        background: white;
        box-shadow: 0 2px 4px rgba(15, 23, 42, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .unit-code {
        font-weight: 700;
        color: #0f766e;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
    }

    .unit-name {
        font-size: 0.8125rem;
        color: var(--text-muted);
    }

    .unit-empty {
        color: #94a3b8;
        font-size: 0.85rem;
        font-style: italic;
    }

    .unit-row td {
        background: #f8fafc;
        padding: 1rem 1.5rem;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-diagram-3-fill text-primary"></i> Branch Management
    </h1>
</div>

<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-9">
            <!-- Placeholder for search if needed in future, or just empty space -->
        </div>
        <div class="col-md-3 ms-auto">
            <a href="<?php echo e(route('admin.branches.create')); ?>" class="create-btn w-100 justify-content-center">
                <i class="bi bi-plus-circle"></i> Add Branch
            </a>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5>All Branches</h5>
        <span class="meta"><?php echo e($branches->total()); ?> total</span>
    </div>
    <div class="table-responsive flex-grow-1">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Code</th>
                    <th>Branch Name</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($b->id); ?></td>
                    <td class="fw-bold text-primary"><?php echo e($b->code); ?></td>
                    <td><?php echo e($b->name); ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?php echo e(route('admin.branches.edit', $b->id)); ?>" class="btn-action edit text-decoration-none">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.branches.destroy', $b->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn-action delete" onclick="return confirm('Delete this branch?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr class="unit-row">
                    <td colspan="4">
                        <?php if($b->units->isNotEmpty()): ?>
                        <div class="row g-2 mb-3">
                            <?php $__currentLoopData = $b->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 col-lg-3">
                                <div class="unit-card">
                                    <div class="unit-code">
                                        <i class="bi bi-diagram-3"></i>
                                        <?php echo e($unit->unit_code); ?>

                                    </div>
                                    <div class="unit-name">
                                        <?php echo e($unit->unit_name); ?>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <div class="mb-3">
                            <span class="unit-empty">No units registered for this branch.</span>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('admin.branches.units.store', $b->id)); ?>" class="row g-2 align-items-end">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-3">
                                <label class="form-label small text-muted mb-1">Unit Code</label>
                                <input type="text" name="unit_code" class="form-control form-control-sm" placeholder="400201" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Unit Name</label>
                                <input type="text" name="unit_name" class="form-control form-control-sm" placeholder="Unit Description" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-success w-100" style="background: var(--apb-primary); border: none;">
                                    <i class="bi bi-plus-circle"></i> Add Unit
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-inbox display-4 text-secondary mb-3"></i>
                            <p class="mb-0 fw-semibold">No branches found.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($branches->hasPages()): ?>
    <div class="position-relative mt-4 p-4 border-top">
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Back to Home
            </a>
        </div>
        <div class="d-flex flex-column align-items-end">
            <div class="text-muted small mb-2">
                Showing <?php echo e($branches->firstItem()); ?> to <?php echo e($branches->lastItem()); ?> of <?php echo e($branches->total()); ?> results
            </div>
            <div>
                <?php echo e($branches->links('vendor.pagination.custom')); ?>

            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center mt-4 p-4 border-top">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-house"></i> Back to Home
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/branches/index.blade.php ENDPATH**/ ?>