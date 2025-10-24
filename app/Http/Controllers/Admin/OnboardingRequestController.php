<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;

class OnboardingRequestController extends Controller
{
    public function index()
    {
        $requests = OnboardingRequest::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.onboarding.index', compact('requests'));
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
