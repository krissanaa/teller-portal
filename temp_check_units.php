<?php
require __DIR__ . '/vendor/autoload.php';
$branch = App\Models\TellerPortal\Branch::with('units')->where('BRANCH_CODE','400200')->first();
if (!$branch) { echo 'no branch'; exit; }
foreach ($branch->units as $unit) { echo $unit->unit_code.'|'.$unit->unit_name.PHP_EOL; }
