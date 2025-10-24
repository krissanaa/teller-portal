<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;

class OnboardingController extends Controller
{
    // ============================================================
    // 🧾 สร้างฟอร์มใหม่
    // ============================================================
    public function create()
    {
        // ✅ ดึง branch จริงจากฐานข้อมูล teller_portal
        $branches = Branch::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('teller.requests.create', compact('branches'));
    }

    // ============================================================
    // 💾 บันทึกฟอร์มใหม่
    // ============================================================
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:500',
            'business_type' => 'required|string|max:255',
            'pos_serial' => 'required|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'installation_date' => 'required|date',
            'branch_id' => 'required|integer|exists:branches,id',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // ✅ generate refer_code เช่น REF-20251022-001
        $datePrefix = now()->format('Ymd');
        $last = OnboardingRequest::whereDate('created_at', now())->count() + 1;
        $referCode = "REF-{$datePrefix}-" . str_pad($last, 3, '0', STR_PAD_LEFT);

        // ✅ upload file
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        // ✅ บันทึกข้อมูล
        OnboardingRequest::create([
            'refer_code' => $referCode,
            'teller_id' => Auth::id(),
            'branch_id' => $request->branch_id,
            'store_name' => $request->store_name,
            'store_address' => $request->store_address,
            'business_type' => $request->business_type,
            'pos_serial' => $request->pos_serial,
            'bank_account' => $request->bank_account,
            'installation_date' => $request->installation_date,
            'store_status' => 'pending',
            'approval_status' => 'pending',
            'admin_remark' => null,
            'attachment' => $filePath,
        ]);

        return redirect()->route('teller.dashboard')
            ->with('success', '✅ Onboarding request submitted successfully.');
    }

    // ============================================================
    // 🔍 แสดงรายละเอียดฟอร์ม
    // ============================================================
    public function show($id)
    {
        $tellerId = Auth::id();

        $request = OnboardingRequest::with('branch')
            ->where('teller_id', $tellerId)
            ->where('id', $id)
            ->firstOrFail();

        return view('teller.requests.show', compact('request'));
    }

    // ============================================================
    // ✏️ แก้ไขฟอร์ม (เฉพาะ Pending)
    // ============================================================
    public function edit($id)
    {
        $tellerId = Auth::id();
        $request = OnboardingRequest::where('teller_id', $tellerId)->findOrFail($id);

        if ($request->approval_status !== 'pending') {
            return redirect()->route('teller.requests.show', $id)
                ->with('error', '❌ This request cannot be edited after approval or rejection.');
        }

        $branches = Branch::where('status', 'active')->orderBy('name')->get();

        return view('teller.requests.edit', compact('request', 'branches'));
    }

    // ============================================================
    // 🔄 อัปเดตฟอร์ม (เมื่อแก้ไข)
    // ============================================================
    public function update(Request $request, $id)
    {
        $tellerId = Auth::id();
        $data = OnboardingRequest::where('teller_id', $tellerId)->findOrFail($id);

        if ($data->approval_status !== 'pending') {
            return back()->with('error', '❌ This request has already been processed and cannot be updated.');
        }

        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:500',
            'business_type' => 'required|string|max:255',
            'pos_serial' => 'required|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'installation_date' => 'required|date',
            'branch_id' => 'required|integer|exists:branches,id',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // ถ้ามีการแนบไฟล์ใหม่ → ลบไฟล์เก่า
        if ($request->hasFile('attachment')) {
            if ($data->attachment && Storage::disk('public')->exists($data->attachment)) {
                Storage::disk('public')->delete($data->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $data->update($validated);

        return redirect()->route('teller.requests.show', $id)
            ->with('success', '✅ Request updated successfully.');
    }
}
