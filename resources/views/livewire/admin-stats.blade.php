<div>
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
            <a href="{{ route('admin.onboarding.index') }}" class="action-card shortcut-card" style="position: relative;">
                <div class="action-icon">
                    <i class="bi bi-hourglass-split"></i>

                </div>
                <div class="action-info">
                    <h3 class="action-title">ຄຳຂໍລໍຖ້າອະນຸມັດ</h3>
                    <p class="action-subtitle" id="pending-count-text">{{ $pending }} ລາຍການ</p>
                </div>
                @if($pending > 0)
                <span class="menu-badge" id="menu-pending-badge">{{ $pending }}</span>
                @endif
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
            <a href="{{ route('admin.users.index') }}" class="action-card shortcut-card" style="position: relative;">
                <div class="action-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="action-info">
                    <h3 class="action-title">ຈັດການຜູ້ໃຊ້</h3>
                    @if($pending_users > 0)
                    <p class="action-subtitle">{{ $pending_users }} ລໍຖ້າອະນຸມັດ</p>
                    @endif
                </div>
                @if($pending_users > 0)
                <span class="menu-badge" id="menu-pending-users-badge">{{ $pending_users }}</span>
                @endif
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
            <a href="{{ route('admin.logs.index') }}" class="action-card shortcut-card">
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