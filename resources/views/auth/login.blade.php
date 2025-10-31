@extends('layouts.guest')

@section('title', 'Login - APB Bank Teller Portal')

@section('content')
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1a3321 0%, #2D5F3F 50%, #4CAF50 100%);
        position: relative;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Animated Tech Background */
    .tech-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .grid-lines {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image:
            linear-gradient(rgba(76, 175, 80, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(76, 175, 80, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .shape {
        position: absolute;
        border: 2px solid rgba(76, 175, 80, 0.3);
        border-radius: 50%;
        animation: float 15s infinite ease-in-out;
    }

    .shape:nth-child(1) {
        width: min(300px, 30vw);
        height: min(300px, 30vw);
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: min(200px, 20vw);
        height: min(200px, 20vw);
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        width: min(150px, 15vw);
        height: min(150px, 15vw);
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    .shape:nth-child(4) {
        width: min(250px, 25vw);
        height: min(250px, 25vw);
        top: 30%;
        right: 25%;
        animation-delay: 1s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
        50% { transform: translateY(-30px) rotate(180deg); opacity: 0.6; }
    }

    .particles {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: particleFloat 10s infinite ease-in-out;
    }

    .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
    .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
    .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
    .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
    .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
    .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
    .particle:nth-child(7) { left: 70%; animation-delay: 6s; }
    .particle:nth-child(8) { left: 80%; animation-delay: 7s; }
    .particle:nth-child(9) { left: 90%; animation-delay: 8s; }

    @keyframes particleFloat {
        0% { transform: translateY(100vh); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(-100px); opacity: 0; }
    }

    /* Login Card */
    .login-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 450px;
        padding: clamp(15px, 5vw, 20px);
        margin: clamp(20px, 5vh, 40px) auto;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: clamp(12px, 4vw, 20px);
        padding: clamp(25px, 6vw, 40px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: cardSlideUp 0.6s ease-out;
        width: 100%;
    }

    @keyframes cardSlideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-logo {
        text-align: center;
        margin-bottom: clamp(20px, 5vw, 30px);
    }

    .logo-icon {
        width: clamp(60px, 15vw, 80px);
        height: clamp(60px, 15vw, 80px);
        background: linear-gradient(135deg, #2D5F3F 0%, #4CAF50 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(2rem, 5vw, 2.5rem);
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 10px 30px rgba(45, 95, 63, 0.3);
        animation: logoFloat 3s ease-in-out infinite;
        overflow: hidden;
        position: relative;
    }

    .logo-icon img {
        width:150%;
        height: 150%;
        object-fit: contain;
        padding: 10px;
    }

    .logo-icon.no-bg {
        background: transparent;
        box-shadow: none;
    }

    @keyframes logoFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .login-title {
        text-align: center;
        color: #2D5F3F;
        font-weight: 800;
        font-size: clamp(1.3rem, 4vw, 1.8rem);
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .login-subtitle {
        text-align: center;
        color: #6c757d;
        font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        margin-bottom: clamp(20px, 5vw, 30px);
    }

    .form-label {
        font-weight: 600;
        color: #2D5F3F;
        margin-bottom: 8px;
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 16px);
        transition: all 0.3s ease;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        width: 100%;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
    }

    .btn-login {
        background: linear-gradient(135deg, #2D5F3F 0%, #4CAF50 100%);
        border: none;
        color: white;
        padding: clamp(12px, 3.5vw, 14px);
        border-radius: 10px;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-login:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(45, 95, 63, 0.4);
    }

    .btn-register {
        background: white;
        border: 2px solid #2D5F3F;
        color: #2D5F3F;
        padding: clamp(12px, 3.5vw, 14px);
        border-radius: 10px;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
        width: 100%;
    }

    .btn-register:hover {
        background: #2D5F3F;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(45, 95, 63, 0.2);
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 16px);
        margin-bottom: 20px;
        animation: alertSlide 0.4s ease-out;
        font-size: clamp(0.8rem, 2.5vw, 0.9rem);
    }

    @keyframes alertSlide {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-danger {
        background: #fff5f5;
        color: #c82333;
        border-left: 4px solid #dc3545;
    }

    .alert-danger ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .alert-danger li {
        padding: 4px 0;
        font-size: clamp(0.75rem, 2.5vw, 0.85rem);
    }

    .alert-danger li::before {
        content: '❌ ';
        margin-right: 5px;
    }

    .footer-text {
        text-align: center;
        color: #6c757d;
        font-size: clamp(0.75rem, 2vw, 0.85rem);
        margin-top: clamp(20px, 5vw, 25px);
        padding-top: clamp(15px, 4vw, 20px);
        border-top: 1px solid #e9ecef;
        line-height: 1.5;
    }

    /* Success Modal */
    .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #28a745 0%, #66BB6A 100%);
        border: none;
        padding: clamp(15px, 4vw, 20px);
    }

    .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: clamp(1rem, 3vw, 1.2rem);
    }

    .modal-body {
        padding: clamp(20px, 5vw, 25px);
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
    }

    /* Extra Small Devices (phones, 320px - 575px) */
    @media (max-width: 575px) {
        body {
            padding: 10px 0;
        }

        .login-container {
            padding: 10px;
            margin: 15px auto;
        }

        .login-card {
            padding: 20px 15px;
        }

        .shape {
            opacity: 0.3;
        }
    }

    /* Small Devices (landscape phones, 576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
        .login-container {
            max-width: 500px;
        }
    }

    /* Medium Devices (tablets, 768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .login-container {
            max-width: 550px;
        }
    }

    /* Large Devices (desktops, 992px - 1199px) */
    @media (min-width: 992px) and (max-width: 1199px) {
        .login-container {
            max-width: 500px;
        }
    }

    /* Extra Large Devices (large desktops, 1200px - 1399px) */
    @media (min-width: 1200px) and (max-width: 1399px) {
        .login-container {
            max-width: 480px;
        }
    }

    /* XXL Devices (larger desktops, 1400px and up) */
    @media (min-width: 1400px) {
        .login-container {
            max-width: 500px;
        }
    }

    /* Landscape Mobile Phones */
    @media (max-height: 600px) and (orientation: landscape) {
        body {
            padding: 20px 0;
        }

        .login-container {
            margin: 10px auto;
        }

        .login-card {
            padding: 20px;
        }

        .login-logo {
            margin-bottom: 15px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .login-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .login-subtitle {
            font-size: 0.75rem;
            margin-bottom: 15px;
        }

        .footer-text {
            margin-top: 15px;
            padding-top: 10px;
        }
    }

    /* Very Small Screens (320px) */
    @media (max-width: 320px) {
        .login-container {
            padding: 8px;
        }

        .login-card {
            padding: 15px 10px;
            border-radius: 12px;
        }
    }

    /* Large Screens (ensure content doesn't get too big) */
    @media (min-width: 1920px) {
        .login-title {
            font-size: 2rem;
        }

        .login-subtitle {
            font-size: 1rem;
        }
    }
</style>

=
<!-- Login Container -->
<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <!-- OPTION 1: Use your logo image with green background -->
            <div class="logo-icon">
                <img src="{{ asset('images/APB-logo.jpeg') }}" alt="APB Bank Logo">
            </div>
            <h3 class="login-title">APB BANK</h3>
            <p class="login-subtitle">Teller Portal System</p>
        </div>

        {{-- ✅ Show errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>ເກີດຂໍ້ຜິດພາດ:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email Address
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="form-control" required autofocus placeholder="ປ້ອນອີເມວ">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> Password
                </label>
                <input type="password" name="password" id="password"
                       class="form-control" required placeholder="ປ້ອນລະຫັດຜ່ານ">
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                ເຂົ້າສູ່ລະບົບ
            </button>

            {{-- ✅ Register Button --}}
            <a href="{{ route('register') }}" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>
                ສ້າງບັນຊີໃໝ່
            </a>

            <p class="footer-text">
                <i class="bi bi-shield-check me-1"></i>
                © {{ date('Y') }} APB Bank Teller Portal System
            </p>
        </form>
    </div>
</div>

{{-- Success Modal --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const msg = "{{ session('success') }}";
    const modalHTML = `
    <div class="modal fade" id="registerSuccessModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header text-white">
            <h5 class="modal-title">
                <i class="bi bi-check-circle-fill"></i>
                ລົງທະບຽນສຳເລັດ
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p class="mb-3"><strong>${msg}</strong></p>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                ກະລຸນາລໍຖ້າການອະນຸມັດຈາກ Admin ກ່ອນເຂົ້າສູ່ລະບົບ
            </div>
          </div>
        </div>
      </div>
    </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    new bootstrap.Modal(document.getElementById('registerSuccessModal')).show();
});
</script>
@endif
@endsection
