<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnboardingRequestResource;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\UserLog;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index(Request $request)
    {
        $query = OnboardingRequest::visibleTo($request->user())
            ->with(['branch', 'unit', 'teller'])
            ->orderByDesc('created_at');

        if ($status = $request->query('status')) {
            $query->where('approval_status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('refer_code', 'like', "%{$search}%")
                    ->orWhere('store_name', 'like', "%{$search}%")
                    ->orWhere('teller_id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;

        $requests = $query->paginate($perPage)->withQueryString();

        return OnboardingRequestResource::collection($requests);
    }

    public function show(int $id)
    {
        $record = OnboardingRequest::visibleTo(request()->user())
            ->with(['branch', 'unit', 'teller'])
            ->findOrFail($id);

        return new OnboardingRequestResource($record);
    }

    public function approve(Request $request, int $id)
    {
        $record = OnboardingRequest::visibleTo($request->user())->findOrFail($id);

        if ($record->approval_status === 'approved') {
            return new OnboardingRequestResource($record->load(['branch', 'unit', 'teller']));
        }

        $record->update([
            'approval_status' => 'approved',
            'admin_remark' => $request->input('admin_remark'),
        ]);

        $this->log($request, 'approve_request', $record);

        return new OnboardingRequestResource($record->fresh(['branch', 'unit', 'teller']));
    }

    public function reject(Request $request, int $id)
    {
        $record = OnboardingRequest::visibleTo($request->user())->findOrFail($id);

        $data = $request->validate([
            'admin_remark' => ['required', 'string', 'max:500'],
        ]);

        $record->update([
            'approval_status' => 'rejected',
            'admin_remark' => $data['admin_remark'],
        ]);

        $this->log($request, 'reject_request', $record, $data['admin_remark']);

        return new OnboardingRequestResource($record->fresh(['branch', 'unit', 'teller']));
    }

    protected function log(Request $request, string $action, OnboardingRequest $record, ?string $remark = null): void
    {
        $record->loadMissing('teller');

        UserLog::create([
            'admin_id' => $request->user()->id,
            'user_id' => optional($record->teller)->id,
            'action' => $action,
            'description' => sprintf('%s request %s', ucfirst(str_replace('_', ' ', $action)), $record->refer_code),
            'details' => [
                'request_id' => $record->id,
                'status' => $record->approval_status,
                'remark' => $remark,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);
    }
}
