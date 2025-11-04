<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // ถ้ายังไม่ approved → ออกจากระบบ + แจ้งเตือน
        if ($user && $user->status !== 'approved') {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'teller_id' => 'ບັນຊີຂອງທ່ານຍັງບໍ່ຖືກອະນຸມັດ ກະລຸນາລໍຖ້າ Admin ກ່ອນ.'
            ]);
        }

        return $next($request);
    }
}
