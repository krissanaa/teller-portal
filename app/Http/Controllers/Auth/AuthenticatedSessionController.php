<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * แสดงหน้า login form
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * ประมวลผลการ login
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // ✅ ตรวจสิทธิ์
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'teller') {
                if ($user->status !== 'approved') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'บัญชีของคุณยังไม่ได้รับการอนุมัติจากผู้ดูแลระบบ',
                    ]);
                }
                return redirect()->intended(route('teller.dashboard'));
            }

            Auth::logout();
            return back()->withErrors(['email' => 'ไม่พบสิทธิ์ผู้ใช้นี้ในระบบ']);
        }

        return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }

    /**
     * logout
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
