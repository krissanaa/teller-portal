<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Http\Request;

class OnboardingRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $requests = OnboardingRequest::where('approval_status', $status)
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

    public function approve(Request $request, $id)
    {
        $data = $request->validate([
            'pos_serial' => 'required|string|max:255',
        ]);

        $req = OnboardingRequest::findOrFail($id);
        $req->approval_status = 'approved';
        $req->admin_remark = null;
        $req->pos_serial = $data['pos_serial'];
        $req->save();
        return back()->with('success', 'Request approved.');
    }

    public function reject(Request $request, $id)
    {
        $data = $request->validate([
            'admin_remark' => 'required|string|max:500',
        ]);

        $req = OnboardingRequest::findOrFail($id);
        $req->approval_status = 'rejected';
        $req->admin_remark = $data['admin_remark'];
        $req->save();
        return back()->with('success', 'Request rejected.');
    }
}
