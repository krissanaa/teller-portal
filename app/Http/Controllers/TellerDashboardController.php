<?php

namespace App\Http\Controllers;

use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TellerDashboardController extends Controller
{
    public function index()
    {
        $tellerId = Auth::user()->teller_id;

        $requests = OnboardingRequest::where('teller_id', $tellerId)
            ->whereIn('approval_status', ['pending', 'rejected'])
            ->with('branch')
            ->orderByDesc('updated_at')
            ->paginate(10);

        $notifications = OnboardingRequest::where('teller_id', $tellerId)
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->whereDate('updated_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        return view('teller.dashboard', compact('requests', 'notifications'));
    }

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

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '�?O �,��,��,�,��,o�1^�,��,T�,>�,�,^�,^�,,�,s�,�,T�1,�,��1^�,-�,1�,?�,�1%�,-�,�']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '�o. �1?�,>�,��,�1^�,��,T�,��,��,�,��,o�1^�,��,T�,��,3�1?�,��1؅,^�1?�,��1%�,');
    }

    public function completeProfile(Request $request)
    {
        $request->validateWithBag('profileSetup', [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->profile_completed_at = now();
        $user->save();

        return back()->with('profileSetupSuccess', 'Profile information saved successfully.');
    }
}
