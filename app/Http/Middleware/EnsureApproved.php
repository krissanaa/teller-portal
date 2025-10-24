<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureApproved
{
    /**
     * ตรวจสอบว่า user ได้รับการอนุมัติหรือไม่
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ถ้ายังไม่ approved
       if (auth()->user()->role !== 'admin' && auth()->user()->status !== 'approved') {
    return redirect()->route('login')->withErrors([
        'email' => 'บัญชีของคุณยังไม่ได้รับการอนุมัติจากผู้ดูแลระบบ',
    ]);
}


        return $next($request);
    }
}
