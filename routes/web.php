<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// 🧭 Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserLogController as AdminUserLogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\OnboardingRequestController as AdminOnboardingRequestController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\OnboardingRequestController as WorkflowOnboardingRequestController;

// 🧭 Teller Controllers
use App\Http\Controllers\TellerDashboardController;
use App\Http\Controllers\Teller\OnboardingController;
use App\Http\Controllers\Teller\ReportController as TellerReportController;

// ============================================================
// 🏠 หน้าแรก (Redirect ไปหน้า Login)
// ============================================================
Route::get('/', fn() => redirect()->route('login'));

// ============================================================
// 🔐 หลัง Login — ส่งผู้ใช้ไปยัง Dashboard ตาม Role
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

        // --------------------------------------------------------
        // 🏠 Dashboard (เฉพาะ Pending)
        // --------------------------------------------------------
        Route::get('/dashboard', [TellerDashboardController::class, 'index'])->name('dashboard');

        // --------------------------------------------------------
        // 📊 รายงานฟอร์มที่อนุมัติแล้ว (Approved)
        // --------------------------------------------------------
        Route::get('/report', [TellerReportController::class, 'index'])->name('report');

        // --------------------------------------------------------
        // 🔐 เปลี่ยนรหัสผ่าน
        // --------------------------------------------------------
        Route::post('/change-password', [TellerDashboardController::class, 'changePassword'])
            ->name('changePassword');

        Route::post('/profile/complete', [TellerDashboardController::class, 'completeProfile'])
            ->name('profile.complete');

        // --------------------------------------------------------
        // 🧾 Onboarding Requests (สมัครร้านค้า POS)
        // --------------------------------------------------------
        Route::get('/requests/create', [OnboardingController::class, 'create'])->name('requests.create');
        Route::post('/requests/store', [OnboardingController::class, 'store'])->name('requests.store');
        Route::get('/requests/{id}', [OnboardingController::class, 'show'])->name('requests.show');
        Route::get('/requests/{id}/edit', [OnboardingController::class, 'edit'])->name('requests.edit');
        Route::put('/requests/{id}', [OnboardingController::class, 'update'])->name('requests.update');

        // --------------------------------------------------------
        // dY_ Workflow กลางสำหรับ submit/resubmit (ใช้ status/remark)
        // --------------------------------------------------------
        Route::post('/onboarding/submit', [WorkflowOnboardingRequestController::class, 'submitForm'])
            ->name('onboarding.submit');
        Route::post('/onboarding/{onboardingRequest}/resubmit', [WorkflowOnboardingRequestController::class, 'resubmitForm'])
            ->name('onboarding.resubmit');
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
        // 👥 Teller Management (CRUD + Approve/Reject + Reset Password)
        // --------------------------------------------------------
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminUserController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/status', [AdminUserController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('resetPassword');
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
        // 🏪 Onboarding Requests (POS Registration)
        // --------------------------------------------------------
        Route::get('/onboarding', [AdminOnboardingRequestController::class, 'index'])->name('onboarding.index');
        Route::get('/onboarding/{id}', [AdminOnboardingRequestController::class, 'show'])->name('onboarding.show');
        Route::post('/onboarding/{id}/approve', [AdminOnboardingRequestController::class, 'approve'])->name('onboarding.approve');
        Route::post('/onboarding/{id}/reject', [AdminOnboardingRequestController::class, 'reject'])->name('onboarding.reject');

        // --------------------------------------------------------
        // dY_ เส้นทางใหม่เพื่อเรียก controller กลาง (approve/reject รุ่น remark)
        // --------------------------------------------------------
        Route::post('/onboarding-flow/{onboardingRequest}/approve', [WorkflowOnboardingRequestController::class, 'approveForm'])
            ->name('onboarding.flow.approve');
        Route::post('/onboarding-flow/{onboardingRequest}/reject', [WorkflowOnboardingRequestController::class, 'rejectForm'])
            ->name('onboarding.flow.reject');

        // --------------------------------------------------------
        // 🏢 Branch Management (CRUD)
        // --------------------------------------------------------
        Route::prefix('branches')->name('branches.')->group(function () {
            Route::get('/', [BranchController::class, 'index'])->name('index');
            Route::get('/create', [BranchController::class, 'create'])->name('create');
            Route::post('/', [BranchController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BranchController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BranchController::class, 'update'])->name('update');
            Route::delete('/{id}', [BranchController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/units', [BranchController::class, 'storeUnit'])->name('units.store');
            Route::put('/{branch}/units/{unit}', [BranchController::class, 'updateUnit'])->name('units.update');
            Route::delete('/{branch}/units/{unit}', [BranchController::class, 'destroyUnit'])->name('units.destroy');
        });
    });

// ============================================================
// 👤 Profile Routes (ใช้ได้ทั้ง Admin / Teller)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// 🪪 Auth Routes (Login, Register, Forgot Password)
// ============================================================
require __DIR__ . '/auth.php';
