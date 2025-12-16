<?php

use App\Models\TellerPortal\OnboardingRequest;
use App\Models\User;

// Login as user 1 for context if needed (though we aren't using Auth facade in raw query much)
// auth()->loginUsingId(1);

$req = OnboardingRequest::with('teller')->first();

if (!$req) {
    echo "No requests found.\n";
    exit;
}

echo "Request ID: " . $req->id . "\n";
echo "Request Teller (FK): " . $req->teller_id . "\n";

if ($req->teller) {
    echo "Teller Model Loaded.\n";
    echo "Teller User ID: " . $req->teller->id . "\n";
    echo "Teller Name: " . $req->teller->name . "\n";
    echo "Teller ID (Column): " . ($req->teller->teller_id ?? 'NULL') . "\n";

    // Check raw attributes
    echo "Raw Attributes: \n";
    print_r($req->teller->getAttributes());
} else {
    echo "Teller relationship is NULL.\n";
}

// Test the specific query used in Controller
echo "\n--- Controller Query Simulation ---\n";
$req2 = OnboardingRequest::with('teller:id,name,teller_id')
    ->select(['id', 'teller_id'])
    ->first();

if ($req2 && $req2->teller) {
    echo "Simulated Teller ID: " . ($req2->teller->teller_id ?? 'NULL') . "\n";
} else {
    echo "Simulated: Relation missing or loaded as null.\n";
}
