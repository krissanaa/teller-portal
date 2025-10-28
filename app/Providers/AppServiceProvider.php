<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // ✅ ส่งตัวแปร $notifications ให้ทุกหน้า Teller layout โดยอัตโนมัติ
    View::composer('layouts.teller', function ($view) {
        if (Auth::check() && Auth::user()->role === 'teller') {
            $notifications = OnboardingRequest::where('teller_id', Auth::id())
                ->whereIn('approval_status', ['approved', 'rejected'])
                ->whereDate('updated_at', '>=', now()->subDays(7)) // ภายใน 7 วันล่าสุด
                ->latest()
                ->take(5)
                ->get();
        } else {
            $notifications = collect(); // ป้องกัน error
        }

        $view->with('notifications', $notifications);
    });
}

}
