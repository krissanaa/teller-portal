<?php $__env->startSection('content'); ?>
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }


    /* Page Section */
    .page-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        color: #212529;
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #14b8a6;
    }

    /* Enhanced Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid #e4e8ee;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--card-gradient);
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-card-body {
        padding: 18px 16px;
    }

    .stat-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-info {
        flex: 1;
    }

    .stat-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        background: var(--icon-bg);
        color: var(--icon-color);
        flex-shrink: 0;
    }

    .stat-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .stat-count {
        font-size: 1.9rem;
        font-weight: 800;
        line-height: 1;
        color: var(--count-color);
        margin-bottom: 8px;
    }

    .stat-description {
        font-size: 0.7rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Total Card - Green Theme */
    .stat-card.total {
        --card-gradient: linear-gradient(90deg, #0f766e 0%, #14b8a6 100%);
        --icon-bg: #ecfdf5;
        --icon-color: #0f766e;
        --count-color: #0f766e;
    }

    /* Approved Card */
    .stat-card.approved {
        --card-gradient: linear-gradient(90deg, #28a745 0%, #66BB6A 100%);
        --icon-bg: #d4edda;
        --icon-color: #28a745;
        --count-color: #28a745;
    }

    /* Pending Card */
    .stat-card.pending {
        --card-gradient: linear-gradient(90deg, #ffc107 0%, #FFD54F 100%);
        --icon-bg: #fff3cd;
        --icon-color: #ffc107;
        --count-color: #ffc107;
    }

    /* Rejected Card */
    .stat-card.rejected {
        --card-gradient: linear-gradient(90deg, #dc3545 0%, #E57373 100%);
        --icon-bg: #f8d7da;
        --icon-color: #721c24;
        --count-color: #dc3545;
    }

    /* Quick Actions */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 14px;
        margin-top: 20px;
    }

    .action-card {
        background: white;
        border: 1px solid #e0e6ef;
        border-radius: 14px;
        padding: 12px 18px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 18px;
        min-height: 74px;
    }

    .action-card:hover {
        border-color: #14b8a6;
        background: #e6fffa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
    }

    .action-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #e8f5ec;
        color: #0f766e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .action-info {
        flex: 1;
    }

    .action-title {
        font-weight: 700;
        color: #212529;
        margin: 0 0 2px 0;
        font-size: 0.9rem;
    }

    .action-subtitle {
        font-size: 0.78rem;
        color: #6c757d;
        margin: 0;
    }

    @media (max-width: 768px) {
        .admin-top-header {
            margin: -15px -15px 20px -15px;
            padding: 16px 20px;
        }

        .header-left {
            width: 100%;
        }

        .header-title h1 {
            font-size: 1.4rem;
        }

        .user-info {
            display: none;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-count {
            font-size: 2rem;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 769px) and (max-width: 991px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Stats Overview Section -->
<div class="page-section">
    <h2 class="section-title">
        <i class="bi bi-bar-chart-fill"></i>
        ພາບລວມສະຖິຕິ
    </h2>

    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-card-body">
                <div class="stat-header">
                    <div class="stat-info">
                        <div class="stat-label">Total POS</div>
                        <div class="stat-count"><?php echo e($total_pos); ?></div>
                        <div class="stat-description">
                            <i class="bi bi-graph-up"></i>
                            ທັງໝົດໃນລະບົບ
                        </div>
                    </div>
                    <div class="stat-icon-box">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card approved">
            <div class="stat-card-body">
                <div class="stat-header">
                    <div class="stat-info">
                        <div class="stat-label">Approved</div>
                        <div class="stat-count"><?php echo e($approved); ?></div>
                        <div class="stat-description">
                            <i class="bi bi-check-circle"></i>
                            ອະນຸມັດ
                        </div>
                    </div>
                    <div class="stat-icon-box">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card pending">
            <div class="stat-card-body">
                <div class="stat-header">
                    <div class="stat-info">
                        <div class="stat-label">Pending</div>
                        <div class="stat-count"><?php echo e($pending); ?></div>
                        <div class="stat-description">
                            <i class="bi bi-clock"></i>
                            ລໍຖ້າອະນຸມັດ
                        </div>
                    </div>
                    <div class="stat-icon-box">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card rejected">
            <div class="stat-card-body">
                <div class="stat-header">
                    <div class="stat-info">
                        <div class="stat-label">Rejected</div>
                        <div class="stat-count"><?php echo e($rejected); ?></div>
                        <div class="stat-description">
                            <i class="bi bi-x-circle"></i>
                            ປະຕິເສດ
                        </div>
                    </div>
                    <div class="stat-icon-box">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="page-section">
    <h2 class="section-title">
        <i class="bi bi-lightning-charge-fill"></i>
        ການດຳເນີນການດ່ວນ
    </h2>


    <div class="quick-actions-grid">
        <!-- 🔹 Pending Approvals -->
        <a href="<?php echo e(route('admin.onboarding.index')); ?>" class="action-card shortcut-card">
            <div class="action-icon">
                <i class="bi bi-hourglass-split"></i>

            </div>
            <div class="action-info">
                <h3 class="action-title">ຄຳຂໍລໍຖ້າອະນຸມັດ</h3>
                <p class="action-subtitle"><?php echo e($pending); ?> ລາຍການ</p>
            </div>
        </a>
        <!-- 🔹 View All Requests -->
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="action-card shortcut-card">
            <div class="action-icon">
                <i class="bi bi-list-ul"></i>
            </div>
            <div class="action-info">
                <h3 class="action-title">ລາຍງານທັງໝົດ</h3>

            </div>
        </a>



        <!-- 🔹 Manage Users -->
        <a href="<?php echo e(route('admin.users.index')); ?>" class="action-card shortcut-card">
            <div class="action-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="action-info">
                <h3 class="action-title">ຈັດການຜູ້ໃຊ້</h3>

            </div>
        </a>

        <!-- 🔹 Manage Branches -->
        <a href="<?php echo e(route('admin.branches.index')); ?>" class="action-card shortcut-card">

            <div class="action-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="action-info">
                <h3 class="action-title">ຈັດການເພີ່ມສາຂາ</h3>

            </div>
        </a>

        <!-- 🔹 Extra Placeholder Card -->
        <a href="<?php echo e(route('admin.logs.index')); ?>" class="action-card shortcut-card">
            <div class="action-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="action-info">
                <h3 class="action-title">log</h3>

            </div>
        </a>
    </div>

</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(() => window.location.reload(), 300000);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>