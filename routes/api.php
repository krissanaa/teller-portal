<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\TellerRequestController;
use App\Http\Controllers\Api\Admin\TellerController as AdminTellerController;
use App\Http\Controllers\Api\Admin\OnboardingController as AdminOnboardingController;
use App\Http\Controllers\Api\Admin\LogController as AdminLogController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->name('api.auth.login')
        ->withoutMiddleware([ThrottleRequests::class, 'throttle:api']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('meta/branches', [MetaController::class, 'branches'])->name('api.meta.branches');

    Route::prefix('teller')->middleware('role:teller')->name('api.teller.')->group(function () {
        Route::get('requests', [TellerRequestController::class, 'index'])->name('requests.index');
        Route::post('requests', [TellerRequestController::class, 'store'])->name('requests.store');
        Route::get('requests/{id}', [TellerRequestController::class, 'show'])->name('requests.show');
        Route::put('requests/{id}', [TellerRequestController::class, 'update'])->name('requests.update');
        Route::post('requests/{id}/resubmit', [TellerRequestController::class, 'resubmit'])->name('requests.resubmit');
    });

    Route::prefix('admin')->middleware('role:admin')->name('api.admin.')->group(function () {
        Route::get('logs', [AdminLogController::class, 'index'])->name('logs.index');

        Route::get('requests', [AdminOnboardingController::class, 'index'])->name('requests.index');
        Route::get('requests/{id}', [AdminOnboardingController::class, 'show'])->name('requests.show');
        Route::post('requests/{id}/approve', [AdminOnboardingController::class, 'approve'])->name('requests.approve');
        Route::post('requests/{id}/reject', [AdminOnboardingController::class, 'reject'])->name('requests.reject');

        Route::get('tellers', [AdminTellerController::class, 'index'])->name('tellers.index');
        Route::post('tellers', [AdminTellerController::class, 'store'])->name('tellers.store');
        Route::get('tellers/{teller}', [AdminTellerController::class, 'show'])->name('tellers.show');
        Route::put('tellers/{teller}', [AdminTellerController::class, 'update'])->name('tellers.update');
        Route::delete('tellers/{teller}', [AdminTellerController::class, 'destroy'])->name('tellers.destroy');
        Route::patch('tellers/{teller}/status', [AdminTellerController::class, 'updateStatus'])->name('tellers.update-status');
    });
});
