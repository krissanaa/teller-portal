<?php

namespace App\Http\Controllers;

use App\Models\OnboardingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingRequestController extends Controller
{
    /**
     * Teller ส่งฟอร์มใหม่ -> สถานะตั้งต้นเป็น pending เสมอ
     */
    public function submitForm(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $tellerId = $user?->teller_id ?? $user?->id;

        abort_unless($tellerId, 403, 'ไม่พบรหัสเทลเลอร์');

        // ในตัวอย่างนี้เราโฟกัสเฉพาะสถานะ จึงยังไม่รับข้อมูลฟอร์มอื่น ๆ
        OnboardingRequest::create([
            'teller_id' => $tellerId,
            'status' => OnboardingRequest::STATUS_PENDING,
            'remark' => null,
        ]);

        return redirect()
            ->route('teller.dashboard')
            ->with('success', 'ส่งฟอร์มเรียบร้อยแล้ว ระบบกำลังรอการอนุมัติ');
    }

    /**
     * Admin กดอนุมัติ -> เปลี่ยนสถานะเป็น approved
     */
    public function approveForm(OnboardingRequest $onboardingRequest): RedirectResponse
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        if ($onboardingRequest->status !== OnboardingRequest::STATUS_PENDING) {
            return back()->with('error', 'อนุมัติได้เฉพาะคำขอที่ยัง pending เท่านั้น');
        }

        $onboardingRequest->update([
            'status' => OnboardingRequest::STATUS_APPROVED,
            'remark' => null,
        ]);

        return back()->with('success', 'อนุมัติคำขอเรียบร้อยแล้ว');
    }

    /**
     * Admin กดปฏิเสธ -> ต้องระบุ remark เก็บเหตุผลไว้ในฐานข้อมูล
     */
    public function rejectForm(Request $request, OnboardingRequest $onboardingRequest): RedirectResponse
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $data = $request->validate([
            'remark' => 'required|string|max:500',
        ]);

        if ($onboardingRequest->status !== OnboardingRequest::STATUS_PENDING) {
            return back()->with('error', 'ปฏิเสธได้เฉพาะคำขอที่ยัง pending เท่านั้น');
        }

        $onboardingRequest->update([
            'status' => OnboardingRequest::STATUS_REJECTED,
            'remark' => $data['remark'],
        ]);

        return back()->with('success', 'บันทึกสถานะ rejected พร้อมเหตุผลเรียบร้อยแล้ว');
    }

    /**
     * Teller แก้ไขและส่งใหม่หลังถูก reject -> รีเซ็ต remark และสถานะเป็น pending
     */
    public function resubmitForm(OnboardingRequest $onboardingRequest): RedirectResponse
    {
        $this->ensureTellerOwnership($onboardingRequest);

        if (! $onboardingRequest->isRejected()) {
            return back()->with('error', 'คำขอนี้ยังไม่ได้ถูกปฏิเสธ จึงไม่ต้อง resubmit');
        }

        $onboardingRequest->update([
            'status' => OnboardingRequest::STATUS_PENDING,
            'remark' => null,
        ]);

        return redirect()
            ->route('teller.dashboard')
            ->with('success', 'ส่งคำขออีกครั้งแล้ว กรุณารอการอนุมัติ');
    }

    /**
     * Helper: ให้แน่ใจว่าเทลเลอร์เข้าถึงเฉพาะเรคคอร์ดของตัวเอง
     */
    protected function ensureTellerOwnership(OnboardingRequest $onboardingRequest): void
    {
        $user = Auth::user();
        $tellerId = $user?->teller_id ?? $user?->id;

        abort_unless($tellerId, 403, 'ไม่พบรหัสเทลเลอร์');
        abort_unless((int) $onboardingRequest->teller_id === (int) $tellerId, 403, 'คุณไม่มีสิทธิ์แก้ไขคำขอนี้');
    }
}
