

<?php $__env->startSection('title', 'Login - APB Bank Teller Portal'); ?>

<?php $__env->startSection('content'); ?>
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
        background: #0b231f;
        position: relative;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Full-screen background layers to keep the photo visible while readable */
    .background-hero {
        position: fixed;
        inset: 0;
        background:
            linear-gradient(135deg, rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.15)),
            url('<?php echo e(asset('images/apbBG.jpeg')); ?>') center center / cover no-repeat;
        filter: saturate(1.1) contrast(1.05) brightness(1.05);
        z-index: 0;
    }

    .background-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 40%, rgba(255,255,255,0.12), transparent 50%);
        mix-blend-mode: screen;
        pointer-events: none;
    }

    .background-vignette {
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at 50% 45%, rgba(0,0,0,0) 0%, rgba(0,0,0,0.07) 55%, rgba(0,0,0,0.18) 100%);
        pointer-events: none;
        z-index: 1;
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
            linear-gradient(rgba(20, 184, 166, 0.12) 1px, transparent 1px),
            linear-gradient(90deg, rgba(20, 184, 166, 0.12) 1px, transparent 1px);
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
        border: 2px solid rgba(20, 184, 166, 0.3);
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
<<<<<<< ours
<<<<<<< ours
<<<<<<< ours
        max-width: 520px;
=======
        max-width: 480px;
>>>>>>> theirs
=======
        max-width: 450px;
>>>>>>> theirs
        padding: clamp(15px, 5vw, 20px);
        margin: clamp(20px, 5vh, 40px) auto;
    }

    .login-card {
<<<<<<< ours
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, rgba(249, 252, 251, 0.92) 100%);
        backdrop-filter: blur(18px);
        border-radius: clamp(16px, 4vw, 22px);
        padding: clamp(28px, 6vw, 44px);
        box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35), 0 1px 0 rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.22);
=======
        max-width: 450px;
        padding: clamp(15px, 5vw, 20px);
        margin: clamp(20px, 5vh, 40px) auto;
    }

    .login-card {
=======
>>>>>>> theirs
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: clamp(12px, 4vw, 20px);
        padding: clamp(25px, 6vw, 40px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
<<<<<<< ours
>>>>>>> theirs
=======
>>>>>>> theirs
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
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(2rem, 5vw, 2.5rem);
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 10px 30px rgba(20, 184, 166, 0.35);
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
        color: #0f766e;
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
        color: #0f766e;
        margin-bottom: 8px;
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
    }

    .form-control {
        border: 2px solid #e0f2f1;
        border-radius: 10px;
        padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 16px);
        transition: all 0.3s ease;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        width: 100%;
        background: rgba(255, 255, 255, 0.9);
    }

    .form-control:hover {
        border-color: #99f6e4;
        box-shadow: 0 0 0 0.1rem rgba(20, 184, 166, 0.15);
    }

    .form-control:focus {
        border-color: #14b8a6;
        box-shadow: 0 0 0 0.2rem rgba(20, 184, 166, 0.2);
        background: #f0fdfa;
    }

    .btn-login {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        border: 2px solid transparent;
        color: #fff;
        padding: clamp(12px, 3.5vw, 14px);
        border-radius: 10px;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .success-circle-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 18, 11, 0.75);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.35s ease;
    }

    .success-circle-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .success-circle-card {
        width: min(260px, 65vw);
        aspect-ratio: 1 / 1;
        border-radius: 999px;
        background-image:
            linear-gradient(135deg, rgba(6, 18, 11, 0.82), rgba(9, 31, 19, 0.88)),
            url('<?php echo e(asset('images/APB-logo.jpeg')); ?>');
        background-size: cover;
        background-position: center;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: clamp(20px, 6vw, 28px);
        text-align: center;
        color: #f8fff5;
        position: relative;
        transform: scale(0.85);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .success-circle-overlay.show .success-circle-card {
        transform: scale(1);
    }

    .success-circle-card::after,
    .success-circle-card::before {
        content: '';
        position: absolute;
        border-radius: 50%;
        opacity: 0.4;
        z-index: 0;
    }

    .success-circle-card::before {
        width: 110%;
        height: 110%;
        border: 1px dashed rgba(255, 255, 255, 0.2);
    }

    .success-circle-card::after {
        width: 125%;
        height: 125%;
        border: 1px solid rgba(20, 184, 166, 0.2);
    }

    .success-circle-icon {
        width: clamp(60px, 18vw, 80px);
        height: clamp(60px, 18vw, 80px);
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
    }

    .success-circle-check {
        width: clamp(48px, 14vw, 68px);
        height: clamp(48px, 14vw, 68px);
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.45);
    }

    .success-circle-check img {
        width: 75%;
        height: 75%;
        object-fit: contain;
        border-radius: 50%;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.35));
    }

    .success-circle-text {
        z-index: 1;
        padding: 0;
        border-radius: 0;
        backdrop-filter: none;
        background: transparent;
        box-shadow: none;
    }

    .success-circle-text h5 {
        font-size: clamp(1rem, 3vw, 1.25rem);
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .success-circle-message {
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        margin-bottom: 12px;
        color: #ffffff;
    }

    .success-circle-note {
        font-size: clamp(0.8rem, 2.3vw, 0.9rem);
        color: rgba(255, 255, 255, 0.85);
        margin: 0 auto;
        max-width: 80%;
    }

    @media (max-width: 480px) {
        .success-circle-card {
            padding: 24px;
        }

        .success-circle-note {
            max-width: 100%;
        }
    }


    .btn-login:hover,
    .btn-login:focus,
    .btn-login:active {
        background: #fff;
        color: #0f766e;
        border-color: #0f766e;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(20, 184, 166, 0.35);
    }

    .btn-register {
        background: white;
        border: 2px solid #0f766e;
        color: #0f766e;
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
        background: #0f766e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(20, 184, 166, 0.25);
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
<div class="background-hero"></div>
<div class="background-vignette"></div>
<!-- Login Container -->
<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <!-- OPTION 1: Use your logo image with green background -->
            <div class="logo-icon">
                <img src="<?php echo e(asset('images/APB-logo.jpeg')); ?>" alt="APB Bank Logo">
            </div>
            <h3 class="login-title">APB BANK</h3>
            <p class="login-subtitle">Teller Portal System</p>
        </div>

        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>ເກີດຂໍ້ຜິດພາດ:</strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label for="teller_id" class="form-label">
                    <i class="bi bi-envelope me-1"></i> ລະຫັດພະນັກງານ
                </label>
                <input type="teller_id" name="teller_id" id="teller_id" value="<?php echo e(old('teller_id')); ?>"
                       class="form-control" required autofocus placeholder="">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> ລະຫັດຜ່ານ
                </label>
                <input type="password" name="password" id="password"
                       class="form-control" required placeholder="">
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                ເຂົ້າສູ່ລະບົບ
            </button>

            
            <a href="<?php echo e(route('register')); ?>" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>
                ສ້າງບັນຊີໃໝ່
            </a>

            <p class="footer-text">
                <i class="bi bi-shield-check me-1"></i>
                © <?php echo e(date('Y')); ?> APB Bank Teller Portal System
            </p>
        </form>
    </div>
</div>


<?php if(session('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const msg = "<?php echo e(session('success')); ?>";
    const modalHTML = `
    <div class="success-circle-overlay" id="registerSuccessModal">
        <div class="success-circle-card">

            <div class="success-circle-text">

                <p class="success-circle-message"><strong>${msg}</strong></p>
                <p class="success-circle-note">
                    <i class="bi bi-info-circle me-1"></i>
                    ກະລຸນາລໍຖ້າການອະນຸມັດຈາກ Admin ກ່ອນເຂົ້າສູ່ລະບົບ
                </p>
            </div>
        </div>
    </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    const overlay = document.getElementById('registerSuccessModal');

    const hideOverlay = () => overlay.classList.remove('show');
    overlay.addEventListener('click', (event) => {
        if (event.target === overlay) {
            hideOverlay();
        }
    });

    requestAnimationFrame(() => overlay.classList.add('show'));

    overlay.addEventListener('transitionend', (event) => {
        if (event.propertyName === 'opacity' && !overlay.classList.contains('show')) {
            overlay.remove();
        }
    });
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>