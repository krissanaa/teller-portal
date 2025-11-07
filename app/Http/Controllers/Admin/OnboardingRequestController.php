<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Http\Request;

class OnboardingRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $requests = OnboardingRequest::when(
                $status,
                fn ($query) => $query->where('approval_status', $status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['status' => $status]);

        return view('admin.onboarding.index', compact('requests', 'status'));
    }

    public function show($id)
    {
        $req = OnboardingRequest::findOrFail($id);
        return view('admin.onboarding.show', compact('req'));
    }

    public function approve($id)
    {
        $req = OnboardingRequest::findOrFail($id);
        $req->approval_status = 'approved';
        $req->save();
        return back()->with('success', 'Request approved.');
    }

    public function reject($id)
    {
        $req = OnboardingRequest::findOrFail($id);
        $req->approval_status = 'rejected';
        $req->save();
        return back()->with('success', 'Request rejected.');
    }
}
