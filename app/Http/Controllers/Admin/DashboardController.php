<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cacheKey = $user && !$user->isAdmin()
            ? 'admin.dashboard.counts.branch.' . ($user->branch_id ?? 'none')
            : 'admin.dashboard.counts.all';

        // Cache counts briefly to reduce database round-trips.
        $counts = Cache::remember($cacheKey, 60, function () use ($user) {
            return OnboardingRequest::visibleTo($user)
                ->selectRaw("
                COUNT(*) as total_pos,
                SUM(CASE WHEN approval_status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN approval_status = 'rejected' THEN 1 ELSE 0 END) as rejected
            ")->first();
        });

        $total_pos = (int) ($counts->total_pos ?? 0);
        $approved  = (int) ($counts->approved ?? 0);
        $pending   = (int) ($counts->pending ?? 0);
        $rejected  = (int) ($counts->rejected ?? 0);

        return view('admin.dashboard', compact('total_pos', 'approved', 'pending', 'rejected'));
    }
}
