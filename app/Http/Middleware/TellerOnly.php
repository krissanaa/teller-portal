<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TellerOnly
{
    public function handle(Request $request, Closure $next)
    {
        // ❗ ปล่อยผ่านถ้ายังไม่ login (เพื่อเข้า /login ได้)
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // ✅ Admin สามารถเข้าได้ทุกหน้า
        if ($user->role === 'admin') {
            return $next($request);
        }

        // ✅ Teller เท่านั้น
        if ($user->role !== 'teller') {
            abort(403, 'Unauthorized access. Tellers only.');
        }

        return $next($request);
    }
}
