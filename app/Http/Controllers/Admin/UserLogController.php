<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLog;
use App\Models\User;

class UserLogController extends Controller
{
    // 🧾 แสดงประวัติการทำงานทั้งหมดของผู้ดูแลระบบ
    public function index(Request $request)
    {
        $search = $request->input('search');

        $logs = UserLog::with(['admin', 'targetUser'])
            ->when($search, function ($q) use ($search) {
                $q->where('action', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.logs.index', compact('logs', 'search'));
    }
}
