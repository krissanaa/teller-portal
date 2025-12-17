<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserLogResource;
use App\Models\UserLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $actor = $request->user();
        $query = UserLog::with(['admin', 'targetUser'])
            ->when($actor && $actor->isBranchAdmin(), function ($q) use ($actor) {
                $q->where(function ($sub) use ($actor) {
                    $sub->whereHas('targetUser', function ($target) use ($actor) {
                        $target->where('branch_id', $actor->branch_id);
                    })->orWhereHas('admin', function ($admin) use ($actor) {
                        $admin->where('branch_id', $actor->branch_id);
                    });
                });
            })
            ->orderByDesc('created_at');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;

        $logs = $query->paginate($perPage)->withQueryString();

        return UserLogResource::collection($logs);
    }
}
