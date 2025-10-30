<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    // 🧾 ฟอร์มสร้างคำขอใหม่
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        return view('teller.requests.create', compact('branches'));
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
            'branch_id'         => 'nullable|integer',
            'installation_date' => 'nullable|date',
            'attachments.*'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // ✅ อัปโหลดไฟล์แนบ
        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($paths) ? json_encode($paths) : null;
        $data['teller_id'] = Auth::id();
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
            ->where('teller_id', Auth::id())
            ->firstOrFail();

        $branches = Branch::orderBy('name')->get();

        return view('teller.requests.edit', compact('request', 'branches'));
    }

    // 🔄 อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $record = OnboardingRequest::where('teller_id', auth()->id())->findOrFail($id);

        $data = $request->validate([
            'store_name'         => 'required|string|max:255',
            'business_type'      => 'nullable|string|max:255',
            'store_address'      => 'nullable|string',
            'pos_serial'         => 'nullable|string|max:255',
            'bank_account'       => 'nullable|string|max:50',
            'branch_id'          => 'nullable|integer',
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

        // ✅ อัปเดตข้อมูล
        $record->update($data);

        return redirect()
            ->route('teller.requests.show', $record->id)
            ->with('success', 'ສຳເລັດການອແກ້ໄຂຂໍ້ມູນ');
    }

    // 👁️ แสดงรายละเอียดคำขอ
    public function show($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::id())
            ->with('branch')
            ->firstOrFail();

        return view('teller.requests.show', compact('request'));
    }
}
