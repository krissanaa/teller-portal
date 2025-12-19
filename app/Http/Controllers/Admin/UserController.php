<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->with(['branch', 'unit'])
            ->when($search, fn($q) => $q->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('teller_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            }))
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page', 10));

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $actor = $request->user();

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'branch_id' => 'nullable|exists:App\Models\TellerPortal\Branch,id',
            'unit_id' => 'nullable|exists:App\Models\TellerPortal\BranchUnit,id',
        ]);

        if ($actor->isBranchAdmin()) {
            $validated['branch_id'] = $actor->branch_id;
        }

        $this->ensureUnitMatchesBranch($validated['branch_id'] ?? null, $validated['unit_id'] ?? null);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'] ?? null,
            'phone'    => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'branch_id' => $validated['branch_id'] ?? null,
            'unit_id' => $validated['unit_id'] ?? null,
            'role'     => User::ROLE_TELLER,
            'status'   => User::STATUS_APPROVED,
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
        abort_unless($request->user()->isAdmin(), 403);

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

    public function edit(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:pending,approved,rejected',
            'branch_id' => 'nullable|exists:App\Models\TellerPortal\Branch,id',
            'unit_id' => 'nullable|exists:App\Models\TellerPortal\BranchUnit,id',
        ]);

        if ($request->user()->isBranchAdmin()) {
            $validated['branch_id'] = $request->user()->branch_id;
        }

        $this->ensureUnitMatchesBranch($validated['branch_id'] ?? null, $validated['unit_id'] ?? null);

        $user->update($validated);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'update',
            'description' => 'Updated Teller user: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Teller updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);
        $name = $user->name;
        $user->delete();

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'delete',
            'description' => 'Deleted Teller user: ' . $name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Teller deleted.');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);
        $newPassword = '123456';

        $user->update(['password' => Hash::make($newPassword)]);

        UserLog::create([
            'admin_id' => Auth::id(),
            'action' => 'reset_password',
            'description' => 'Reset password for Teller: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "🔑 Password reset to '{$newPassword}' for {$user->name}");
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);
        $newStatus = $request->input('status');

        // ตรวจสอบວ່າค่าสถานะถูกต้อง
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
    public function show(Request $request, $id)
    {
        $user = User::manageableBy($request->user())
            ->where('role', User::ROLE_TELLER)
            ->findOrFail($id);

        $branchesQuery = \App\Models\TellerPortal\Branch::orderBy('id');
        $unitsQuery = \App\Models\TellerPortal\BranchUnit::orderBy('id');

        if ($request->user()->isBranchAdmin()) {
            $branchesQuery->where('id', $request->user()->branch_id);
            $unitsQuery->where('branch_id', $request->user()->branch_id);
        }

        $branches = $branchesQuery->get();
        $units = $unitsQuery->get();

        return view('admin.users.show', compact('user', 'branches', 'units'));
    }

    protected function ensureUnitMatchesBranch(?int $branchId, ?int $unitId): void
    {
        if (!$unitId) {
            return;
        }

        $unit = \App\Models\TellerPortal\BranchUnit::find($unitId);

        if (!$unit) {
            throw ValidationException::withMessages([
                'unit_id' => __('The selected unit is invalid.'),
            ]);
        }

        if ($branchId && (int) $unit->branch_id !== (int) $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('The selected unit does not belong to the provided branch.'),
            ]);
        }
    }
}
