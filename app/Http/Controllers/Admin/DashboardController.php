<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ใช้ Model จากฐาน teller_portal
        $total_pos   = OnboardingRequest::count();
        $approved    = OnboardingRequest::where('approval_status', 'approved')->count();
        $pending     = OnboardingRequest::where('approval_status', 'pending')->count();
        $rejected    = OnboardingRequest::where('approval_status', 'rejected')->count();

        return view('admin.dashboard', compact('total_pos', 'approved', 'pending', 'rejected'));
    }
}
