<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APB Bank - Teller Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Noto Sans Lao Font -->
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
@php
    $tellerAuthUser = auth()->user();
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
@endphp

    <!-- 🏦 Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-apb">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('teller.dashboard') }}">
  <img src="{{ asset('images/APB-logo.jpeg') }}" height="40">

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
                        @if(isset($notifications) && count($notifications) > 0)
                            <span class="notification-badge">{{ count($notifications) }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated--fade-in" aria-labelledby="notifDropdown">
                        <li class="dropdown-header">
                            📢 ການແຈ້ງເຕືອນລ່າສຸດ
                        </li>
                        @forelse($notifications as $n)
                            <li>
                                <div class="notification-item {{ $n->approval_status == 'approved' ? 'approved' : 'rejected' }}">
                                    <div class="notification-store">
                                        {{ $n->store_name . ' (' . $n->refer_code . ')' }}
                                    </div>
                                    <div class="notification-status {{ $n->approval_status == 'approved' ? 'text-success' : 'text-danger' }}">
                                        {{ $n->approval_status == 'approved' ? '✅ Approved' : '❌ Rejected' }}
                                    </div>
                                    @if($n->approval_status == 'rejected' && $n->admin_remark)
                                        <div class="notification-remark">
                                            <i class="bi bi-chat-dots"></i>
                                            <span>{{ \Illuminate\Support\Str::limit($n->admin_remark, 120) }}</span>
                                        </div>
                                    @endif
                                    <div class="notification-time">
                                        Updated {{ $n->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted text-center small">No notifications yet</span></li>
                        @endforelse
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
                                {{ Auth::user()->teller_id ? 'APB' . Auth::user()->teller_id : Auth::user()->name }}
                            </p>
                        </div>
                        <span class="profile-arrow">▼</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated--fade-in" aria-labelledby="userDropdown">
                        <li class="dropdown-header">
                            👤 ບັນຊີຂອງຂ້ອຍ
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-shield-lock-fill"></i> ປ່ຽນລະຫັດຜ່ານ
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
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
    @if(session('profileSetupSuccess'))
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('profileSetupSuccess') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="toast align-items-center text-bg-danger border-0 position-fixed bottom-0 end-0 m-3 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    <!-- 🧱 Main Content -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- 🔐 Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('teller.changePassword') }}">
                    @csrf
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
    <div class="modal fade" id="profileSetupModal" tabindex="-1" aria-labelledby="profileSetupLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('teller.profile.complete') }}">
                    @csrf
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="profileSetupLabel">
                            <i class="bi bi-person-lines-fill me-2"></i> Complete Teller Profile
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Provide your name and phone number so we can personalize your teller account before you start working.
                        </p>
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="profile_name"
                                   class="form-control @error('name', 'profileSetup') is-invalid @enderror"
                                   value="{{ $profilePrefillName }}" required>
                            @error('name', 'profileSetup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="profile_phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="profile_phone"
                                   class="form-control @error('phone', 'profileSetup') is-invalid @enderror"
                                   value="{{ $profilePrefillPhone }}" required>
                            @error('phone', 'profileSetup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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

        const shouldShowProfileModal = {{ $shouldShowProfileSetupModal ? 'true' : 'false' }};
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



