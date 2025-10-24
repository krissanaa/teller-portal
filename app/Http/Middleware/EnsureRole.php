<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        // ✅ ให้ admin ผ่านได้ทุกหน้า
        if (!$user || ($user->role !== $role && $user->role !== 'admin')) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
