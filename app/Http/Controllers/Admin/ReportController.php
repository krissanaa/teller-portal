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
        // Filter Inputs
        $search     = $request->input('search');
        $start_date = $request->input('start_date');
        $end_date   = $request->input('end_date');
        $status     = $request->input('status');
        $branch_id  = $request->input('branch_id');
        $unit_id    = $request->input('unit_id');
        $teller_id  = $request->input('teller_id');

        // Base Query
        $query = OnboardingRequest::with(['branch', 'unit', 'teller']);

        // Apply Filters
        if ($search) {
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

        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }

        if ($status) {
            $query->where('approval_status', $status);
        }

        if ($branch_id) {
            $query->where('branch_id', $branch_id);
        }

        if ($unit_id) {
            $query->where('unit_id', $unit_id);
        }

        if ($teller_id) {
            $query->where('teller_id', $teller_id);
        }

        // Get Data with Pagination (10 per page)
        $data = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        // Dropdown Data
        $branches = Branch::orderBy('branch_name')->get();
        $units    = BranchUnit::orderBy('unit_name')->get();
        // Assuming 'tellers' are users with a specific role or just all users for now
        // Adjust this query based on your User model and roles if needed
        $tellers  = User::orderBy('name')->get();

        return view('admin.reports.index', compact(
            'data',
            'branches',
            'units',
            'tellers',
            'search',
            'start_date',
            'end_date',
            'status',
            'branch_id',
            'unit_id',
            'teller_id'
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
        $query = OnboardingRequest::with(['branch', 'unit', 'teller']);

        if ($request->search) {
            $like = "%{$request->search}%";
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

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->teller_id) {
            $query->where('teller_id', $request->teller_id);
        }

        return $query->orderByDesc('created_at')->get();
    }
}
