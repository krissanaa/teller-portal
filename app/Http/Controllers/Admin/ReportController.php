<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FullOnboardingExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get Data with Pagination (10 per page)
        $query = $this->applyFilters(OnboardingRequest::with(['branch', 'unit', 'teller']), $request);

        $data = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        // Dropdown Data - Optimized
        // Select only necessary columns and alias for view compatibility
        $branches = Branch::select('id', 'BRANCH_NAME as name')->orderBy('BRANCH_NAME')->get();
        $units    = BranchUnit::select('id', 'unit_name as name')->orderBy('unit_name')->get();

        // Only load users with 'teller' role
        $tellers  = User::where('role', 'teller')
            ->select('id', 'name', 'teller_id')
            ->orderBy('name')
            ->get();

        return view('admin.reports.index', array_merge(
            compact('data', 'branches', 'units', 'tellers'),
            $request->only(['search', 'start_date', 'end_date', 'status', 'branch_id', 'unit_id', 'teller_id'])
        ));
    }

    // 📊 Export Excel (Full Data)
    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredData($request);

        return Excel::download(
            new FullOnboardingExport($data),
            "onboarding_report_" . date('Y-m-d_H-i') . ".xlsx"
        );
    }

    // 🧾 Export PDF (Full Data)
    public function exportPDF(Request $request)
    {
        $data = $this->getFilteredData($request);

        // Pass filter params for display in PDF header if needed
        $filters = $request->only(['start_date', 'end_date', 'status', 'branch_id']);

        $pdf = Pdf::loadView(
            'admin.reports.pdf_full',
            compact('data', 'filters')
        )->setPaper('a4', 'landscape');

        return $pdf->download("onboarding_report_" . date('Y-m-d_H-i') . ".pdf");
    }

    // Helper to get filtered data for exports (no pagination)
    private function getFilteredData(Request $request)
    {
        return $this->applyFilters(OnboardingRequest::with(['branch', 'unit', 'teller']), $request)
            ->orderByDesc('created_at')
            ->get();
    }

    private function applyFilters($query, Request $request)
    {
        if ($search = $request->input('search')) {
            $like = "%{$search}%";
            $query->where(function ($q) use ($like) {
                $q->where('store_name', 'like', $like)
                    ->orWhere('store_address', 'like', $like)
                    ->orWhere('business_type', 'like', $like)
                    ->orWhere('refer_code', 'like', $like)
                    ->orWhere('pos_serial', 'like', $like)
                    ->orWhere('bank_account', 'like', $like)
                    ->orWhere('teller_id', 'like', $like)
                    ->orWhere('admin_remark', 'like', $like)
                    ->orWhereHas('branch', function ($branch) use ($like) {
                        $branch->where('BRANCH_NAME', 'like', $like)
                            ->orWhere('BRANCH_CODE', 'like', $like);
                    })
                    ->orWhereHas('unit', function ($unit) use ($like) {
                        $unit->where('unit_name', 'like', $like)
                            ->orWhere('unit_code', 'like', $like);
                    })
                    ->orWhereHas('teller', function ($teller) use ($like) {
                        $teller->where('name', 'like', $like)
                            ->orWhere('email', 'like', $like)
                            ->orWhere('teller_id', 'like', $like);
                    });
            });
        }

        if ($date = $request->input('start_date')) {
            $query->whereDate('created_at', '>=', $date);
        }

        if ($date = $request->input('end_date')) {
            $query->whereDate('created_at', '<=', $date);
        }

        if ($status = $request->input('status')) {
            $query->where('approval_status', $status);
        }

        if ($id = $request->input('branch_id')) {
            $query->where('branch_id', $id);
        }

        if ($id = $request->input('unit_id')) {
            $query->where('unit_id', $id);
        }

        if ($id = $request->input('teller_id')) {
            $query->where('teller_id', $id);
        }

        return $query;
    }
}
