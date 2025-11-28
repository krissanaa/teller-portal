<?php $__env->startSection('title', 'Teller Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    :root {
        --apb-primary: #14b8a6;
        /* Tailwind Teal 500 */
        --apb-secondary: #0f766e;
        /* darker teal */
        --apb-dark: #0d5c56;
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
        color: rgb(0, 0, 0);
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
        background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
        border: none;
        color: white;
        padding: 11px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
        background: linear-gradient(90deg, var(--apb-secondary) 0%, var(--apb-dark) 100%);
        color: white;
    }

    .btn-report {
        background: linear-gradient(90deg, var(--apb-accent) 0%, rgba(20, 184, 166, 0.8) 100%);
        border: none;
        color: #ffffff;
        padding: 11px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.35);
        background: linear-gradient(90deg, rgba(45, 212, 191, 0.9) 0%, rgba(14, 165, 156, 0.95) 100%);
        color: #ffffff;
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header-custom {
        background: #f8f9fa;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-weight: 700;
        color: #000000;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 1.1rem;
    }

    .card-badge {
        background: #ffc107;
        color: #000;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .modern-table {
        margin-bottom: 0;
    }

    .modern-table thead {
        background: #f8f9fa;
    }

    .modern-table thead th {
        padding: 14px 16px;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 1rem;
        letter-spacing: 0.5px;
        color: #000000;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
    }

    .modern-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .store-name {
        color: #000000;
        font-weight: 600;
    }

    .reference-code {
        background: #f8f9fa;
        color: #212529;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
        display: inline-flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
        text-transform: uppercase;
        min-width: 110px;
    }

    .status-note {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: none;
        color: #0d6efd;
    }

    .status-note a {
        color: inherit;
        text-decoration: none;
    }

    .status-note a:hover {
        text-decoration: underline;
    }

    .status-badge.rejected {
        background: #fdecea;
        border-color: #f5c2c7;
        color: #b02a37;
    }

    .remark-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        background: #f8f9fa;
        border: 1px dashed #ced4da;
        font-size: 0.85rem;
        color: #495057;
    }

    .btn-resubmit {
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 4px;
        margin-top: 1rem;
    }

    .pagination .page-link {
        color: #2d5f3f;
        border-radius: 6px;
    }

    .pagination .page-link:hover {
        background: #ffffff;
        color: rgb(0, 0, 0);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .page-header h4 {
            font-size: 1.3rem;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions a {
            flex: 1;
            justify-content: center;
        }

        .modern-table {
            font-size: 0.85rem;
        }

        .modern-table thead th {
            font-size: 0.75rem;
            padding: 10px 8px;
        }

        .modern-table tbody td {
            padding: 10px 8px;
        }
    }
</style>

<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="page-header">
        <h4>
            <i class="bi bi-speedometer2"></i>
            ໜ້າຫຼັກ
        </h4>
        <div class="header-actions">
            <a href="<?php echo e(route('teller.requests.create')); ?>" class="btn-create">
                <i class="bi bi-plus-circle"></i>
                ສ້າງຟອມໃໝ່
            </a>
            <a href="<?php echo e(route('teller.report')); ?>" class="btn-report">
                <i class="bi bi-graph-up"></i>
                ລາຍງານ
            </a>
        </div>
    </div>

    <!-- Pending + Rejected Requests Table -->
    <div class="dashboard-card">
        <div class="card-header-custom">
            <div class="card-title">
                <i class="bi bi-clock-history"></i>
                ຟອມທີ່ລໍຖ້າດຳເນີນການ
            </div>
            <span class="card-badge">
                <?php echo e($requests->total()); ?> ລາຍການ
            </span>
        </div>

        <div class="table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>

                        <th>ລະຫັດອ້າງອີງ</th>
                        <th>ລະຫັດເຄື່ອງ POS</th>
                        <th>ຊື່ຮ້ານຄ້າ</th>
                        <th>ປະເພດທຸລະກິດ</th>

                        <th>ວັນທີຕິດຕັ້ງ</th>

                        <th>ໝາຍເຫດ</th>
                        <th width="120" class="text-center">ສະຖານະ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="table-row-clickable" data-href="<?php echo e(route('teller.requests.show', $r->id)); ?>">

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
                        <td>
                            <span class="store-name">
                                <i class="bi bi-shop text-muted me-1"></i>
                                <?php echo e($r->store_name); ?>

                            </span>
                        </td>
                        <td>
                            <span class="store-name">
                                <?php echo e($r->business_type); ?>

                            </span>
                        </td>

                        <td>
                            <span class="store-name">
                                <i class="bi bi-calendar3 text-muted"></i>
                                <?php echo e($r->installation_date); ?>

                            </span>
                        </td>


                        <td>
                            <span class="store-name text-danger fw-semibold">
                                <?php echo e($r->admin_remark); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge <?php echo e($r->approval_status === 'rejected' ? 'rejected' : ''); ?>">
                                <?php
                                $statusLabel = match ($r->approval_status) {
                                'pending' => 'ລໍຖ້າອະນຸມັດ',
                                'approved' => 'ອະນຸມັດ',
                                'rejected' => 'ປະຕິເສດ',
                                default => ucfirst($r->approval_status),
                                };
                                ?>
                                <?php echo e($statusLabel); ?>

                                <?php if($r->approval_status === 'rejected'): ?>
                                <span class="status-note">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <a href="<?php echo e(route('teller.requests.edit', $r->id)); ?>" class="resubmit-link">
                                        Resubmit
                                    </a>
                                </span>
                                <?php endif; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>ບໍ່ມີຂໍ້ມູນ
                        </td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <?php if($requests->hasPages()): ?>
        <div class="pagination-wrapper text-center mt-4">
            <?php echo e($requests->links('vendor.pagination.custom')); ?>

        </div>
        <?php endif; ?>
    </div>


</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(() => window.location.reload(), 300000);

        document.querySelectorAll('.table-row-clickable').forEach(row => {
            row.addEventListener('click', () => {
                window.location.href = row.dataset.href;
            });
        });

        document.querySelectorAll('.resubmit-link').forEach(link => {
            link.addEventListener('click', (event) => event.stopPropagation());
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/dashboard.blade.php ENDPATH**/ ?>