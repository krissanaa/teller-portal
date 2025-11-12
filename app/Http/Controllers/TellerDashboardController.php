<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TellerDashboardController extends Controller
{
    // 🏠 Dashboard: แสดงฟอร์ม Pending
    public function index()
    {
        $tellerId = Auth::user()->teller_id;

        $requests = OnboardingRequest::where('teller_id', $tellerId)
            ->whereIn('approval_status', ['pending', 'rejected'])
            ->with('branch')
            ->orderByDesc('updated_at')
            ->paginate(10);

        // 🔔 แจ้งเตือน 7 วันล่าสุด (อนุมัติ/ปฏิเสธ)
        $notifications = OnboardingRequest::where('teller_id', $tellerId)
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->whereDate('updated_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        return view('teller.dashboard', compact('requests', 'notifications'));
    }

    // 📊 รายงาน (Approved เท่านั้น)
    public function report()
    {
        $tellerId = Auth::user()->teller_id;

        $requests = OnboardingRequest::where('teller_id', $tellerId)
            ->where('approval_status', 'approved')
            ->with('branch')
            ->orderByDesc('created_at')
            ->paginate(10);

        $notifications = OnboardingRequest::where('teller_id', $tellerId)
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->latest()
            ->take(5)
            ->get();

        return view('teller.reports.index', compact('requests', 'notifications'));
    }

    // 🔐 เปลี่ยนรหัสผ่าน
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '❌ รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '✅ เปลี่ยนรหัสผ่านสำเร็จแล้ว');
    }
}
