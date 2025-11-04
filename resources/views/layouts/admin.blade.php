@php
    $pending_count = \Cache::remember('pending_onboarding_count', 30, function () {
        try {
            return \App\Models\TellerPortal\OnboardingRequest::where('approval_status', 'pending')->count();
        } catch (\Exception $e) {
            return 0;
        }
    });

    $authUser = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APB Bank - Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700;800&family=Noto+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --apb-primary: #2D5F3F;
            --apb-secondary: #1e4229;
            --apb-accent: #4CAF50;
            --apb-dark: #1a3321;
        }

        * {
            font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
        }

        body {
            background: linear-gradient(180deg, #edf7f1 0%, #ffffff 45%);
            min-height: 100vh;
        }

        .navbar-apb {
            background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 0.9rem 0;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.5px;
        }

        .navbar-brand .logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-name {
            font-size: 1.35rem;
        }

        .brand-subtitle {
            font-size: 0.7rem;
            text-transform: uppercase;
            opacity: 0.85;
            letter-spacing: 1px;
        }

        .notif-btn {
            position: relative;
            border-radius: 12px;
            padding: 0.55rem 0.9rem;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .notif-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 24px;
            padding: 2px 6px;
            border-radius: 999px;
            background: #ffc107;
            color: #1e1e1e;
            font-size: 0.7rem;
            font-weight: 700;
            border: 2px solid var(--apb-primary);
        }

        .profile-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-chip:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            color: var(--apb-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .profile-meta {
            color: #fff;
        }

        .profile-meta .name {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .profile-meta .role {
            margin: 0;
            font-size: 0.72rem;
            opacity: 0.8;
        }

        .app-body {
            padding: clamp(18px, 4vw, 32px);
            max-width: 1280px;
            margin: 0 auto;
        }

        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 22px;
            border: 1px solid rgba(45, 95, 63, 0.08);
            box-shadow: 0 18px 45px rgba(45, 95, 63, 0.08);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .page-card {
            padding: clamp(24px, 5vw, 40px);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-weight: 800;
            color: var(--apb-secondary);
        }

        .logout-btn {
            border-radius: 999px;
            padding: 0.45rem 1.1rem;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: #1a1a1a;
        }

        @media (max-width: 991.98px) {
            .navbar-brand .logo {
                width: 38px;
                height: 38px;
                font-size: 1.3rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-apb">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <span class="logo"><i class="bi bi-shield-check"></i></span>
            <span class="brand-text">
                <span class="brand-name">APB BANK</span>
                <span class="brand-subtitle">Admin Control Center</span>
            </span>
        </a>

        <div class="d-flex align-items-center gap-3 ms-auto">
            <a href="{{ route('admin.onboarding.index') }}" class="notif-btn">
                <i class="bi bi-bell"></i>
                @if($pending_count > 0)
                    <span class="notif-badge">{{ $pending_count }}</span>
                @endif
            </a>

            <div class="dropdown">
                <button class="btn profile-chip dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="profile-avatar"><i class="bi bi-person-fill"></i></span>
                    <span class="profile-meta">
                        <span class="name">{{ $authUser?->name ?? 'Administrator' }}</span>
                        <span class="role">Admin</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">{{ $authUser?->email }}</h6></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Account Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<div class="app-body container-fluid py-4">
    <div class="admin-card page-card">
        <div class="page-header">
            <h3 class="page-title">@yield('title', 'Admin Dashboard')</h3>
            @yield('page-actions')
        </div>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
