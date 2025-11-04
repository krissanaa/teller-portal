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
    'teller_id' => ['required', 'string', 'max:10', 'unique:users'],
    'name' => ['required', 'string', 'max:255'],
    'phone' => ['nullable', 'string', 'max:20'],
    'password' => ['required', 'confirmed', 'min:6'],
]);


        // ✅ Create Teller (default status = pending)
        $user = User::create([
            'teller_id' => $request->teller_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'teller',
            'status' => 'pending',
        ]);

        event(new Registered($user));

        return redirect()
            ->route('login')
            ->with('success', 'ລົງທະບຽນສຳເລັດ! ກະລຸນາລໍຖ້າການອະນຸມັດ');
    }
}
