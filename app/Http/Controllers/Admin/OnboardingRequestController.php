<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $requests = OnboardingRequest::with(['teller.branch', 'teller.unit', 'branch', 'unit'])
            ->where('approval_status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends(['status' => $status]);

        return view('admin.onboarding.index', compact('requests', 'status'));
    }

    public function show($id)
    {
        $req = OnboardingRequest::with(['teller.branch', 'teller.unit', 'branch', 'unit'])->findOrFail($id);
        return view('admin.onboarding.show', compact('req'));
    }

    public function approve(Request $request, $id)
    {
        $data = $request->validate([
            'pos_serial'   => 'required|array',
            'pos_serial.*' => 'required|string|max:255',
        ]);

        $req = OnboardingRequest::findOrFail($id);
        $req->approval_status = 'approved';
        $req->admin_remark = null;
        // Join the array into a comma-separated string
        $req->pos_serial = implode(',', $data['pos_serial']);
        $req->save();

        $tellerUserId = User::where('teller_id', $req->teller_id)->value('id');

        // Log Approve Request
        \App\Models\UserLog::create([
            'admin_id' => Auth::id(),
            'user_id' => $tellerUserId, // Target user is the teller (users.id)
            'action' => 'approve_request',
            'description' => "Approved request {$req->refer_code}",
            'details' => ['request_id' => $req->id, 'pos_serial' => $req->pos_serial],
        ]);

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

        $tellerUserId = User::where('teller_id', $req->teller_id)->value('id');

        // Log Reject Request
        \App\Models\UserLog::create([
            'admin_id' => Auth::id(),
            'user_id' => $tellerUserId, // Target user is the teller (users.id)
            'action' => 'reject_request',
            'description' => "Rejected request {$req->refer_code}",
            'details' => ['request_id' => $req->id, 'remark' => $req->admin_remark],
        ]);

        return back()->with('success', 'Request rejected.');
    }
}
