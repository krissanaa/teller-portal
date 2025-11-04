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
        // Accept digit strings (1-10) to match registration rules
        'teller_id' => ['required', 'digits_between:1,10'],
        'password' => ['required'],
    ]);

    // Keep teller_id as string to preserve leading zeros

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        // Let /dashboard route decide based on user role
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'teller_id' => 'Teller ID ຫຼືລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ.',
    ]);
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
