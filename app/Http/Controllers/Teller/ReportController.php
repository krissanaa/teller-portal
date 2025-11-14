<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
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

        $query = OnboardingRequest::where('teller_id', Auth::user()->teller_id)
            ->with('branch')
            ->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhere('refer_code', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
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

        $data = $query->paginate(10);

        $years = OnboardingRequest::where('teller_id', Auth::user()->teller_id)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        return view('teller.report.index', [
            'data' => $data,
            'search' => $search,
            'status' => $status,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'years' => $years,
        ]);
    }
}
