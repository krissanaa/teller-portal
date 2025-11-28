<?php $__env->startSection('title', 'Admin Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --apb-primary: #0f766e;
        --apb-secondary: #0d5c56;
        --apb-accent: #14b8a6;
        --apb-dark: #0b3f3a;
        --bg-color: #f8f9fa;
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

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pill.approved {
        background: #dcfce7;
        color: #166534;
    }

    .status-pill.pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-pill.rejected {
        background: #fee2e2;
        color: #991b1b;
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

    .btn-action.approve {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .btn-action.approve:hover {
        background: #bbf7d0;
        transform: translateY(-1px);
    }

    .btn-action.reject {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .btn-action.reject:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
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
</style>


<div class="filter-card">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label for="search" class="form-label">Search by name, teller ID, or phone</label>
            <input
                type="text"
                id="search"
                name="search"
                value="<?php echo e($search); ?>"
                class="form-control"
                placeholder="Enter keyword...">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-filter w-100">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
        <?php if(!empty($search)): ?>
        <div class="col-md-2">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary w-100" style="border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600;">
                Clear
            </a>
        </div>
        <?php endif; ?>
        <div class="col-md-3 ms-auto">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="create-btn w-100 justify-content-center">
                <i class="bi bi-person-plus-fill"></i> Create Admin
            </a>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5>All Admin Accounts</h5>
        <span class="meta"><?php echo e($users->total()); ?> total</span>
    </div>
    <div class="table-responsive flex-grow-1">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($u->id); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.users.show', $u->id)); ?>" class="text-decoration-none fw-bold text-dark">
                            <?php echo e($u->name); ?>

                        </a>
                    </td>
                    <td><?php echo e($u->email); ?></td>
                    <td><?php echo e($u->phone); ?></td>
                    <td>
                        <span class="status-pill <?php echo e($u->status); ?>">
                            <?php if($u->status === 'approved'): ?>
                            <i class="bi bi-check-circle"></i>
                            <?php elseif($u->status === 'pending'): ?>
                            <i class="bi bi-clock-history"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle"></i>
                            <?php endif; ?>
                            <?php echo e(ucfirst($u->status)); ?>

                        </span>
                    </td>
                    <td><?php echo e($u->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <div class="action-buttons justify-content-center">
                            <?php if($u->status !== 'approved'): ?>
                            <form action="<?php echo e(route('admin.users.updateStatus', $u->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn-action approve">
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if($u->status !== 'rejected'): ?>
                            <form action="<?php echo e(route('admin.users.updateStatus', $u->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn-action reject">
                                    <i class="bi bi-x-lg"></i> Reject
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-inbox display-4 text-secondary mb-3"></i>
                            <p class="mb-0 fw-semibold">No admin accounts found.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
    <div class="position-relative mt-4 p-4 border-top">
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Back to Home
            </a>
        </div>
        <div class="d-flex flex-column align-items-end">
            <div class="text-muted small mb-2">
                Showing <?php echo e($users->firstItem()); ?> to <?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?> results
            </div>
            <div>
                <?php echo e($users->links('vendor.pagination.custom')); ?>

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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>