<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLog;
use App\Models\User;

class UserLogController extends Controller
{
    // 🧾 แสดงประวัติการทำงานทั้งหมดของผู้ดูแลระบบ
    // 🧾 แสดงประวัติการทำงานทั้งหมดของผู้ดูแลระบบ
    public function index(Request $request)
    {
        $search = $request->input('search');
        $adminId = $request->input('admin_id');
        $action = $request->input('action');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $query = UserLog::with(['admin', 'targetUser'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('action', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('targetUser', function ($target) use ($search) {
                            $target->where('name', 'like', "%$search%")
                                   ->orWhere('email', 'like', "%$search%");
                        })
                        ->orWhereHas('admin', function ($admin) use ($search) {
                            $admin->where('name', 'like', "%$search%")
                                  ->orWhere('email', 'like', "%$search%");
                        });
                });
            })
            ->when($adminId, function ($q) use ($adminId) {
                $q->where(function ($sub) use ($adminId) {
                    $sub->where('admin_id', $adminId)
                        ->orWhere('user_id', $adminId);
                });
            })
            ->when($action, function ($q) use ($action) {
                $q->where('action', $action);
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('created_at', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc');

        if ($request->query('export') === 'csv') {
            $logsForExport = $query->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=\"activity_logs.csv\"',
            ];

            $callback = function () use ($logsForExport) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Admin', 'Action', 'Description', 'Target User', 'Created At']);

                foreach ($logsForExport as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->admin->name ?? 'System',
                        $log->action,
                        $log->description,
                        $log->targetUser->name ?? '-',
                        $log->created_at,
                    ]);
                }

                fclose($handle);
            };

            return response()->streamDownload($callback, 'activity_logs.csv', $headers);
        }

        $logs = $query->paginate($perPage)->withQueryString();

        // Data for filters
        $admins = User::orderBy('name')->get();
        $actions = UserLog::select('action')->distinct()->orderBy('action')->pluck('action');

        return view('admin.logs.index', compact(
            'logs',
            'search',
            'admins',
            'actions',
            'adminId',
            'action',
            'startDate',
            'endDate',
            'perPage'
        ));
    }
}
