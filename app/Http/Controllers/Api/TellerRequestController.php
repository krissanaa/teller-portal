<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnboardingRequestResource;
use App\Models\TellerPortal\BranchUnit;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TellerRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $this->assertApprovedTeller($user);

        $status = $request->query('status');

        $query = OnboardingRequest::with(['branch', 'unit'])
            ->where('teller_id', $user->teller_id)
            ->orderByDesc('updated_at');

        if ($status) {
            $query->where('approval_status', $status);
        }

        $perPage = (int) $request->input('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;

        $requests = $query->paginate($perPage)->withQueryString();

        return OnboardingRequestResource::collection($requests);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $this->assertApprovedTeller($user);

        $data = $this->validatePayload($request);
        $data['teller_id'] = $user->teller_id;
        $data['approval_status'] = 'pending';
        $data['attachments'] = $this->collectAttachments($request);

        $connectionName = (new OnboardingRequest())->getConnectionName();
        $connection = DB::connection($connectionName);

        $creator = function () use ($data, $connectionName, $connection) {
            $payload = $data;

            $latestQuery = OnboardingRequest::on($connectionName)
                ->orderByDesc('id');

            if ($connection->getDriverName() !== 'sqlite') {
                $latestQuery->lockForUpdate();
            }

            $latest = $latestQuery->first();

            $nextNumber = 1;
            if ($latest) {
                $raw = (string) ($latest->refer_code ?? '');
                $lastNumeric = preg_match('/^\\d+$/', $raw) ? $raw : (string) $latest->id;
                $nextNumber = (int) substr(str_pad($lastNumeric, 8, '0', STR_PAD_LEFT), -8) + 1;
            }

            $payload['refer_code'] = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);

            return OnboardingRequest::on($connectionName)->create($payload);
        };

        $record = $connection->getDriverName() === 'sqlite'
            ? $creator()
            : $connection->transaction($creator);

        return (new OnboardingRequestResource($record->load(['branch', 'unit'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, int $id)
    {
        $record = $this->findOwnedRequest($request, $id);

        return new OnboardingRequestResource($record->load(['branch', 'unit']));
    }

    public function update(Request $request, int $id)
    {
        $record = $this->findOwnedRequest($request, $id);
        $wasRejected = $record->approval_status === 'rejected';

        $data = $this->validatePayload($request, true);

        $attachments = Arr::wrap($record->attachments);
        $toDelete = $request->input('delete_attachments', []);

        foreach ($toDelete as $index) {
            if (isset($attachments[$index])) {
                Storage::disk('public')->delete($attachments[$index]);
                unset($attachments[$index]);
            }
        }

        $attachments = array_values($attachments);
        $newUploads = $this->collectAttachments($request);
        $data['attachments'] = array_values(array_merge($attachments, $newUploads));

        $record->update($data);

        if ($wasRejected) {
            $record->update([
                'approval_status' => 'pending',
                'admin_remark' => null,
            ]);
        }

        return new OnboardingRequestResource($record->fresh(['branch', 'unit']));
    }

    public function resubmit(Request $request, int $id)
    {
        $record = $this->findOwnedRequest($request, $id);

        if ($record->approval_status !== 'rejected') {
            return response()->json([
                'message' => __('Only rejected requests can be resubmitted.'),
            ], 422);
        }

        $record->update([
            'approval_status' => 'pending',
            'admin_remark' => null,
        ]);

        return new OnboardingRequestResource($record->fresh(['branch', 'unit']));
    }

    protected function validatePayload(Request $request, bool $isUpdate = false): array
    {
        $branchTable = app()->environment('testing') ? 'branch' : 'teller_portal.branch';
        $unitTable = app()->environment('testing') ? 'branch_unit' : 'teller_portal.branch_unit';

        $rules = [
            'store_name' => ['required', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'store_address' => ['nullable', 'string'],
            'pos_serial' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'branch_id' => ['nullable', 'integer', Rule::exists($branchTable, 'id')],
            'unit_id' => ['nullable', 'integer', Rule::exists($unitTable, 'id')],
            'installation_date' => ['required', 'date'],
            'attachments' => ['sometimes', 'array'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'delete_attachments' => ['sometimes', 'array'],
            'delete_attachments.*' => ['integer', 'min:0'],
        ];

        if (! $isUpdate) {
            unset($rules['delete_attachments'], $rules['delete_attachments.*']);
        }

        $data = $request->validate($rules);
        $this->ensureUnitMatchesBranch($data['branch_id'] ?? null, $data['unit_id'] ?? null);

        return $data;
    }

    protected function collectAttachments(Request $request, array $base = []): array
    {
        if (! $request->hasFile('attachments')) {
            return $base;
        }

        $paths = $base;

        foreach ((array) $request->file('attachments') as $file) {
            $paths[] = $file->store('attachments', 'public');
        }

        return $paths;
    }

    protected function findOwnedRequest(Request $request, int $id): OnboardingRequest
    {
        $user = $request->user();
        $this->assertApprovedTeller($user);

        return OnboardingRequest::where('teller_id', $user->teller_id)->findOrFail($id);
    }

    protected function ensureUnitMatchesBranch(?int $branchId, ?int $unitId): void
    {
        if (! $unitId) {
            return;
        }

        if (! $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('A unit can only be selected after choosing a branch.'),
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
                'unit_id' => __('The selected unit does not belong to the provided branch.'),
            ]);
        }
    }

    protected function assertApprovedTeller($user): void
    {
        if ($user->role !== 'teller' && $user->role !== 'admin') {
            abort(403, __('Only tellers can access onboarding requests.'));
        }

        if ($user->role === 'teller' && $user->status !== 'approved') {
            abort(403, __('Your teller profile has not been approved yet.'));
        }
    }
}
