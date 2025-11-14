<?php $__env->startSection('title', 'POS Registration Reports'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --admin-primary: #1d4ed8;
        --admin-primary-dark: #1e3a8a;
        --admin-primary-light: #60a5fa;
        --admin-muted: #64748b;
        --admin-border: rgba(15, 23, 42, 0.1);
        --admin-card-bg: #ffffff;
        --admin-bg: #f8fafc;
        --admin-success: #059669;
        --admin-warning: #f59e0b;
        --admin-danger: #dc2626;
        --admin-shadow: 0 25px 45px -20px rgba(15, 23, 42, 0.25);
    }

    .admin-report-wrapper {
        background: var(--admin-bg);
        padding: 1rem 0 2rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .admin-report-wrapper .inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        flex-wrap: wrap;
    }

    .action-bar .btn {
        border-radius: 999px;
        font-weight: 600;
        padding: 0.55rem 1.35rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    }

    .action-bar .btn i {
        font-size: 1rem;
    }

    .action-bar .btn-success {
        background: #16a34a;
        border-color: #16a34a;
    }

    .action-bar .btn-danger {
        background: #ef4444;
        border-color: #ef4444;
    }

    .action-bar .btn-success:hover {
        background: #15803d;
        border-color: #15803d;
    }

    .action-bar .btn-danger:hover {
        background: #dc2626;
        border-color: #dc2626;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .card-surface {
        border: 1px solid var(--admin-border);
        background: var(--admin-card-bg);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        padding: 1.5rem;
    }

    .card-surface + .card-surface {
        margin-top: 0;
    }

    .filter-form .form-label {
        font-weight: 600;
        color: #0f172a;
    }

    .filter-form .form-select,
    .filter-form button {
        border-radius: 12px;
    }

    .filter-form button {
        padding: 0.65rem 1.5rem;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th {
        background: #0f172a;
        color: #fff;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.78rem;
        padding: 0.9rem 0.7rem;
    }

    .report-table td {
        padding: 0.85rem 0.7rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.9rem;
        color: #0f172a;
    }

    .report-table tbody tr:hover {
        background: rgba(37, 99, 235, 0.04);
    }

    .status-badge {
        border-radius: 999px;
        padding: 0.25rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-approved { background: rgba(5, 150, 105, 0.13); color: #047857; }
    .status-pending { background: rgba(245, 158, 11, 0.15); color: #92400e; }
    .status-rejected { background: rgba(220, 38, 38, 0.15); color: #b91c1c; }

    .table-action-btn {
        border-radius: 10px;
        padding: 0.35rem 0.8rem;
        font-weight: 600;
    }

    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.85rem;
        color: var(--admin-muted);
    }

    @media (max-width: 768px) {
        .action-bar {
            justify-content: flex-start;
        }
        .action-buttons {
            width: 100%;
        }
        .report-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="admin-report-wrapper">
    <div class="inner">
        <div class="action-bar">
            <div class="action-buttons">
                <a href="<?php echo e(route('admin.reports.export.excel', ['year' => $year, 'month' => $month, 'status' => $status])); ?>"
                    class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="<?php echo e(route('admin.reports.export.pdf', ['year' => $year, 'month' => $month, 'status' => $status])); ?>"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="card-surface">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <span class="fw-semibold text-uppercase text-muted small">Filters</span>
                <a href="<?php echo e(request()->url()); ?>" class="btn btn-link btn-sm text-decoration-none">Reset</a>
            </div>
            <form method="GET" class="row g-3 align-items-end filter-form">
                <div class="col-md-3">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($y); ?>" <?php echo e($y == $year ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>" <?php echo e($m == $month ? 'selected' : ''); ?>>
                                <?php echo e(\Carbon\Carbon::create()->month($m)->format('F')); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="pending" <?php echo e($status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="approved" <?php echo e($status === 'approved' ? 'selected' : ''); ?>>Approved</option>
                        <option value="rejected" <?php echo e($status === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto">Apply Filters</button>
                </div>
            </form>
        </div>

        <div class="card-surface">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <span class="fw-semibold text-uppercase text-muted small">Summary of Onboarding Requests</span>
                <span class="badge bg-primary rounded-pill px-3 py-2"><?php echo e(number_format($data->count())); ?> records</span>
            </div>
            <div class="table-responsive">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Teller ID</th>
                            <th>Refer ID</th>

                            <th>Store Name</th>
                            <th>serial pos</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($r->id); ?></td>
                                <td><?php echo e($r->teller_id ?? '—'); ?></td>
                                <td class="text-uppercase fw-semibold"><?php echo e($r->refer_code); ?></td>

                                <td><?php echo e($r->store_name); ?></td>
                                <td><?php echo e($r->pos_serial); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo e($r->approval_status); ?>">
                                        <?php echo e(ucfirst($r->approval_status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e(optional($r->created_at)->format('Y-m-d')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.onboarding.show', $r->id)); ?>"
                                       class="btn btn-sm btn-outline-primary table-action-btn">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No records found for the selected filters.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if($data->isEmpty()): ?>
            <div class="card-surface text-center text-muted">
                No reports to show for the selected criteria.
            </div>
        <?php endif; ?>

        <?php if($data instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
            <div class="pagination-wrap">
                <span>Showing <?php echo e($data->firstItem()); ?> - <?php echo e($data->lastItem()); ?> of <?php echo e($data->total()); ?> records</span>
                <?php echo e($data->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/reports/index.blade.php ENDPATH**/ ?>