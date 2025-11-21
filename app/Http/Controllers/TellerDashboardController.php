<?php

namespace App\Http\Controllers;

use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $data = $request->validateWithBag('profileSetup', [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'branch_id' => ['required', 'integer'],
            'unit_id' => ['nullable', 'integer'],
        ]);

        $branch = Branch::with('units')->find($data['branch_id']);
        if (!$branch) {
            throw ValidationException::withMessages([
                'branch_id' => __('ສາຂາທີ່ເລືອກບໍ່ຖືກຕ້ອງ'),
            ])->errorBag('profileSetup');
        }

        $selectedUnitId = $data['unit_id'] ?? null;
        $branchHasUnits = $branch->units->isNotEmpty();
        $unitModel = null;

        if ($branchHasUnits && !$selectedUnitId) {
            throw ValidationException::withMessages([
                'unit_id' => __('ກະລຸນາເລືອກຫນ່ວຍຍ່ອຍຂອງສາຂານີ້'),
            ])->errorBag('profileSetup');
        }

        if ($selectedUnitId) {
            $unitModel = BranchUnit::where('branch_id', $branch->id)->find($selectedUnitId);
            if (!$unitModel) {
                throw ValidationException::withMessages([
                    'unit_id' => __('ຫນ່ວຍຍ່ອຍບໍ່ກົງກັບສາຂາທີ່ເລືອກ'),
                ])->errorBag('profileSetup');
            }
        }

        $user = $request->user();
        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->branch_id = $branch->id;
        $user->unit_id = $unitModel?->id;
        $user->profile_completed_at = now();
        $user->save();

        return back()->with('profileSetupSuccess', 'Profile information saved successfully.');
    }
}
