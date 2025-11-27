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
            'teller_id' => ['required', 'string', 'max:10', 'unique:users,teller_id'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        // Create Teller (default status = pending)
        $user = User::create([
            'teller_id' => $request->teller_id,
            'name' => 'APB ' . $request->teller_id,
            'phone' => null,
            'password' => Hash::make($request->password),
            'role' => 'teller',
            'status' => 'pending',
            'profile_completed_at' => null,
        ]);

        event(new Registered($user));

        // 📝 Log Registration
        \App\Models\UserLog::create([
            'admin_id' => $user->id,
            'user_id' => $user->id,
            'action' => 'register',
            'description' => "User {$user->name} registered",
            'details' => ['teller_id' => $user->teller_id]
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'ລົງທະບຽນສຳເລັດ');
    }
}
