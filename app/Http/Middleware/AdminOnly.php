<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // ❗ ปล่อยผ่านถ้ายังไม่ login (เพื่อเข้า /login ได้)
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized access. Admins only.');
        }

        return $next($request);
    }
}
