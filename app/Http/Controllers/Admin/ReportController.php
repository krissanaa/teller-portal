<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FullOnboardingExport;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $year   = $request->input('year', date('Y'));
    $month  = $request->input('month', null);
    $status = $request->input('status', ''); // 👈 รับค่าจาก filter dropdown

    // ✅ เริ่มสร้าง query หลัก
    $query = OnboardingRequest::query()
        ->when($year, fn($q) => $q->whereYear('created_at', $year))
        ->when($month, fn($q) => $q->whereMonth('created_at', $month));

    // ✅ เพิ่ม filter ตามสถานะ (ถ้ามี)
    if (!empty($status)) {
        $query->where('approval_status', $status);
    }

    // ✅ ดึงข้อมูลเรียงจากใหม่ไปเก่า
    $data = $query->orderByDesc('created_at')->get();

    // ✅ ดึงปีทั้งหมด (สำหรับ filter ปี)
    $years = OnboardingRequest::select(DB::raw('DISTINCT YEAR(created_at) as y'))
        ->orderByDesc('y')
        ->pluck('y')
        ->toArray();

    return view('admin.reports.index', compact('data', 'year', 'month', 'status', 'years'));
}

    // 📊 Export Excel (Full Data)
    public function exportExcel(Request $request)
{
    $year   = $request->input('year');
    $month  = $request->input('month');
    $status = $request->input('status'); // ✅ เพิ่มตัวแปร status

    $data = \App\Models\TellerPortal\OnboardingRequest::query()
        ->when($year, fn($q) => $q->whereYear('created_at', $year))
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->when($status, fn($q) => $q->where('approval_status', $status)) // ✅ เพิ่ม filter status
        ->orderBy('created_at')
        ->get();

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\FullOnboardingExport($data),
        "onboarding_report_{$year}_{$month}_{$status}.xlsx"
    );
}


    // 🧾 Export PDF (Full Data)
public function exportPDF(Request $request)
{
    $year   = $request->input('year');
    $month  = $request->input('month');
    $status = $request->input('status'); // ✅ เพิ่มตัวแปร status

    $data = \App\Models\TellerPortal\OnboardingRequest::query()
        ->when($year, fn($q) => $q->whereYear('created_at', $year))
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->when($status, fn($q) => $q->where('approval_status', $status)) // ✅ เพิ่ม filter status
        ->orderBy('created_at')
        ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'admin.reports.pdf_full',
        compact('data', 'year', 'month', 'status')
    )->setPaper('a4', 'landscape');

    return $pdf->download("onboarding_report_{$year}_{$month}_{$status}.pdf");
}
}
