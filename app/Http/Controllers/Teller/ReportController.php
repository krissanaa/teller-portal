<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $branchId = $request->input('branch_id');
        $unitId = $request->input('unit_id');

        $query = OnboardingRequest::where('teller_id', Auth::user()->teller_id)
            ->with(['branch', 'unit'])
            ->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $like = "%{$search}%";

                $q->where('store_name', 'like', $like)
                    ->orWhere('refer_code', 'like', $like)
                    ->orWhere('business_type', 'like', $like)
                    ->orWhere('pos_serial', 'like', $like)
                    ->orWhere('store_address', 'like', $like)
                    ->orWhere('bank_account', 'like', $like)
                    ->orWhere('installation_date', 'like', $like)
                    ->orWhereHas('branch', function ($branchQuery) use ($like) {
                        $branchQuery->where('BRANCH_NAME', 'like', $like)
                            ->orWhere('BRANCH_CODE', 'like', $like);
                    })
                    ->orWhereHas('unit', function ($unitQuery) use ($like) {
                        $unitQuery->where('unit_name', 'like', $like)
                            ->orWhere('unit_code', 'like', $like);
                    });
            });
        }

        if ($status) {
            $query->where('approval_status', $status);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($day) {
            $query->whereDate('created_at', $day);
        }

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($unitId) {
            $query->where('unit_id', $unitId);
        }

        $data = $query->paginate(10);

        $years = \Illuminate\Support\Facades\Cache::remember('teller_report_years_' . Auth::user()->teller_id, 60 * 60 * 24, function () {
            return OnboardingRequest::where('teller_id', Auth::user()->teller_id)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year')
                ->toArray();
        });

        $branches = \Illuminate\Support\Facades\Cache::remember('all_branches_with_units', 60 * 60 * 24, function () {
            return Branch::with('units')->orderBy('BRANCH_NAME')->get();
        });

        return view('teller.report.index', [
            'data' => $data,
            'search' => $search,
            'status' => $status,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'years' => $years,
            'branchId' => $branchId,
            'unitId' => $unitId,
            'branches' => $branches,
        ]);
    }
}
