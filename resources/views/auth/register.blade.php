@extends('layouts.guest')

@section('title', 'Register - APB Bank Teller Portal')

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

    /* Register Card */
    .register-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 500px;
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

    .register-logo {
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
        font-size: clamp(1.3rem, 4vw, 1.6rem);
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .register-subtitle {
        text-align: center;
        color: #6c757d;
        font-size: clamp(0.8rem, 2.5vw, 0.85rem);
        margin-bottom: clamp(20px, 5vw, 25px);
    }

    .form-label {
        font-weight: 600;
        color: #2D5F3F;
        margin-bottom: 6px;
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: clamp(10px, 3vw, 11px) clamp(12px, 3vw, 14px);
        transition: all 0.3s ease;
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
        width: 100%;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
    }

    .btn-register {
        background: linear-gradient(135deg, #2D5F3F 0%, #4CAF50 100%);
        border: none;
        color: white;
        padding: clamp(11px, 3.5vw, 13px);
        border-radius: 10px;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .btn-register::before {
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

    .btn-register:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(45, 95, 63, 0.4);
    }

    .btn-back {
        background: white;
        border: 2px solid #2D5F3F;
        color: #2D5F3F;
        padding: clamp(11px, 3.5vw, 13px);
        border-radius: 10px;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
        width: 100%;
    }

    .btn-back:hover {
        background: #2D5F3F;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(45, 95, 63, 0.2);
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 14px);
        margin-bottom: 20px;
        animation: alertSlide 0.4s ease-out;
        font-size: clamp(0.8rem, 2.5vw, 0.85rem);
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
        padding: 3px 0;
        font-size: clamp(0.75rem, 2.5vw, 0.82rem);
    }

    .alert-danger li::before {
        content: '❌ ';
        margin-right: 5px;
    }

    /* Form Grid for 2 columns on larger screens */
    @media (min-width: 576px) {
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .mb-3 {
            margin-bottom: 0 !important;
        }
    }

    /* Small devices */
    @media (max-width: 575px) {
        body {
            padding: 10px 0;
        }

        .register-container {
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

    /* Landscape phones */
    @media (max-height: 700px) and (orientation: landscape) {
        body {
            padding: 15px 0;
        }

        .register-container {
            margin: 10px auto;
        }

        .login-card {
            padding: 20px;
        }

        .register-logo {
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

        .register-subtitle {
            font-size: 0.75rem;
            margin-bottom: 15px;
        }

        .mb-3 {
            margin-bottom: 0.8rem !important;
        }
    }
</style>



<!-- Register Container -->
<div class="register-container">
    <div class="login-card">
        <div class="register-logo">
            <div class="logo-icon">
                <img src="{{ asset('images/APB-logo.jpeg') }}" alt="APB Bank Logo">
            </div>
            <h3 class="login-title">ສ້າງບັນຊີໃໝ່</h3>
            <p class="register-subtitle">APB Bank Teller Portal</p>
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

        {{-- ✅ Register Form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-person me-1"></i> ຊື່ເຕັມ
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-control" required placeholder="ປ້ອນຊື່ເຕັມ">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email Address
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control" required placeholder="ປ້ອນອີເມວ">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-phone me-1"></i> ເບີໂທລະສັບ
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="form-control" placeholder="ປ້ອນເບີໂທ (ຖ້າມີ)">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-lock me-1"></i> ລະຫັດຜ່ານ
                </label>
                <input type="password" name="password"
                       class="form-control" required placeholder="ປ້ອນລະຫັດຜ່ານ">
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-lock-fill me-1"></i> ຢືນຢັນລະຫັດຜ່ານ
                </label>
                <input type="password" name="password_confirmation"
                       class="form-control" required placeholder="ຢືນຢັນລະຫັດຜ່ານ">
            </div>

            <button type="submit" class="btn-register mb-3">
                <i class="bi bi-check-circle me-2"></i>
                ລົງທະບຽນ
            </button>

            <a href="{{ route('login') }}" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                ກັບໄປເຂົ້າສູ່ລະບົບ
            </a>
        </form>
    </div>
</div>
@endsection
