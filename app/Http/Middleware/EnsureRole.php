<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        $allowedRoles = collect($roles)
            ->flatMap(function ($value) {
                return explode(',', (string) $value);
            })
            ->map(fn($value) => trim($value))
            ->filter()
            ->values()
            ->all();

        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        // Admin bypass
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (empty($allowedRoles) || !in_array($user->role, $allowedRoles, true)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
