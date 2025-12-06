<?php $__env->startSection('title', 'Onboarding Requests'); ?>

<?php $__env->startSection('content'); ?>
<?php
$search = $search ?? '';
$start_date = $start_date ?? '';
$end_date = $end_date ?? '';
$status = $status ?? '';
$branch_id = $branch_id ?? '';
$unit_id = $unit_id ?? '';
$teller_id = $teller_id ?? '';
?>
<style>
    :root {
        --apb-primary: #14b8a6;
        --apb-secondary: #0f766e;
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
    }

    .report-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .card-surface {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Filter Form */
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
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
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.92rem;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background: var(--apb-secondary);
        transform: translateY(-1px);
    }

    .btn-reset {
        background: white;
        border: 1px solid #cbd5e1;
        color: #64748b;
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.92rem;
        transition: all 0.2s;
    }

    .btn-reset:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Table */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9375rem;
    }

    .report-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .report-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: #334155;
        vertical-align: middle;
    }

    .report-table tr:last-child td {
        border-bottom: none;
    }

    .report-table tr:hover {
        background: #f8fafc;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-badge.approved {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #d1fae5;
    }

    .status-badge.pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .status-badge.rejected {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    /* Export Buttons */
    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9375rem;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .export-excel {
        background: #10b981;
        color: white;
    }

    .export-excel:hover {
        background: #059669;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
    }

    .export-pdf {
        background: #ef4444;
        color: white;
    }

    .export-pdf:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);
    }

    /* Pagination - Teller Style */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid var(--border-color);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
    }

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

    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination-wrapper {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>

<div class="report-container">
    <!-- Filter Section -->
    <div class="card-surface">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold text-dark">Filters</h5>
            <div class="d-flex gap-3">
                <a href="<?php echo e(route('admin.reports.export.excel', request()->query())); ?>" class="export-btn export-excel">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="<?php echo e(route('admin.reports.export.pdf', request()->query())); ?>" class="export-btn export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>
        <form method="GET" action="<?php echo e(route('admin.reports.index')); ?>">
            <div class="filter-grid">
                <!-- Search -->
                <div>
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Store, Refer Code, POS..." value="<?php echo e($search); ?>">
                </div>

                <!-- Date Range -->
                <div>
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e($start_date); ?>">
                </div>
                <div>
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e($end_date); ?>">
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="approved" <?php echo e($status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                        <option value="rejected" <?php echo e($status == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    </select>
                </div>

                <!-- Branch -->
                <div>
                    <label class="form-label">Branch</label>
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" <?php echo e($branch_id == $branch->id ? 'selected' : ''); ?>>
                            <?php echo e($branch->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Unit -->
                <div>
                    <label class="form-label">Unit</label>
                    <select name="unit_id" class="form-select">
                        <option value="">All Units</option>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>" <?php echo e($unit_id == $unit->id ? 'selected' : ''); ?>>
                            <?php echo e($unit->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Teller -->
                <div>
                    <label class="form-label">Teller</label>
                    <select name="teller_id" class="form-select">
                        <option value="">All Tellers</option>
                        <?php $__currentLoopData = $tellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($teller->id); ?>" <?php echo e($teller_id == $teller->id ? 'selected' : ''); ?>>
                            <?php echo e($teller->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-filter w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn-reset w-100 text-center text-decoration-none">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card-surface p-0 overflow-hidden">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
            <span class="fw-bold text-dark">
                <i class="bi bi-list-ul me-2"></i> Report Data
            </span>
            <span class="badge bg-primary rounded-pill px-3 py-2">
                <?php echo e($data->total()); ?> Records Found
            </span>
        </div>
        <div class="table-responsive border-0 rounded-0">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Store Name</th>
                        <th>Branch / Unit</th>
                        <th>Teller</th>
                        <th>Refer Code</th>
                        <th>POS Serial</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <?php
                        // Sequential row number (1-based), falls back to index if pagination data is missing
                        $rowNumber = $data->firstItem() ? $data->firstItem() + $loop->index : $loop->index + 1;
                        ?>
                        <td class="fw-bold text-muted">#<?php echo e($rowNumber); ?></td>
                        <td><?php echo e($row->created_at->format('M d, Y')); ?></td>
                        <td class="fw-semibold"><?php echo e($row->store_name); ?></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-medium"><?php echo e(optional($row->branch)->name ?? '-'); ?></span>
                                <small class="text-muted"><?php echo e(optional($row->unit)->name ?? '-'); ?></small>
                            </div>
                        </td>
                        <td><?php echo e(optional($row->teller)->name ?? $row->teller_id); ?></td>
                        <td class="font-monospace text-primary"><?php echo e($row->refer_code); ?></td>
                        <td><?php echo e($row->pos_serial ?? '-'); ?></td>
                        <td>
                            <span class="status-badge <?php echo e($row->approval_status); ?>">
                                <?php if($row->approval_status == 'approved'): ?> <i class="bi bi-check-circle-fill"></i>
                                <?php elseif($row->approval_status == 'pending'): ?> <i class="bi bi-clock-fill"></i>
                                <?php else: ?> <i class="bi bi-x-circle-fill"></i>
                                <?php endif; ?>
                                <?php echo e(ucfirst($row->approval_status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.onboarding.show', $row->id)); ?>" class="btn btn-sm btn-outline-primary fw-bold">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-inbox fs-1 opacity-50"></i>
                                <p class="mb-0">No records found matching your filters.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($data->hasPages()): ?>
        <div class="position-relative mt-3 p-3 border-top">
            <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-danger">
                    <i class="bi bi-house"></i> Back to Home
                </a>
            </div>
            <div class="d-flex flex-column align-items-end">
                <div class="text-muted small mb-2">
                    Showing <?php echo e($data->firstItem()); ?> to <?php echo e($data->lastItem()); ?> of <?php echo e($data->total()); ?> results
                </div>
                <div>
                    <?php echo e($data->links('vendor.pagination.custom')); ?>

                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center mt-3 p-3 border-top">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-danger">
                <i class="bi bi-house"></i> Back to Home
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/reports/index.blade.php ENDPATH**/ ?>