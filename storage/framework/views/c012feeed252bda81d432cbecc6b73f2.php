<?php $__env->startSection('title', 'Forgot Password - Teller Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-card" style="max-width: 420px; width:100%;">
    <h3 class="login-title">🔑 Reset Password</h3>

    <?php if(session('status')): ?>
        <div class="alert alert-success small">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger small">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="email" class="form-label">Enter your email address</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-2">
            Send Password Reset Link
        </button>

        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark w-100">
            Back to Login
        </a>

        <p class="text-center mt-3 form-text">We’ll send a secure link to your email.</p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\teller-portal\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>