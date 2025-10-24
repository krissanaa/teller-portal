<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Support\Facades\Auth;

class TellerDashboardController extends Controller
{
    public function index()
    {
        $tellerId = Auth::id();

        // ดึงเฉพาะข้อมูลของ teller คนนี้
        $requests = OnboardingRequest::where('teller_id', $tellerId)
            ->orderByDesc('created_at')
            ->get();

        return view('teller.dashboard', compact('requests'));
    }
}
