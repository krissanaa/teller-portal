<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        // ✅ สร้าง user แต่สถานะเริ่มต้นคือ pending
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teller',
            'status' => 'pending',
        ]);

        event(new Registered($user));

        // ❌ ไม่ login ทันที
        // Auth::login($user);

        // ✅ แสดง popup แล้ว redirect ไป login
        return redirect()
            ->route('login')
            ->with('success', 'ລົງທະບຽນສຳເລັດ');
    }
}
