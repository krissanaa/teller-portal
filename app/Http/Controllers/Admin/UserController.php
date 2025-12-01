<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('role', 'teller')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%"))
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page', 5));

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role'     => 'teller',
            'status'   => 'approved',
        ]);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'create',
            'description' => 'Created Teller user: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Teller created successfully.');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'teller_id' => 'required|string|unique:users,teller_id',
            'password'  => 'required|string|min:6',
        ]);

        $user = User::create([
            'teller_id' => $validated['teller_id'],
            'name'      => 'Admin ' . $validated['teller_id'],
            'email'     => $validated['teller_id'] . '@apb.com.la',
            'phone'     => '-',
            'password'  => Hash::make($validated['password']),
            'role'      => 'admin',
            'status'    => 'approved',
        ]);

        UserLog::create([
            'admin_id'    => Auth::id(),
            'action'      => 'create_admin',
            'description' => 'Created Admin user: ' . $user->name,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user->update($validated);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'update',
            'description' => 'Updated Teller user: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Teller updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'delete',
            'description' => 'Deleted Teller user: ' . $name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Teller deleted.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = '123456';

        $user->update(['password' => Hash::make($newPassword)]);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'reset_password',
            'description' => 'Reset password for Teller: ' . $user->name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', "🔑 Password reset to '{$newPassword}' for {$user->name}");
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $newStatus = $request->input('status');

        // ตรวจสอบว่าค่าสถานะถูกต้อง
        if (!in_array($newStatus, ['approved', 'pending', 'rejected'])) {
            return back()->with('error', 'Invalid status.');
        }

        $user->update(['status' => $newStatus]);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'update_status',
            'description' => "Changed status of Teller {$user->name} to {$newStatus}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "Teller {$user->name} has been {$newStatus}.");
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
