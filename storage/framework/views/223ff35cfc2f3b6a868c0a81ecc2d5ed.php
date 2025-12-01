<?php
$pending_count = \Cache::remember('pending_onboarding_count', 30, function () {
try {
return \App\Models\TellerPortal\OnboardingRequest::where('approval_status', 'pending')->count();
} catch (\Exception $e) {
return 0;
}
});

$authUser = auth()->user();
?>

<!DOCTYPE html>
<html lang="lo">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'APB Bank - Admin Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700;800&family=Noto+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --apb-primary: #14b8a6;
            --apb-secondary: #0f766e;
            --apb-accent: #2dd4bf;
            --apb-dark: #0d5c56;
            --apb-bg: #f1f5f9;
            --apb-border: #e2e8f0;
        }

        * {
            font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
        }

        body {
            background: #f4f6f3;
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

        .notification-btn {
            position: relative;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 8px 14px;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

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
            font-size: 0.9rem;
            transition: transform 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .dropdown.show .profile-arrow {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 8px;
            margin-top: 12px;
            min-width: 260px;
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

        .logout-btn {
            color: #dc3545 !important;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #fee !important;
        }

        .app-body {
            padding: clamp(18px, 4vw, 32px);
            max-width: 1280px;
            margin: 0 auto;
        }

        .page-card {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .page-header {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-heading {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .page-eyebrow {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .page-title {
            margin: 0;
            font-weight: 800;
            color: #1a3321;
            font-size: 1.5rem;
        }

        .page-subtitle {
            margin: 0;
            color: #6c757d;
        }

        .page-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-actions>* {
            margin: 0;
        }

        .page-body {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .btn-gradient {
            background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(45, 95, 63, 0.3);
            color: #fff;
        }

        .btn-filter {
            background: var(--apb-secondary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-filter:hover {
            background: var(--apb-dark);
            color: #fff;
        }

        .filter-card,
        .table-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
        }

        .filter-card label {
            font-weight: 600;
            color: #1a3321;
        }

        .filter-card .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid #dfe4df;
        }

        .table-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .table-card-header h5 {
            margin: 0;
            font-weight: 700;
            color: #1a3321;
        }

        .table-card-header .meta {
            font-size: 0.875rem;
            color: #000000;
            font-weight: 600;
            background: #FFC107;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            border: 1px solid #FFC107;
        }

        .table-modern {
            margin: 0;
        }

        .table-modern thead th {
            background: #f6f8f6;
            border-bottom: none;
            font-weight: 700;
            color: #495057;
        }

        .table-modern tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .table-modern a {
            color: var(--apb-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .table-modern a:hover {
            text-decoration: underline;
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill.approved {
            background: rgba(76, 175, 80, 0.1);
            color: #2d5f3f;
        }

        .status-pill.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #8a6d1b;
        }

        .status-pill.rejected {
            background: rgba(220, 53, 69, 0.12);
            color: #a72835;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            border-radius: 10px;
            border: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 14px;
            color: #fff;
        }

        .btn-action.approve {
            background: #2d5f3f;
        }

        .btn-action.approve:hover {
            background: #1e4229;
        }

        .btn-action.reject {
            background: #c7394d;
        }

        .btn-action.reject:hover {
            background: #9c2033;
        }

        @media (max-width: 768px) {
            .brand-text .brand-subtitle {
                display: none;
            }

            .profile-section {
                padding: 5px 10px;
            }

            .notification-btn {
                padding: 6px 10px;
            }
        }

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
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- 🏦 Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-apb">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">
                <img src="<?php echo e(asset('images/APB-logo.jpeg')); ?>" height="40">
            </a>

            <div class="brand-text">
                <span class="brand-name">ທະນາຄານ ສົ່ງເສີມກະສິກຳ ຈຳກັດ</span>
                <span class="brand-subtitle">AGRICULTURAL PROMOTION BANK CO., LTD</span>
            </div>

            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.onboarding.index')); ?>" class="notification-btn" title="Pending onboarding requests">
                        <i class="bi bi-bell-fill"></i>
                        <?php if($pending_count > 0): ?>
                        <span class="notification-badge"><?php echo e($pending_count); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="profile-section d-flex align-items-center gap-2" href="#" id="adminUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="d-none d-md-block">
                            <p class="profile-name">
                                <?php echo e($authUser?->teller_id ? 'APB' . $authUser->teller_id : ($authUser?->name ?? 'Administrator')); ?>

                            </p>
                            <p class="profile-role">Admin</p>
                        </div>
                        <span class="profile-arrow"><i class="bi bi-chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated--fade-in" aria-labelledby="adminUserDropdown">
                        <li class="dropdown-header"><?php echo e($authUser?->email ?? 'admin@apb-bank.test'); ?></li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                <i class="bi bi-gear"></i>Account Settings
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item logout-btn" href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
        <?php echo csrf_field(); ?>
    </form>

    <div class="app-body container-fluid py-4">
        <div class="admin-card page-card">
            <div class="page-header">
                <div class="page-heading">
                    <?php if (! empty(trim($__env->yieldContent('page-eyebrow')))): ?>
                    <p class="page-eyebrow"><?php echo $__env->yieldContent('page-eyebrow'); ?></p>
                    <?php endif; ?>
                    <h3 class="page-title"><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?></h3>
                    <?php if (! empty(trim($__env->yieldContent('page-subtitle')))): ?>
                    <p class="page-subtitle"><?php echo $__env->yieldContent('page-subtitle'); ?></p>
                    <?php endif; ?>
                </div>
                <?php if (! empty(trim($__env->yieldContent('page-actions')))): ?>
                <div class="page-actions">
                    <?php echo $__env->yieldContent('page-actions'); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="page-body">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /var/www/html/resources/views/layouts/admin.blade.php ENDPATH**/ ?>