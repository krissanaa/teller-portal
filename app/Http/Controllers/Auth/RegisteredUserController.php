<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('id')->get();
        $units = BranchUnit::orderBy('id')->get();

        return view('auth.register', compact('branches', 'units'));
    }

    public function store(Request $request)
    {
        $branchId = $request->input('branch_id');

        $unitRule = ['nullable'];
        if ($branchId) {
            $unitRule[] = Rule::exists('teller_portal.branch_unit', 'id')->where(fn($q) => $q->where('branch_id', $branchId));
        }

        $validated = $request->validate([
            'teller_id' => ['required', 'string', 'max:10', 'unique:users,teller_id'],
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:50'],
            'branch_id' => ['required', Rule::exists('teller_portal.branch', 'id')],
            'unit_id'   => $unitRule,
            'password'  => ['required', 'confirmed', 'min:6'],
            'attachments.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max per file
        ]);

        // If the branch has units, a unit selection is required.
        $branchHasUnits = BranchUnit::where('branch_id', $branchId)->exists();
        if ($branchHasUnits && empty($validated['unit_id'])) {
            return back()
                ->withErrors(['unit_id' => __('ເລືອກໜ່ວຍບໍລິການສໍາລັບສາຂານີ້')])
                ->withInput();
        }

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('user_attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }

        // Create Teller (default status = pending)
        $user = User::create([
            'teller_id' => $request->teller_id,
            'name'      => $request->name,
            'phone'     => $request->phone,
            'branch_id' => $request->branch_id,
            'unit_id'   => $request->unit_id ?: null,
            'password'  => Hash::make($request->password),
            'role'      => 'teller',
            'status'    => 'pending',
            'profile_completed_at' => null,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
        ]);

        event(new Registered($user));

        // Broadcast new user registration to admin
        $pendingUsersCount = User::where('status', 'pending')->count();
        event(new \App\Events\NewUserRegistered($user, $pendingUsersCount));

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
