<?php

use App\Models\User;

$ids = ['222222', '456789'];
echo "Checking users with teller_id: " . implode(', ', $ids) . "\n";

foreach ($ids as $id) {
    $u = User::where('teller_id', $id)->first();
    if ($u) {
        echo "Found $id: Role='{$u->role}', Branch='{$u->branch_id}'\n";
    } else {
        echo "User $id not found in DB.\n";
    }
}
