<?php

namespace App\Http\Controllers\Teller;

use App\Events\NewOnboardingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\BranchUnit;
use App\Models\TellerPortal\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class OnboardingController extends Controller
{
    // 💻 ฟอร์มสร้างคำขอใหม่
    public function create()
    {
        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        $branches = Branch::orderBy('BRANCH_NAME')->get();
        $units = BranchUnit::orderBy('unit_name')->get();
        return view('teller.requests.create', compact('tellerProfile', 'branches', 'units'));
    }

    // 📨 บันทึกคำขอใหม่
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name'        => 'required|string|max:255',
            'business_type'     => 'nullable|string|max:255',
            'store_address'     => 'nullable|string',
            'pos_serial'        => 'nullable|string|max:255',
            'bank_account'      => 'nullable|string|max:255',
            'installation_date' => 'required|date',
            'attachments.*'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'total_device_pos'  => 'required|integer|min:1',
        ]);

        $data['pos_serial'] = trim($data['pos_serial'] ?? '') ?: null;

        // Auto-assign Branch and Unit from Teller Profile
        $data['branch_id'] = Auth::user()->branch_id;
        $data['unit_id'] = Auth::user()->unit_id;

        $this->ensureUnitMatchesBranch($data['branch_id'], $data['unit_id']);

        // จัดเก็บไฟล์แนบ
        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($paths) ? json_encode($paths) : null;
        $data['teller_id'] = Auth::user()->teller_id;
        $data['approval_status'] = 'pending';

        $req = DB::transaction(function () use (&$data) {
            $latest = OnboardingRequest::lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($latest) {
                $raw = (string) ($latest->refer_code ?? '');
                $lastNumeric = preg_match('/^\d+$/', $raw) ? $raw : (string) $latest->id;
                $nextNumber = (int) substr(str_pad($lastNumeric, 8, '0', STR_PAD_LEFT), -8) + 1;
            }

            // Format ໃໝ່: ເລກ 8 ຫຼັກ (ເພີ່ມ 0 ນຳໜ້າ)
            $data['refer_code'] = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);

            $req = OnboardingRequest::create($data);

            // 📝 Log Create Request
            \App\Models\UserLog::create([
                'admin_id' => Auth::id(),
                'user_id' => Auth::id(),
                'action' => 'create_request',
                'description' => "Created request {$req->refer_code}",
                'details' => ['request_id' => $req->id, 'store_name' => $req->store_name]
            ]);

            return $req;
        });

        Cache::forget('pending_onboarding_count');
        NewOnboardingRequest::dispatch($req);

        return redirect()->route('teller.dashboard')->with('success', 'ສ້າງຄຳຂໍສຳເລັດ');
    }

    // ✏️ แก้ไขคำขอ
    public function edit($id)
    {
        $request = OnboardingRequest::ownedBy(Auth::user())
            ->where('id', $id)
            ->firstOrFail();

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);

        return view('teller.requests.edit', compact('request', 'tellerProfile'));
    }

    // ✏️ อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $record = OnboardingRequest::ownedBy(Auth::user())->findOrFail($id);
        $wasRejected = $record->approval_status === 'rejected';

        $data = $request->validate([
            'store_name'         => 'required|string|max:255',
            'business_type'      => 'nullable|string|max:255',
            'store_address'      => 'nullable|string',
            'pos_serial'         => 'nullable|string|max:255',
            'bank_account'       => 'nullable|string|max:50',
            'installation_date'  => 'required|date',

            'attachments.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'delete_attachments' => 'array',
            'delete_attachments.*' => 'integer',
            'total_device_pos'   => 'required|integer|min:1',
        ]);
        $data['pos_serial'] = trim($data['pos_serial'] ?? '') ?: null;


        // ดึงรายการไฟล์เดิม
        $existing = json_decode($record->attachments ?? '[]', true);

        // ลบไฟล์ที่เลือก
        $toDelete = $request->input('delete_attachments', []);
        foreach ($toDelete as $idx) {
            if (isset($existing[$idx])) {
                Storage::disk('public')->delete($existing[$idx]);
                unset($existing[$idx]);
            }
        }
        $existing = array_values($existing);

        // เพิ่มไฟล์ใหม่
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $existing[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($existing) ? json_encode($existing) : null;



        // อัปเดตข้อมูล
        $record->update($data);

        // 📝 Log Update Request
        \App\Models\UserLog::create([
            'admin_id' => Auth::id(),
            'user_id' => Auth::id(),
            'action' => 'update_request',
            'description' => "Updated request {$record->refer_code}",
            'details' => ['request_id' => $record->id, 'changes' => array_keys($data)]
        ]);

        if ($wasRejected) {
            $record->approval_status = 'pending';
            $record->admin_remark = null;
            $record->save();
        }

        return redirect()
            ->route('teller.requests.show', $record->id)
            ->with('success', 'ແກ້ໄຂສຳເລັດ');
    }

    // 📄 แสดงรายละเอียด
    public function show($id)
    {
        $request = OnboardingRequest::visibleTo(Auth::user())
            ->where('id', $id)
            ->with(['branch', 'unit', 'teller'])
            ->firstOrFail();

        return view('teller.requests.show', compact('request'));
    }

    protected function ensureUnitMatchesBranch(?int $branchId, ?int $unitId): void
    {
        if (!$unitId) {
            return;
        }

        if (!$branchId) {
            throw ValidationException::withMessages([
                'branch_id' => __('ກະລຸນາເລືອກສາຂາ'),
            ]);
        }

        $unit = BranchUnit::find($unitId);

        if (!$unit) {
            throw ValidationException::withMessages([
                'unit_id' => __('ຫາຂໍ້ມູນຫ້ອງກວດບໍ່ເຈີ'),
            ]);
        }

        if ($branchId && (int) $unit->branch_id !== (int) $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('ຫ້ອງກວດກັບສາຂາທີ່ເລືອກ'),
            ]);
        }
    }
}
