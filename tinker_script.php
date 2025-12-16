$r = App\Models\TellerPortal\OnboardingRequest::with('teller')->latest()->first();
echo "ReqID: " . $r->id . "\n";
echo "TellerFK: " . $r->teller_id . "\n";
if ($r->teller) {
echo "Teller Name: " . $r->teller->name . "\n";
echo "Teller ID (Attr): " . $r->teller->teller_id . "\n";
echo "Teller Comp (Attr): " . $r->teller->attributes['teller_id'] . "\n";
} else {
echo "Teller relation is null.\n";
}