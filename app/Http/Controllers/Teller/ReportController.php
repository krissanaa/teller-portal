<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            ->select([
                'id',
                'refer_code',
                'pos_serial',
                'store_name',
                'business_type',
                'installation_date',
                'approval_status',
                'branch_id',
                'unit_id',
                'created_at',
            ])
            ->with([
                'branch:id,BRANCH_NAME,BRANCH_CODE',
                'unit:id,branch_id,unit_name,unit_code',
            ])
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

        $data = $query->paginate(10)->withQueryString();

        $statusCounts = OnboardingRequest::where('teller_id', Auth::user()->teller_id)
            ->selectRaw('approval_status, COUNT(*) as total')
            ->groupBy('approval_status')
            ->pluck('total', 'approval_status');

        $cache = Cache::store('file');

        $years = $cache->remember('teller_report_years_' . Auth::user()->teller_id, 60 * 60 * 24, function () {
            return OnboardingRequest::where('teller_id', Auth::user()->teller_id)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year')
                ->toArray();
        });

        $branches = $cache->remember('all_branches_with_units', 60 * 60 * 24, function () {
            return Branch::select(['id', 'BRANCH_NAME', 'BRANCH_CODE'])
                ->with(['units:id,branch_id,unit_name,unit_code'])
                ->orderBy('BRANCH_NAME')
                ->get();
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
            'statusCounts' => $statusCounts,
        ]);
    }
}
