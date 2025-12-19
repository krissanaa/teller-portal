<?php $__env->startSection('title', 'ລາຍງານຮ້ານຄ້າຂອງຂ້ອຍ'); ?>

<?php $__env->startSection('content'); ?>
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    /* Use layout background to match dashboard/nav */
    body {
        background: inherit;
    }

    :root {
        --apb-primary: #14b8a6;
        /* Tailwind Teal 500 */
        --apb-secondary: #0f766e;
        /* darker teal */
        --apb-dark: #0d5c56;
    }

    .report-shell {
        max-width: 1180px;
        margin: 0 auto;
    }


    .page-header {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h4 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-create {
        background: rgb(255, 255, 255);
        border: 2px solid #ff0000;
        color: #1e293b;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .btn-create:hover {
        background: #ff0000;
        border: 2px solid #ff0000;
        color: #ffffff;
        transform: translateY(-2px);
    }






    /* Compact Status Cards */
    .status-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .status-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .status-card-body {
        padding: 14px 10px;
        text-align: center;
    }

    .status-icon {
        font-size: 1.8rem;
        margin-bottom: 6px;
        display: block;
    }

    .status-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 4px;
        color: #475569;
    }

    .status-count {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1;
        color: #1e293b;
    }

    /* Color borders */
    .status-card.pending {
        border-left: 4px solid #ffc107;
    }

    .status-card.approved {
        border-left: 4px solid #28a745;
    }

    .status-card.rejected {
        border-left: 4px solid #dc3545;
    }

    /* Make cards more compact on mobile */
    @media (max-width: 768px) {
        .status-card-body {
            padding: 12px 6px;
        }

        .status-icon {
            font-size: 1.5rem;
        }

        .status-count {
            font-size: 1.4rem;
        }
    }


    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
    }

    .filter-title {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
    }

    .filter-title i {
        color: var(--apb-accent);
    }

    .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0f2fe;
        color: #075985;
        border: 1px solid #bae6fd;
        border-radius: 999px;
        padding: 6px 12px;
        font-weight: 700;
        font-size: 0.82rem;
    }

    .search-input,
    .filter-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 11px 14px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .search-input:focus,
    .filter-select:focus {
        border-color: var(--apb-accent);
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
    }

    .btn-reset {
        background: white;
        border: 1px solid #ced4da;
        color: #475569;
        border-radius: 8px;
        padding: 11px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #1e293b;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header {
        background: #f8f9fa;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-header-title {
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
    }

    .table-count {
        background: #ffc107;
        color: #1f2933;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .modern-table {
        margin-bottom: 0;
        width: 98%;
        margin: 0 auto;
    }

    .modern-table thead {
        background: #f8f9fa;
    }

    .modern-table thead th {
        padding: 14px 16px;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        color: #475569;
        white-space: nowrap;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
    }

    .modern-table tbody tr:hover {
        background-color: #e6fffa !important;
        box-shadow: inset 0 1px 0 #e2e8f0, inset 0 -1px 0 #e2e8f0 !important;
    }

    .modern-table tbody tr:hover td {
        background-color: transparent !important;
    }

    .modern-table tbody tr:hover td:first-child {
        border-left: 3px solid var(--apb-primary);
    }

    .modern-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.9375rem;
        color: #334155;
    }

    .store-name {
        color: #1e293b;
        font-weight: 600;
    }

    .reference-code {
        background: #f8f9fa;
        color: #334155;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    /* Status Badges */
    .badge-status {
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .badge-status.pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
    }

    .badge-status.pending:hover {
        background: #ffc107;
        color: #000;
    }

    .badge-status.approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #28a745;
    }

    .badge-status.approved:hover {
        background: #28a745;
        color: white;
    }

    .badge-status.rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #dc3545;
    }

    .badge-status.rejected:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .status-card-body {
            padding: 16px;
        }

        .status-count {
            font-size: 2rem;
        }
    }

    /* Pagination Styling */
    .pagination svg,
    .apb-pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    .pagination,
    .apb-pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 1.5rem;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
    }

    .pagination .page-item,
    .apb-pagination .page-item {
        margin: 0;
    }

    .pagination .page-link,
    .apb-pagination .page-link {
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
        text-decoration: none;
        display: block;
    }

    .pagination .page-link:hover,
    .apb-pagination .page-link:hover {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
    }

    .pagination .page-item.active .page-link,
    .apb-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.4);
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link,
    .apb-pagination .page-item.disabled .page-link {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
    }

    .pagination .page-item.disabled .page-link:hover,
    .apb-pagination .page-item.disabled .page-link:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        transform: none;
        box-shadow: none;
    }

    /* ปุ่ม Filter Date */
    .date-filter-btn {
        border: 1px solid #ced4da;
        background: white;
        padding: 11px 14px;
        border-radius: 8px;
        font-weight: 600;
        color: #333;
        transition: 0.2s ease;
    }

    /* ❌ เอา hover ออก (ไม่ต้องมีเอฟเฟกต์ตอนเอาเมาส์ไปวาง) */
    .date-filter-btn:hover {
        background: white !important;
        border-color: #ced4da !important;
        color: #333 !important;
    }

    /* ✔ Focus/Active ยังเป็นสีเขียว */
    .date-filter-btn:focus,
    .date-filter-btn:active,
    .date-filter-btn.show {
        border-color: var(--apb-accent) !important;
        box-shadow: 0 0 0 0.15rem rgba(76, 175, 80, 0.25) !important;
        color: var(--apb-accent) !important;
    }

    .date-filter-btn:focus i,
    .date-filter-btn:active i,
    .date-filter-btn.show i {
        color: var(--apb-accent) !important;
    }

    /* ทำให้ select + filter date button มี font-size เท่ากัน */
    .filter-size-unify {
        font-size: 0.9rem !important;
    }
</style>

<div class="report-shell container-fluid py-3">
    <!-- Page Header -->
    <div class="page-header">
        <i class="bi bi-graph-up-arrow"></i>
        <?php echo e(Auth::user()->isBranchAdmin() ? 'ລາຍງານສາຂາ (Branch Report)' : 'ລາຍງານຮ້ານຄ້າຂອງຂ້ອຍ'); ?>

        </h4>
        <div class="header-actions">
            <a href="<?php echo e(route('teller.dashboard')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                ກັບໜ້າຫຼັກ
            </a>

        </div>
    </div>

    <?php
    $tellerIdentifier = Auth::user()->teller_id ?? Auth::id();
    ?>

    <!-- Status Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('teller.report', ['status' => 'pending'])); ?>" class="status-card pending">
                <div class="status-card-body">
                    <span class="status-icon">⏳</span>
                    <div class="status-label">ລໍຖ້າອະນຸມັດ</div>
                    <div class="status-count">
                        <?php echo e($statusCounts['pending'] ?? 0); ?>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('teller.report', ['status' => 'approved'])); ?>" class="status-card approved">
                <div class="status-card-body">
                    <span class="status-icon">✅</span>
                    <div class="status-label">ອະນຸມັດ</div>
                    <div class="status-count">
                        <?php echo e($statusCounts['approved'] ?? 0); ?>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('teller.report', ['status' => 'rejected'])); ?>" class="status-card rejected">
                <div class="status-card-body">
                    <span class="status-icon">❌</span>
                    <div class="status-label">ປະຕິເສດ</div>
                    <div class="status-count">
                        <?php echo e($statusCounts['rejected'] ?? 0); ?>

                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Search & Filter -->

    <div class="filter-card">
        <div class="filter-title">
            <i class="bi bi-funnel-fill"></i>
            ຕົວfilter
        </div>
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-search"></i> ຄົ້ນຫາ
                </label>
                <input type="text" name="search" value="<?php echo e($search); ?>"
                    class="form-control form-control-sm search-input filter-size-unify fw-semibold"
                    placeholder="ຊື່ຮ້ານ, ລະຫັດອ້າງອີງ, POS, ເລກບັນຊີ..."
                    onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-calendar2-range"></i> ວັນທີເລີ່ມຕົ້ນ
                </label>
                <input type="date" name="day" value="<?php echo e($day); ?>"
                    class="form-control form-control-sm filter-select filter-size-unify"
                    onchange="this.form.submit()">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-calendar2-range"></i> ວັນທີສິ້ນສຸດ
                </label>
                <input type="date" name="end_day" value="<?php echo e($endDay ?? ''); ?>"
                    class="form-control form-control-sm filter-select filter-size-unify"
                    onchange="this.form.submit()">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-filter"></i> ສະຖານະ
                </label>
                <select name="status" class="form-select form-select-sm filter-select text-muted fw-semibold filter-size-unify"
                    onchange="this.form.submit()">
                    <option value="">ທຸກສະຖານະ</option>
                    <option value="pending" <?php echo e($status=='pending' ? 'selected' : ''); ?>>ລໍຖ້າອະນຸມັດ</option>
                    <option value="approved" <?php echo e($status=='approved' ? 'selected' : ''); ?>>ອະນຸມັດ</option>
                    <option value="rejected" <?php echo e($status=='rejected' ? 'selected' : ''); ?>>ປະຕິເສດ</option>
                </select>
            </div>
            <?php if(Auth::user()->isBranchAdmin()): ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-diagram-3"></i> ສາຂາ (Branch)
                </label>
                <?php $selectedBranchId = Auth::user()->branch_id; ?>
                <input type="hidden" name="branch_id" value="<?php echo e($selectedBranchId); ?>">
                <select class="form-select form-select-sm filter-select text-muted fw-semibold filter-size-unify bg-light" disabled>
                    <option selected>
                        <?php echo e($branches->firstWhere('id', $selectedBranchId)->BRANCH_NAME ?? $branches->firstWhere('id', $selectedBranchId)->name ?? 'Branch '.$selectedBranchId); ?>

                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-diagram-2"></i> ໜ່ວຍ (Unit)
                </label>
                <?php
                $unitsByBranch = collect($branches)->keyBy('id')->map->units;
                $currentUnits = $unitsByBranch[$selectedBranchId] ?? collect();
                ?>
                <select name="unit_id" class="form-select form-select-sm filter-select text-muted fw-semibold filter-size-unify"
                    onchange="this.form.submit()">
                    <option value="">
                        <?php echo e($branches->firstWhere('id', $selectedBranchId)->BRANCH_NAME ?? $branches->firstWhere('id', $selectedBranchId)->name ?? 'Branch '.$selectedBranchId); ?>

                    </option>
                    <option value="all" <?php echo e($unitId == 'all' ? 'selected' : ''); ?>>ເບິ່ງທັງໝົດ (View All)</option>
                    <?php $__currentLoopData = $currentUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unit->id); ?>" <?php echo e($unitId == $unit->id ? 'selected' : ''); ?>>
                        <?php echo e($unit->unit_name ?? $unit->name ?? ('Unit '.$unit->id)); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small mb-1">
                    <i class="bi bi-person-badge"></i> ພະນັກງານ (Teller)
                </label>
                <select name="teller_id" class="form-select form-select-sm filter-select text-muted fw-semibold filter-size-unify"
                    onchange="this.form.submit()">
                    <option value="">---</option>

                    <?php $__currentLoopData = $tellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($teller->teller_id); ?>" <?php echo e(($tellerId ?? '') == $teller->teller_id ? 'selected' : ''); ?>>
                        <?php echo e($teller->name ?? $teller->teller_id); ?> (<?php echo e($teller->teller_id ?? $teller->id); ?>)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search"></i> Search
                </button>
                <a href="<?php echo e(route('teller.report')); ?>" class="btn btn-secondary btn-sm w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div><!-- Data Table -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-header-title">
                <i class="bi bi-table"></i> ຂໍ້ມູນທັງໝົດ
            </span>
            <span class="table-count"><?php echo e($data->total()); ?> ລາຍການ</span>
        </div>
        <div class="table-responsive p-1"> <!-- Added p-1 to fix hover scroll glitch -->
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th width="60">ລຳດັບ</th>
                        <th>ຊື່ຮ້ານຄ້າ</th>
                        <th>ປະເພດທຸລະກິດ</th>
                        <?php if(Auth::user()->isBranchAdmin()): ?>
                        <th>ສາຂາ / ໜ່ວຍ (Branch / Unit)</th>
                        <?php endif; ?>
                        <th>ລະຫັດອ້າງອີງ</th>
                        <th>ລະຫັດເຄື່ອງ pos</th>
                        <th style="width: 110px;">ວັນທີໄປຕິດຕັ້ງ</th>
                        <th style="width: 110px;">ຜູ້ສ້າງ</th>
                        <th width="120" class="text-center">ສະຖານະ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="table-row-clickable" data-href="<?php echo e(route('teller.requests.show', $r->id)); ?>">
                        <td class="text-center fw-bold text-muted">
                            <?php echo e(($data->firstItem() ?? 0) + $loop->index); ?>

                        </td>
                        <td>
                            <span class="store-name">
                                <i class="bi bi-shop"></i>
                                <?php echo e($r->store_name); ?>

                            </span>
                        </td>
                        <td><?php echo e($r->business_type); ?></td>
                        <?php if(Auth::user()->isBranchAdmin()): ?>
                        <td>
                            <div class="d-flex flex-column small">
                                <span class="fw-semibold text-primary">
                                    <?php echo e($r->branch->BRANCH_NAME ?? $r->branch_id); ?>

                                </span>
                                <?php if($r->unit): ?>
                                <span class="text-muted text-xs">
                                    <i class="bi bi-diagram-2"></i> <?php echo e($r->unit->unit_name ?? $r->unit_id); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <?php endif; ?>
                        <td>
                            <span class="reference-code">
                                <i class="bi bi-hash"></i><?php echo e($r->refer_code); ?>

                            </span>
                        </td>
                        <td>
                            <span class="store-name">
                                <i class="bi bi-computer text-muted"></i>
                                <?php echo e($r->pos_serial ?: '-'); ?>

                            </span>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($r->installation_date)->format('d/m/Y')); ?></td>
                        <td>
                            <div class="d-flex flex-column small">
                                <span class="fw-semibold"><?php echo e($r->teller->name ?? '-'); ?></span>
                                <span class="text-muted text-xs"><?php echo e($r->teller->teller_id ?? $r->teller_id); ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if($r->approval_status == 'approved'): ?>
                            <a href="<?php echo e(route('teller.report', ['status' => 'approved'])); ?>"
                                class="badge-status approved">
                                ອະນຸມັດ
                            </a>
                            <?php elseif($r->approval_status == 'pending'): ?>
                            <a href="<?php echo e(route('teller.report', ['status' => 'pending'])); ?>"
                                class="badge-status pending">
                                ລໍຖ້າອະນຸມັດ
                            </a>
                            <?php else: ?>
                            <a href="<?php echo e(route('teller.report', ['status' => 'rejected'])); ?>"
                                class="badge-status rejected">
                                ປະຕິເສດ
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr class="text-center">
                        <td colspan="<?php echo e(Auth::user()->isBranchAdmin() ? '9' : '8'); ?>" class="text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            ບໍ່ພົບຂໍ້ມູນ (No Data Found)
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Admin-Style Pagination -->
            <div class="position-relative mt-4 p-4 border-top">
                <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
                    <a href="<?php echo e(route('teller.dashboard')); ?>" class="btn btn-secondary">
                        <i class="bi bi-house"></i> ກັບໜ້າຫຼັກ
                    </a>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <div class="text-muted small mb-2">
                        <?php
                        $start = $data->firstItem() ?? 0;
                        $end = $data->lastItem() ?? 0;
                        $total = $data->total() ?? 0;
                        ?>

                    </div>
                    <div>
                        <?php if($data->hasPages()): ?>
                        <?php echo e($data->links('vendor.pagination.custom')); ?>

                        <?php else: ?>
                        <ul class="apb-pagination">
                            <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i class="bi bi-chevron-left"></i></span></li>
                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i class="bi bi-chevron-right"></i></span></li>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.table-row-clickable').forEach(row => {
            row.addEventListener('click', () => {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/report/index.blade.php ENDPATH**/ ?>