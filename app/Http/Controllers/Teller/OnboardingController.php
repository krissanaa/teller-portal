<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;   // ✅ เพิ่มตรงนี้
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    // 🧾 ฟอร์มสร้างคำขอใหม่
    public function create()
    {
        $branches = Branch::orderBy('name')->get(); // ✅ เพิ่มบรรทัดนี้
        return view('teller.requests.create', compact('branches'));
    }

    // 💾 บันทึกคำขอใหม่
    public function store(Request $request)
{
    $data = $request->validate([
    'store_name'       => 'required|string|max:255',
    'business_type'    => 'nullable|string|max:255',
    'store_address'    => 'nullable|string',
    'pos_serial'       => 'nullable|string|max:255',
    'bank_account'     => 'nullable|string|max:255',
    'branch_id'        => 'nullable|integer',
    'installation_date'=> 'nullable|date',
    'attachments.*'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
    \DB::transaction(function () use (&$data) {
        $today = now()->format('Ymd');

        $latestToday = \App\Models\TellerPortal\OnboardingRequest::whereDate('created_at', today())
            ->where('refer_code', 'like', 'REF-' . $today . '-%')
            ->lockForUpdate() // 🔒 ป้องกันซ้ำกรณีหลายคนกดพร้อมกัน
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($latestToday && preg_match('/REF-' . $today . '-(\d+)/', $latestToday->refer_code, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        }

        // ✅ Format: REF-YYYYMMDD-XXX
        $data['refer_code'] = 'REF-' . $today . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        \App\Models\TellerPortal\OnboardingRequest::create($data);
    });

    return redirect()->route('teller.dashboard')->with('success', 'ສົ່ງຄຳຂໍສຳເລັດ');
}





    // 🧰 ฟอร์มแก้ไข
    public function edit($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::id())
            ->firstOrFail();

        $branches = Branch::orderBy('name')->get(); // ✅ เพิ่มบรรทัดนี้ด้วย

        return view('teller.requests.edit', compact('request', 'branches'));
    }

    // 🔄 อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $record = OnboardingRequest::findOrFail($id);

        $data = $request->validate([
    'store_name'       => 'required|string|max:255',
    'business_type'    => 'nullable|string|max:255',
    'store_address'    => 'nullable|string',
    'pos_serial'       => 'nullable|string|max:255',
    'bank_account'     => 'nullable|string|max:255',
    'branch_id'        => 'nullable|integer',
    'installation_date'=> 'nullable|date',
    'attachments.*'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $paths = json_decode($record->attachments ?? '[]', true);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($paths) ? json_encode($paths) : null;
        $record->update($data);

        return redirect()->route('teller.requests.show', $record->id)->with('success', 'ອັບເດດຂໍ້ມູນສຳເລັດ');
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
