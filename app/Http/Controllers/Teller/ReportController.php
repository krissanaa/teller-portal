<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $currentUser = Auth::user();

        // Branch Admins see ALL statuses by default (Approved, Pending, Rejected)
        // Others default to 'approved'
        $defaultStatus = $currentUser->isBranchAdmin() ? null : 'approved';
        $status = $request->input('status', $defaultStatus);

        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $endDay = $request->input('end_day');
        $branchId = $request->input('branch_id');
        $unitId = $request->input('unit_id');
        $tellerId = $request->input('teller_id');
        $order = $request->input('order', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($currentUser->isBranchAdmin()) {
            // Lock branch to the admin's branch
            $branchId = $currentUser->branch_id;
        } else {
            $branchId = null;
            $unitId = null;
            $tellerId = null;
        }

        // RBAC: Use visibleTo scope
        $query = OnboardingRequest::visibleTo(Auth::user())
            ->select([
                'id',
                'teller_id', // Needed for teller name
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
                'teller', // Load full teller model to ensure teller_id is available
            ])
            ->orderBy('created_at', $order);

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
                    // Search by Teller Name
                    ->orWhereHas('teller', function ($t) use ($like) {
                        $t->where('name', 'like', $like)
                            ->orWhere('teller_id', 'like', $like);
                    })
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

        if ($endDay) {
            $query->whereDate('created_at', '<=', $endDay);
        }

        if ($currentUser->isBranchAdmin()) {
            $query->where('branch_id', $branchId);

            if ($unitId === 'all') {
                // Show ALL records (no unit filter applied)
            } elseif ($unitId) {
                $query->where('unit_id', $unitId);
            } else {
                // Default: Show Only Direct Branch (No Unit)
                $query->whereNull('unit_id');
            }

            if ($tellerId && $tellerId !== 'all') {
                $query->where('teller_id', $tellerId);
            }
        }

        $data = $query->paginate(10)->withQueryString();

        $statusCounts = $this->statusCountsForUser(Auth::user(), $unitId, $tellerId);

        $cache = Cache::store('file');

        $yearsCacheKey = Auth::user()->isBranchAdmin()
            ? 'teller_report_years_branch_' . Auth::user()->branch_id
            : 'teller_report_years_' . Auth::user()->teller_id;

        $years = $cache->remember($yearsCacheKey, 60 * 60 * 24, function () {
            $query = Auth::user()->isBranchAdmin()
                ? OnboardingRequest::where('branch_id', Auth::user()->branch_id)
                : OnboardingRequest::where('teller_id', Auth::user()->teller_id);

            return $query->selectRaw('YEAR(created_at) as year')
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

        // Filter Tellers based on selected Unit Scope
        $tellersQuery = User::whereIn('role', [User::ROLE_TELLER, User::ROLE_TELLER_UNIT])
            ->where('branch_id', Auth::user()->branch_id);

        if ($unitId === 'all') {
            // Show all tellers in branch
        } elseif ($unitId) {
            $tellersQuery->where('unit_id', $unitId);
        } else {
            // Default: Only direct branch tellers
            $tellersQuery->whereNull('unit_id');
        }

        $tellers = Auth::user()->isBranchAdmin()
            ? $tellersQuery->orderBy('name')->get(['id', 'name', 'teller_id'])
            : collect([Auth::user()]);

        return view('teller.report.index', [
            'data' => $data,
            'search' => $search,
            'status' => $status,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'endDay' => $endDay,
            'years' => $years,
            'branchId' => $branchId,
            'unitId' => $unitId,
            'tellerId' => $tellerId,
            'order' => $order,
            'branches' => $branches,
            'tellers' => $tellers,
            'statusCounts' => $statusCounts,
        ]);
    }

    protected function statusCountsForUser($user, $unitId = null, $tellerId = null)
    {
        if ($user->isBranchAdmin()) {
            $query = OnboardingRequest::where('branch_id', $user->branch_id);

            // Apply Unit Filter
            if ($unitId === 'all') {
                // No filter (Show All)
            } elseif ($unitId) {
                $query->where('unit_id', $unitId);
            } else {
                // Default: Direct Branch
                $query->whereNull('unit_id');
            }

            // Apply Teller Filter
            if ($tellerId && $tellerId !== 'all') {
                $query->where('teller_id', $tellerId);
            }

            return $query->selectRaw('approval_status, COUNT(*) as total')
                ->groupBy('approval_status')
                ->pluck('total', 'approval_status');
        }

        return OnboardingRequest::where('teller_id', $user->teller_id)
            ->selectRaw('approval_status, COUNT(*) as total')
            ->groupBy('approval_status')
            ->pluck('total', 'approval_status');
    }
}
