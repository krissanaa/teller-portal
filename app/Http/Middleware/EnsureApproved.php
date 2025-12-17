<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->isAdmin() && $user->status !== User::STATUS_APPROVED) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'teller_id' => '…§s…§ñ…§T…§S…§æ…§,…§-…§Ø…§-…¯^…§ý…§T…§?…§ñ…§Ø…§s…¯?…¯^…§-…§ú…§?…§-…§ø…§T…§,…§­…§ñ…§" …§?…§ø…§…§,…§T…§ý…§…¯?…§-…¯%…§ý Admin …§?…¯^…§-…§T.'
            ]);
        }

        return $next($request);
    }
}
