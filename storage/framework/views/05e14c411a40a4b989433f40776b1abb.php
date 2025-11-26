<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'APB Bank - Teller Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Noto Sans Lao Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700;800&family=Noto+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --apb-primary: #0f766e;
            --apb-secondary: #0d5c56;
            --apb-accent: #14b8a6;
            --apb-dark: #0b3f3a;
        }

        * {
            font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* 🏦 Modern Navbar */
        .navbar-apb {
            background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .navbar-brand i {
            font-size: 1.6rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-name {
            font-size: 1.4rem;
            font-weight: 800;
        }

        .brand-subtitle {
            font-size: 0.7rem;
            opacity: 0.9;
            font-weight: 400;
            letter-spacing: 1px;
        }

        /* 🔔 Notification Button */
        .notification-btn {
            position: relative;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 8px 14px;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .notification-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .notification-btn i {
            font-size: 1.2rem;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #DC3545;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            border: 2px solid var(--apb-primary);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* 👤 Profile Section */
        .profile-section {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 6px 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .profile-section:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .profile-name {
            color: white;
            font-weight: 600;
            margin: 0;
            font-size: 0.9rem;
        }

        .profile-role {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.7rem;
            margin: 0;
        }

        .profile-icon {
            width: 36px;
            height: 36px;
            background: white;
            color: var(--apb-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .profile-arrow {
            color: white;
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .dropdown.show .profile-arrow {
            transform: rotate(180deg);
        }

        /* 📋 Dropdown Menu - Clean White Style */
        .dropdown-menu {
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 8px;
            margin-top: 12px;
            min-width: 280px;
        }

        .dropdown-header {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 6px;
            font-weight: 700;
            color: #212529;
            font-size: 0.85rem;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            color: #212529;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #212529;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
            color: #6c757d;
        }

        .notification-item {
            padding: 10px;
            margin-bottom: 6px;
            border-radius: 6px;
            background: #f8f9fa;
            border-left: 3px solid #dee2e6;
        }

        .notification-item.approved {
            border-left-color: #28a745;
            background: #f1f9f3;
        }

        .notification-item.rejected {
            border-left-color: #dc3545;
            background: #fef2f2;
        }

        .notification-store {
            font-weight: 700;
            color: #212529;
            font-size: 0.9rem;
        }

        .notification-status {
            font-weight: 600;
            margin: 4px 0;
            font-size: 0.85rem;
        }

        .notification-remark {
            font-size: 0.78rem;
            color: #495057;
            margin: 4px 0;
            display: flex;
            gap: 6px;
            align-items: flex-start;
        }

        .notification-remark i {
            color: #0d6efd;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* 🍞 Toast Messages */
        .toast {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: none;
            min-width: 300px;
        }

        /* 🎨 Modal Styling - Clean White */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
            border-radius: 12px 12px 0 0;
            padding: 18px 22px;
            border: none;
        }

        .modal-title {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .modal-body {
            padding: 22px;
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: #212529;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px 14px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--apb-accent);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
            border: none;
            color: white;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
            background: linear-gradient(90deg, var(--apb-secondary) 0%, var(--apb-dark) 100%);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            color: white;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .logout-btn {
            color: #dc3545 !important;
            font-weight: 600;
        }

        .profile-unit-preview {
            border: 1px dashed rgba(45, 95, 63, 0.35);
            border-radius: 12px;
            padding: 12px;
            background: rgba(248, 255, 251, 0.65);
        }

        .profile-unit-preview-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .profile-unit-preview-item {
            flex: 1 1 45%;
            min-width: 140px;
            background: white;
            border-radius: 10px;
            padding: 10px;
            border: 1px solid rgba(45, 95, 63, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .profile-unit-preview-item strong {
            display: block;
            color: #1a3321;
        }

        .profile-unit-preview-item span {
            display: block;
            color: #5c6d63;
            font-size: 0.82rem;
        }

        .profile-id-modal .modal-dialog {
            max-width: 560px;
        }

        .profile-card {
            border-radius: 28px;
            border: 1px solid rgba(15, 118, 110, 0.18);
            background: #f4fffb;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 118, 110, 0.2);
        }

        .profile-card-header {
            background: linear-gradient(115deg, #0f766e, #14b8a6);
            color: #fff;
            padding: 18px 28px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .profile-card-avatar {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            font-weight: 700;
        }

        .profile-card-title h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .profile-card-title span {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .profile-card-body {
            padding: 18px 24px 24px;
            background: linear-gradient(115deg, rgba(20, 184, 166, 0.08), rgba(15, 118, 110, 0.01));
        }

        .profile-card-grid {
            display: flex;
            gap: 16px;
        }

        .profile-card-field {
            flex: 1;
            background: white;
            border-radius: 16px;
            padding: 12px 16px;
            border: 1px solid rgba(15, 118, 110, 0.12);
        }

        .profile-card-field span {
            display: block;
            font-size: 0.78rem;
            text-transform: uppercase;
            color: #96a3b5;
            letter-spacing: 0.4px;
        }

        .profile-card-field strong {
            display: block;
            margin-top: 5px;
            font-size: 1rem;
            color: #0f172a;
        }

        @media (max-width: 576px) {
            .profile-card-grid {
                flex-direction: column;
            }
        }

        .profile-unit-preview-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: #fee !important;
        }

        /* 📱 Responsive */
        @media (max-width: 768px) {
            .brand-subtitle {
                display: none;
            }

            .profile-section {
                padding: 5px 10px;
            }

            .notification-btn {
                padding: 6px 10px;
            }
        }

        /* Animations */
        .animated--fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes popAndFade {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.5; }
            100% { transform: scale(0); opacity: 0; }
        }
        .navbar-apb .navbar-brand img {
  height: 50px;
  width: auto;
  transition: transform 0.2s ease;
}
.navbar-apb .navbar-brand:hover img {
  transform: scale(1.05);
}
.brand-text .brand-name {
  font-weight: 700;
  font-size: 1.05rem;
  color: #ffffff;
}
.brand-text .brand-subtitle {
  font-size: 0.8rem;
  color: #ffffff;
  font-size: 12px;

}

    </style>
</head>
<body>
<?php
    $tellerAuthUser = auth()->user();
    if ($tellerAuthUser) {
        $tellerAuthUser->loadMissing(['branch', 'unit']);
    }
    $profileErrorBag = session('errors') instanceof \Illuminate\Support\ViewErrorBag
        ? session('errors')->getBag('profileSetup')
        : null;
    $shouldShowProfileSetupModal = $tellerAuthUser && (
        is_null($tellerAuthUser->profile_completed_at) ||
        ($profileErrorBag?->any() ?? false)
    );
    $profilePrefillName = old('name');
    if ($profilePrefillName === null) {
        $profilePrefillName = $tellerAuthUser && $tellerAuthUser->profile_completed_at
            ? $tellerAuthUser->name
            : '';
    }
    $profilePrefillPhone = old('phone');
    if ($profilePrefillPhone === null) {
        $profilePrefillPhone = $tellerAuthUser && $tellerAuthUser->profile_completed_at
            ? $tellerAuthUser->phone
            : '';
    }
    $profileBranches = isset($profileBranches) ? $profileBranches : collect();
    $profileBranchUnitsPayload = $profileBranchUnitsPayload ?? [];
    $profilePrefillBranch = old('branch_id');
    if ($profilePrefillBranch === null) {
        $profilePrefillBranch = $tellerAuthUser?->branch_id;
    }
    $profilePrefillUnit = old('unit_id');
    if ($profilePrefillUnit === null) {
        $profilePrefillUnit = $tellerAuthUser?->unit_id;
    }
?>

    <!-- 🏦 Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-apb">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo e(route('teller.dashboard')); ?>">
  <img src="<?php echo e(asset('images/APB-logo.jpeg')); ?>" height="40">

</a>

                <div class="brand-text">

                    <span class="brand-name">ທະນາຄານ ສົ່ງເສີມກະສິກຳ ຈຳກັດ</span>
                    <span class="brand-subtitle">AGRICULTURAL PROMOTION BANK CO., LTD</span>
                </div>
            </a>

            <!-- Right Side Menu -->
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
                <!-- 🔔 Notification -->
                <li class="nav-item dropdown">
                    <a class="notification-btn" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill"></i>
                        <?php if(isset($notifications) && count($notifications) > 0): ?>
                            <span class="notification-badge"><?php echo e(count($notifications)); ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated--fade-in" aria-labelledby="notifDropdown">
                        <li class="dropdown-header">
                            📢 ການແຈ້ງເຕືອນລ່າສຸດ
                        </li>
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <div class="notification-item <?php echo e($n->approval_status == 'approved' ? 'approved' : 'rejected'); ?>">
<div class="notification-store">
    <div><?php echo e($n->store_name); ?> (<?php echo e($n->refer_code); ?>)</div>
    <div>POS Serial: <?php echo e($n->pos_serial); ?></div>
</div>

                                    <div class="notification-status <?php echo e($n->approval_status == 'approved' ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($n->approval_status == 'approved' ? '✅ Approved' : '❌ Rejected'); ?>

                                    </div>
                                    <?php if($n->approval_status == 'rejected' && $n->admin_remark): ?>
                                        <div class="notification-remark">
                                            <i class="bi bi-chat-dots"></i>
                                            <span><?php echo e(\Illuminate\Support\Str::limit($n->admin_remark, 120)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="notification-time">
                                        Updated <?php echo e($n->updated_at->diffForHumans()); ?>

                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li><span class="dropdown-item text-muted text-center small">No notifications yet</span></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- 👤 Profile -->
                <li class="nav-item dropdown">
                    <a class="profile-section d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="d-none d-md-block">
                            <p class="profile-name">
                                <?php echo e(Auth::user()->teller_id ? 'APB' . Auth::user()->teller_id : Auth::user()->name); ?>

                            </p>
                        </div>
                        <span class="profile-arrow">▼</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated--fade-in" aria-labelledby="userDropdown">

                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileOverviewModal">
                                <i class="bi bi-person-badge"></i> ບັນຊີຂອງຂ້ອຍ
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-shield-lock-fill"></i> ປ່ຽນລະຫັດຜ່ານ
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="bi bi-box-arrow-right"></i> ອອກຈາກລະບົບ
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- ✅ Toast Messages -->
    <?php if(session('profileSetupSuccess')): ?>
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('profileSetupSuccess')); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="toast align-items-center text-bg-danger border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?php echo e($errors->first()); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- 🧱 Main Content -->
    <div class="container py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- 🔐 Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('teller.changePassword')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="changePasswordLabel">
                            <i class="bi bi-shield-lock-fill"></i> ປ່ຽນລະຫັດຜ່ານ
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">
                                🔑 ລະຫັດຜ່ານປັດຈຸບັນ
                            </label>
                            <input type="password" name="current_password" class="form-control" required placeholder="ໃສ່ລະຫັດຜ່ານປັດຈຸບັນ">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                🔐 ລະຫັດຜ່ານໃໝ່
                            </label>
                            <input type="password" name="new_password" class="form-control" required placeholder="ໃສ່ລະຫັດຜ່ານໃໝ່">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                ✅ ຢືນຢັນລະຫັດຜ່ານໃໝ່
                            </label>
                            <input type="password" name="new_password_confirmation" class="form-control" required placeholder="ຢືນຢັນລະຫັດຜ່ານໃໝ່">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            ❌ ຍົກເລີກ
                        </button>
                        <button type="submit" class="btn btn-primary">
                            ✅ ບັນທຶກ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Setup Modal -->
    <div class="modal fade profile-id-modal" id="profileOverviewModal" tabindex="-1" aria-labelledby="profileOverviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileOverviewLabel">
                        <i class="bi bi-person-lines-fill me-2"></i> ລາຍລະອຽດບັນຊີ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <div class="profile-card-avatar">
                                <?php echo e(\Illuminate\Support\Str::of($tellerAuthUser?->name ?? 'A')->substr(0,1)->upper()); ?>

                            </div>
                            <div class="profile-card-title">
                                <h5><?php echo e($tellerAuthUser?->name ?? '—'); ?></h5>
                                <span>ID: <?php echo e($tellerAuthUser?->teller_id ?? '—'); ?></span>
                            </div>
                        </div>
                        <div class="profile-card-body">
                            <div class="profile-card-grid">
                                <div class="profile-card-field">
                                    <span>ເບີໂທ</span>
                                    <strong><?php echo e($tellerAuthUser?->phone ?? '—'); ?></strong>
                                </div>
                                <div class="profile-card-field">
                                    <span>ສາຂາ</span>
                                    <strong>
                                        <?php if($tellerAuthUser?->branch): ?>
                                            <?php echo e($tellerAuthUser->branch->code); ?> - <?php echo e($tellerAuthUser->branch->name); ?>

                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </strong>
                                </div>
                                <div class="profile-card-field">
                                    <span>ຫນ່ວຍບໍລິການ</span>
                                    <strong>
                                        <?php if($tellerAuthUser?->unit): ?>
                                            <?php echo e($tellerAuthUser->unit->unit_code); ?> - <?php echo e($tellerAuthUser->unit->unit_name); ?>

                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </strong>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> ປິດ
                    </button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#profileSetupModal">
                        <i class="bi bi-pencil-square"></i> ແກ້ໄຂຂໍ້ມູນ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileSetupModal" tabindex="-1" aria-labelledby="profileSetupLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('teller.profile.complete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="profileSetupLabel">
                            <i class="bi bi-person-lines-fill me-2"></i> Complete Teller Profile
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Tell us who you are and which branch/unit you belong to. We’ll reuse this info for every workflow.
                        </p>
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="profile_name"
                                   class="form-control <?php $__errorArgs = ['name', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($profilePrefillName); ?>" required>
                            <?php $__errorArgs = ['name', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="profile_phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="profile_phone"
                                   class="form-control <?php $__errorArgs = ['phone', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e($profilePrefillPhone); ?>" required>
                            <?php $__errorArgs = ['phone', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="profile_branch" class="form-label">ສາຂາ</label>
                            <select name="branch_id" id="profile_branch"
                                    class="form-select <?php $__errorArgs = ['branch_id', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">-- ເລືອກສາຂາ --</option>
                                <?php $__currentLoopData = $profileBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>"
                                        <?php echo e((string)$profilePrefillBranch === (string)$branch->id ? 'selected' : ''); ?>>
                                        <?php echo e($branch->code); ?> - <?php echo e($branch->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['branch_id', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php
                            $prefillBranchModel = $profileBranches->firstWhere('id', $profilePrefillBranch);
                            $prefillHasUnits = $prefillBranchModel ? $prefillBranchModel->units->isNotEmpty() : false;
                        ?>
                        <div class="mb-3" id="profile_unit_wrapper"
                             style="<?php echo e($prefillHasUnits ? '' : 'display:none;'); ?>">
                            <label for="profile_unit" class="form-label">ຫນ່ວຍຍ່ອຍຂອງສາຂາ</label>
                            <select name="unit_id" id="profile_unit"
                                    class="form-select <?php $__errorArgs = ['unit_id', 'profileSetup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    data-selected="<?php echo e($profilePrefillUnit ?? ''); ?>"
                                    <?php echo e($prefillHasUnits ? '' : 'disabled'); ?>>
                                <option value="">-- ເລືອກຫນ່ວຍຍ່ອຍ --</option>
                            </select>

                    </div>
                    <div class="modal-footer">
                        <span class="text-muted small me-auto">This step is required the first time you log in.</span>
                        <button type="submit" class="btn btn-success">
                            Save Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const notifDropdown = document.getElementById('notifDropdown');
        const badge = notifDropdown?.querySelector('.notification-badge');

        if (localStorage.getItem("notifSeen") === "true" && badge) {
            badge.remove();
        }

        notifDropdown?.addEventListener('click', function () {
            const b = this.querySelector('.notification-badge');
            if (b) {
                b.style.animation = "popAndFade 0.6s ease forwards";
                setTimeout(() => b.remove(), 600);
                localStorage.setItem("notifSeen", "true");
            }
        });

        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            setTimeout(() => {
                const bsToast = bootstrap.Toast.getInstance(toast);
                if (bsToast) bsToast.hide();
            }, 5000);
        });

        const branchUnitsMap = <?php echo json_encode($profileBranchUnitsPayload, 15, 512) ?>;
        const profileBranchSelect = document.getElementById('profile_branch');
        const profileUnitWrapper = document.getElementById('profile_unit_wrapper');
        const profileUnitSelect = document.getElementById('profile_unit');
        const profileUnitPreview = document.getElementById('profile_unit_preview');

        const renderProfileUnitPreview = (units) => {
            if (!profileUnitPreview) {
                return;
            }

            if (!units.length) {
                profileUnitPreview.style.display = 'none';
                profileUnitPreview.innerHTML = '';
                return;
            }

            profileUnitPreview.style.display = '';

            const list = document.createElement('div');
            list.className = 'profile-unit-preview-list';
            units.forEach(unit => {
                const item = document.createElement('div');
                item.className = 'profile-unit-preview-item';
                item.innerHTML = `<strong>${unit.code}</strong><span>${unit.name}</span>`;
                list.appendChild(item);
            });
            profileUnitPreview.innerHTML = '';
            profileUnitPreview.appendChild(list);
        };

        const populateProfileUnits = (branchId, preserveSelection = true) => {
            if (!profileUnitSelect || !profileUnitWrapper) {
                return;
            }

            const units = branchUnitsMap[branchId] || [];
            profileUnitSelect.innerHTML = `<option value="">-- ເລືອກຫນ່ວຍຍ່ອຍ --</option>`;

            if (!units.length) {
                profileUnitWrapper.style.display = 'none';
                profileUnitSelect.disabled = true;
                if (!preserveSelection) {
                    profileUnitSelect.dataset.selected = '';
                }
                renderProfileUnitPreview([]);
                return;
            }

            profileUnitWrapper.style.display = '';
            profileUnitSelect.disabled = false;

            units.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = `${unit.code} - ${unit.name}`;
                profileUnitSelect.appendChild(option);
            });

            const desired = preserveSelection ? (profileUnitSelect.dataset.selected || '') : '';
            if (desired) {
                profileUnitSelect.value = desired;
            } else {
                profileUnitSelect.value = '';
            }

            renderProfileUnitPreview(units);
        };

        if (profileBranchSelect && profileUnitSelect) {
            profileBranchSelect.addEventListener('change', (event) => {
                profileUnitSelect.dataset.selected = '';
                populateProfileUnits(event.target.value, false);
            });

            if (profileBranchSelect.value) {
                populateProfileUnits(profileBranchSelect.value, true);
            } else if (profileUnitWrapper) {
                profileUnitWrapper.style.display = 'none';
                profileUnitSelect.disabled = true;
                renderProfileUnitPreview([]);
            }
        }

        const shouldShowProfileModal = <?php echo e($shouldShowProfileSetupModal ? 'true' : 'false'); ?>;
        if (shouldShowProfileModal) {
            const profileModalEl = document.getElementById('profileSetupModal');
            if (profileModalEl) {
                const profileModal = bootstrap.Modal.getOrCreateInstance(profileModalEl);
                profileModal.show();
            }
        }
    });
    </script>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/teller.blade.php ENDPATH**/ ?>