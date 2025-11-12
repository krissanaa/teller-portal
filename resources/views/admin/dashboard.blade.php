@extends('layouts.admin')

@section('content')
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
        color: #4CAF50;
    }

    /* Enhanced Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
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
        padding: 28px 24px;
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
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        background: var(--icon-bg);
        color: var(--icon-color);
        flex-shrink: 0;
    }

    .stat-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .stat-count {
        font-size: 2.6rem;
        font-weight: 800;
        line-height: 1;
        color: var(--count-color);
        margin-bottom: 8px;
    }

    .stat-description {
        font-size: 0.8rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Total Card - Green Theme */
    .stat-card.total {
        --card-gradient: linear-gradient(90deg, #2D5F3F 0%, #4CAF50 100%);
        --icon-bg: #e8f5ec;
        --icon-color: #2D5F3F;
        --count-color: #2D5F3F;
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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .action-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 18px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .action-card:hover {
        border-color: #4CAF50;
        background: #f8fef9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #e8f5ec;
        color: #2D5F3F;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .action-info {
        flex: 1;
    }

    .action-title {
        font-weight: 700;
        color: #212529;
        margin: 0 0 4px 0;
        font-size: 0.95rem;
    }

    .action-subtitle {
        font-size: 1rem;
        color: #ffc107;
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
                            <div class="stat-count">{{ $total_pos }}</div>
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
                            <div class="stat-count">{{ $approved }}</div>
                            <div class="stat-description">
                                <i class="bi bi-check-circle"></i>
                                ອະນຸມັດແລ້ວ
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
                            <div class="stat-count">{{ $pending }}</div>
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
                            <div class="stat-count">{{ $rejected }}</div>
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
     <a href="{{ route('admin.onboarding.index') }}" class="action-card shortcut-card">
        <div class="action-icon">
            <i class="bi bi-hourglass-split"></i>

        </div>
        <div class="action-info">
            <h3 class="action-title">ຄຳຂໍລໍຖ້າອະນຸມັດ</h3>
            <p class="action-subtitle">{{ $pending }} ລາຍການ</p>
        </div>
    </a>
    <!-- 🔹 View All Requests -->
     <a href="{{ route('admin.reports.index') }}" class="action-card shortcut-card">
        <div class="action-icon">
            <i class="bi bi-list-ul"></i>
        </div>
        <div class="action-info">
            <h3 class="action-title">ລາຍງານທັງໝົດ</h3>

        </div>
    </a>



    <!-- 🔹 Manage Users -->
     <a href="{{ route('admin.users.index') }}" class="action-card shortcut-card">
        <div class="action-icon">
            <i class="bi bi-people"></i>
        </div>
        <div class="action-info">
            <h3 class="action-title">ຈັດການຜູ້ໃຊ້</h3>

        </div>
    </a>

    <!-- 🔹 Manage Branches -->
    <a href="{{ route('admin.branches.index') }}" class="action-card shortcut-card">

        <div class="action-icon">
            <i class="bi bi-building"></i>
        </div>
        <div class="action-info">
            <h3 class="action-title">ຈັດການເພີ່ມສາຂາ</h3>

        </div>
    </a>

    <!-- 🔹 Extra Placeholder Card -->
    <a href="#" class="action-card shortcut-card">
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
@endsection
