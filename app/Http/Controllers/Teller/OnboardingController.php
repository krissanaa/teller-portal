<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\BranchUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OnboardingController extends Controller
{
    // 🧾 ฟอร์มสร้างคำขอใหม่
    public function create()
    {
        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        return view('teller.requests.create', compact('tellerProfile'));
    }

    // 💾 บันทึกคำขอใหม่
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name'        => 'required|string|max:255',
            'business_type'     => 'nullable|string|max:255',
            'store_address'     => 'nullable|string',
            'pos_serial'        => 'nullable|string|max:255',
            'bank_account'      => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'attachments.*'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        $data['branch_id'] = $tellerProfile->branch_id;
        $data['unit_id'] = $tellerProfile->unit_id;

        $this->ensureUnitMatchesBranch($data['branch_id'], $data['unit_id']);

        // ✅ อัปโหลดไฟล์แนบ
        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($paths) ? json_encode($paths) : null;
        $data['teller_id'] = Auth::user()->teller_id;
        $data['approval_status'] = 'pending';

        // ✅ ใช้ Transaction + Lock ป้องกัน refer_code ซ้ำ
        DB::transaction(function () use (&$data) {
            $today = now()->format('Ymd');

            $latestToday = OnboardingRequest::whereDate('created_at', today())
                ->where('refer_code', 'like', 'REF-' . $today . '-%')
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($latestToday && preg_match('/REF-' . $today . '-(\d+)/', $latestToday->refer_code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            // ✅ Format: REF-YYYYMMDD-XXX
            $data['refer_code'] = 'REF-' . $today . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            OnboardingRequest::create($data);
        });

        return redirect()->route('teller.dashboard')->with('success');
    }

    // 🧰 ฟอร์มแก้ไข
    public function edit($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::user()->teller_id)
            ->firstOrFail();

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);

        return view('teller.requests.edit', compact('request', 'tellerProfile'));
    }

    // 🔄 อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $record = OnboardingRequest::where('teller_id', auth()->user()->teller_id)->findOrFail($id);
        $wasRejected = $record->approval_status === 'rejected';

        $data = $request->validate([
            'store_name'         => 'required|string|max:255',
            'business_type'      => 'nullable|string|max:255',
            'store_address'      => 'nullable|string',
            'pos_serial'         => 'nullable|string|max:255',
            'bank_account'       => 'nullable|string|max:50',
            'installation_date'  => 'nullable|date',
            'attachments.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'delete_attachments' => 'array',
            'delete_attachments.*' => 'integer',
        ]);

        // ดึงรายการไฟล์เดิม
        $existing = json_decode($record->attachments ?? '[]', true);

        // ✅ ลบไฟล์ที่เลือก
        $toDelete = $request->input('delete_attachments', []);
        foreach ($toDelete as $idx) {
            if (isset($existing[$idx])) {
                Storage::disk('public')->delete($existing[$idx]);
                unset($existing[$idx]);
            }
        }
        $existing = array_values($existing);

        // ✅ เพิ่มไฟล์ใหม่
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $existing[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($existing) ? json_encode($existing) : null;

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        $data['branch_id'] = $tellerProfile->branch_id;
        $data['unit_id'] = $tellerProfile->unit_id;

        $this->ensureUnitMatchesBranch($data['branch_id'], $data['unit_id']);

        // ✅ อัปเดตข้อมูล
        $record->update($data);

        if ($wasRejected) {
            $record->approval_status = 'pending';
            $record->admin_remark = null;
            $record->save();
        }

        return redirect()
            ->route('teller.requests.show', $record->id)
            ->with('success', 'ສຳເລັດການອແກ້ໄຂຂໍ້ມູນ');
    }

    // 👁️ แสดงรายละเอียดคำขอ
    public function show($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::user()->teller_id)
            ->with(['branch', 'unit'])
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
                'branch_id' => __('�����T��^��?��?�����%��������,���'),
            ]);
        }

        $unit = BranchUnit::find($unitId);

        if (!$unit) {
            throw ValidationException::withMessages([
                'unit_id' => __('ຫນ່ວຍຍ່ອຍທີ່ເລືອກບໍ່ຖືກຕ້ອງ'),
            ]);
        }

        if ($branchId && (int) $unit->branch_id !== (int) $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('ຫນ່ວຍຍ່ອຍບໍ່ກົງກັບສາຂາທີ່ເລືອກ'),
            ]);
        }
    }
}
