<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserLogController as AdminUserLogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\OnboardingRequestController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\TellerDashboardController;
use App\Http\Controllers\Teller\OnboardingController;

// ============================================================
// 🏠 หน้าแรก (เปิดเว็บพาไป Login)
// ============================================================
Route::get('/', fn() => redirect()->route('login'));

// ============================================================
// 🔐 หน้าหลัง Login — ส่งผู้ใช้ไป Dashboard ตาม Role
// ============================================================
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');

    return match ($user->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'teller' => redirect()->route('teller.dashboard'),
        default  => tap(auth()->logout(), fn() => redirect()->route('login')),
    };
})->middleware('auth')->name('dashboard');

// ============================================================
// 👨‍💼 Teller Routes
// ============================================================
Route::middleware(['auth', 'role:teller', 'approved'])
    ->prefix('teller')
    ->name('teller.')
    ->group(function () {
        // Dashboard ของ Teller
        Route::get('/dashboard', [TellerDashboardController::class, 'index'])->name('dashboard');

        // แบบฟอร์มสมัครร้านค้า (Onboarding)
        Route::get('/requests/create', [OnboardingController::class, 'create'])->name('requests.create');
        Route::post('/requests/store', [OnboardingController::class, 'store'])->name('requests.store');
        Route::get('/requests/{id}', [OnboardingController::class, 'show'])->name('requests.show');

        // ✏️ แก้ไขฟอร์ม (เฉพาะสถานะ pending)
        Route::get('/requests/{id}/edit', [OnboardingController::class, 'edit'])->name('requests.edit');
        Route::put('/requests/{id}', [OnboardingController::class, 'update'])->name('requests.update');
    });

// ============================================================
// 👑 Admin Routes
// ============================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // --------------------------------------------------------
        // 🏠 Dashboard
        // --------------------------------------------------------
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // --------------------------------------------------------
        // 👥 Teller Management (CRUD + Reset Password + Approve/Reject)
        // --------------------------------------------------------
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('resetPassword');
            Route::get('/{id}', [AdminUserController::class, 'show'])->name('show');
            Route::post('/{id}/status', [AdminUserController::class, 'updateStatus'])->name('updateStatus');
        });

        // --------------------------------------------------------
        // 🧾 Activity Logs
        // --------------------------------------------------------
        Route::get('/logs', [AdminUserLogController::class, 'index'])->name('logs.index');

        // --------------------------------------------------------
        // 📊 Reports (รายงาน)
        // --------------------------------------------------------
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
        Route::get('/reports/summary', [ReportController::class, 'summaryReport'])->name('reports.summary');

        // --------------------------------------------------------
        // 🏪 Onboarding Requests
        // --------------------------------------------------------
        Route::get('/onboarding', [OnboardingRequestController::class, 'index'])->name('onboarding.index');
        Route::get('/onboarding/{id}', [OnboardingRequestController::class, 'show'])->name('onboarding.show');
        Route::post('/onboarding/{id}/approve', [OnboardingRequestController::class, 'approve'])->name('onboarding.approve');
        Route::post('/onboarding/{id}/reject', [OnboardingRequestController::class, 'reject'])->name('onboarding.reject');

        // --------------------------------------------------------
        // 🏢 Branch Management
        // --------------------------------------------------------
        Route::prefix('branches')->name('branches.')->group(function () {
            Route::get('/', [BranchController::class, 'index'])->name('index');
            Route::get('/create', [BranchController::class, 'create'])->name('create');
            Route::post('/', [BranchController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BranchController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BranchController::class, 'update'])->name('update');
            Route::delete('/{id}', [BranchController::class, 'destroy'])->name('destroy');
        });
    });

// ============================================================
// 👤 Profile Routes
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// 🪪 Auth Routes
// ============================================================
require __DIR__ . '/auth.php';
