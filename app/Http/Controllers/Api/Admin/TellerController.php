<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\TellerPortal\BranchUnit;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->with(['branch', 'unit'])
            ->where('role', 'teller')
            ->orderByDesc('created_at');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('teller_id', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->input('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;

        $tellers = $query->paginate($perPage)->withQueryString();

        return UserResource::collection($tellers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teller_id' => ['required', 'string', 'max:10', 'unique:users,teller_id'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
            'branch_id' => ['nullable', 'integer', $this->branchExistsRule()],
            'unit_id' => ['nullable', 'integer', $this->unitExistsRule()],
        ]);

        $this->ensureUnitMatchesBranch($data['branch_id'] ?? null, $data['unit_id'] ?? null);

        $payload = $data;
        $payload['role'] = 'teller';
        $payload['status'] = $payload['status'] ?? 'pending';
        $payload['password'] = Hash::make($payload['password']);

        $teller = User::create($payload);

        $this->logAction($request, 'create_teller', "Created teller {$teller->name}", $teller, [
            'payload' => Arr::except($data, ['password']),
        ]);

        return (new UserResource($teller->fresh(['branch', 'unit'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(User $teller)
    {
        $this->ensureTeller($teller);

        return new UserResource($teller->load(['branch', 'unit']));
    }

    public function update(Request $request, User $teller)
    {
        $this->ensureTeller($teller);

        $data = $request->validate([
            'teller_id' => ['required', 'string', 'max:10', Rule::unique('users', 'teller_id')->ignore($teller->id)],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teller->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'password' => ['nullable', 'string', 'min:6'],
            'branch_id' => ['nullable', 'integer', $this->branchExistsRule()],
            'unit_id' => ['nullable', 'integer', $this->unitExistsRule()],
        ]);

        $this->ensureUnitMatchesBranch($data['branch_id'] ?? null, $data['unit_id'] ?? null);

        $payload = $data;

        if (empty($payload['password'])) {
            unset($payload['password']);
        } else {
            $payload['password'] = Hash::make($payload['password']);
        }

        $teller->update($payload);

        $this->logAction($request, 'update_teller', "Updated teller {$teller->name}", $teller, [
            'payload' => Arr::except($data, ['password']),
        ]);

        return new UserResource($teller->fresh(['branch', 'unit']));
    }

    public function destroy(Request $request, User $teller)
    {
        $this->ensureTeller($teller);

        $name = $teller->name;
        $teller->delete();

        $this->logAction($request, 'delete_teller', "Deleted teller {$name}", $teller);

        return response()->json([
            'message' => __('Teller deleted successfully.'),
        ]);
    }

    public function updateStatus(Request $request, User $teller)
    {
        $this->ensureTeller($teller);

        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $teller->update($data);

        $this->logAction($request, 'update_teller_status', "Updated {$teller->name} status to {$data['status']}", $teller);

        return new UserResource($teller->fresh(['branch', 'unit']));
    }

    protected function ensureTeller(User $user): void
    {
        if ($user->role !== 'teller') {
            abort(404);
        }
    }

    protected function ensureUnitMatchesBranch(?int $branchId, ?int $unitId): void
    {
        if (! $unitId) {
            return;
        }

        if (! $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('select a branch before assigning a unit.'),
            ]);
        }

        $unit = BranchUnit::find($unitId);

        if (! $unit) {
            throw ValidationException::withMessages([
                'unit_id' => __('The selected unit is invalid.'),
            ]);
        }

        if ((int) $unit->branch_id !== (int) $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('The unit does not belong to the specified branch.'),
            ]);
        }
    }

    protected function branchExistsRule()
    {
        $table = app()->environment('testing') ? 'branch' : 'teller_portal.branch';

        return Rule::exists($table, 'id');
    }

    protected function unitExistsRule()
    {
        $table = app()->environment('testing') ? 'branch_unit' : 'teller_portal.branch_unit';

        return Rule::exists($table, 'id');
    }

    protected function logAction(Request $request, string $action, string $description, User $target, array $details = []): void
    {
        UserLog::create([
            'admin_id' => $request->user()->id,
            'user_id' => $target->id,
            'action' => $action,
            'description' => $description,
            'details' => array_merge($details, [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]),
        ]);
    }
}
