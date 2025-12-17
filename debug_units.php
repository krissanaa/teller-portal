<?php
// Script to check Users and their Requests
use App\Models\User;
use App\Models\TellerPortal\OnboardingRequest;

$tellerIds = ['123456', '222222', '456789'];

foreach ($tellerIds as $tid) {
    $user = User::where('teller_id', $tid)->first();
    if ($user) {
        echo "Teller: $tid | Auth ID: $user->id | Branch: $user->branch_id | Unit: " . ($user->unit_id ?? 'NULL') . "\n";

        // Check latest requests for this teller
        $reqs = OnboardingRequest::where('teller_id', $user->teller_id)->latest()->take(2)->get();
        foreach ($reqs as $req) {
            echo "  -> Request ID: $req->id | Branch: $req->branch_id | Unit: " . ($req->unit_id ?? 'NULL') . "\n";
        }
    } else {
        echo "Teller: $tid not found.\n";
    }
}
