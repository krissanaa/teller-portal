<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Teller Portal'); ?></title>

    
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&family=Noto+Sans+Lao:wght@300;400;500;700&display=swap" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Thai', 'Noto Sans Lao', sans-serif;
            background-color: #f7f9fb;
            color: #222;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-link {
            color: #f8f9fa !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .card {
            border-radius: 10px;
        }

        footer {
            padding: 20px 0;
            color: #777;
            font-size: 0.9rem;
            background: #f1f3f4;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">🏦 Teller Portal</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if(auth()->guard()->check()): ?>
                    <ul class="navbar-nav ms-auto">
                        <?php if(Auth::user()->role === 'admin'): ?>
                            <li class="nav-item"><a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Dashboard</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link">Users</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('admin.reports.index') ?? '#'); ?>" class="nav-link">Reports</a></li>
                        <?php elseif(Auth::user()->role === 'teller'): ?>
                            <li class="nav-item"><a href="<?php echo e(route('teller.dashboard')); ?>" class="nav-link">Dashboard</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('teller.requests.create')); ?>" class="nav-link">Onboarding</a></li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                               <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if(auth()->guard()->guest()): ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="<?php echo e(route('login')); ?>" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="<?php echo e(route('register')); ?>" class="nav-link">Register</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="text-center">
        <div class="container">
            <p>© <?php echo e(date('Y')); ?> Teller Portal System — All Rights Reserved.</p>
            <p class="small text-muted">Designed for Teller and Admin operations management.</p>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>