<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $cache = Cache::store('file');

        // Avoid running the sync logic on every request; only once per cache window.
        try {
            if ($cache->missing('branch_units_synced')) {
                $this->ensureBranchUnitsSynced();
                $cache->put('branch_units_synced', true, 60 * 60 * 24);
            }
        } catch (\Throwable $e) {
            // If the DB/cache store is not reachable during boot, skip sync to keep app responsive.
        }

        View::composer('layouts.teller', function ($view) {
            $notifications = collect();
            $profileBranches = collect();
            $profileBranchUnitsPayload = [];

            if (Auth::check() && Auth::user()->role === 'teller') {
                $notifications = OnboardingRequest::where('teller_id', Auth::user()->teller_id)
                    ->whereIn('approval_status', ['approved', 'rejected'])
                    ->whereDate('updated_at', '>=', now()->subDays(7))
                    ->latest()
                    ->take(5)
                    ->get();

                try {
                    $cache = Cache::store('file');

                    $profileBranches = $cache->remember('nav_profile_branches', 60 * 60 * 24, function () {
                        return Branch::select(['id', 'BRANCH_NAME', 'BRANCH_CODE'])
                            ->orderBy('BRANCH_NAME')
                            ->get();
                    });

                    $profileBranchUnitsPayload = $cache->remember('nav_profile_branch_units', 60 * 60 * 24, function () {
                        $branchUnits = BranchUnit::select('id', 'branch_id', 'unit_code', 'unit_name')
                            ->get()
                            ->groupBy('branch_id');

                        return $branchUnits->mapWithKeys(function ($units, $branchId) {
                            return [
                                (string) $branchId => $units->map(function ($unit) {
                                    return [
                                        'id' => (string) $unit->id,
                                        'code' => $unit->unit_code,
                                        'name' => $unit->unit_name,
                                    ];
                                })->values()->toArray(),
                            ];
                        })->toArray();
                    });
                } catch (\Throwable $e) {
                    $profileBranches = collect();
                    $profileBranchUnitsPayload = [];
                }
            }

            $view->with([
                'notifications' => $notifications,
                'profileBranches' => $profileBranches,
                'profileBranchUnitsPayload' => $profileBranchUnitsPayload,
            ]);
        });
    }

    protected function ensureBranchUnitsSynced(): void
    {
        try {
            if (BranchUnit::query()->exists()) {
                return;
            }

            $branchCodeMap = Branch::pluck('id', 'BRANCH_CODE')
                ->mapWithKeys(function ($id, $code) {
                    return [(string) $code => $id];
                });

            if ($branchCodeMap->isEmpty()) {
                return;
            }

            $legacyUnits = DB::connection('teller_portal')
                ->table('unit')
                ->select('UNIT_CODE', 'UNIT_NAME')
                ->get();

            foreach ($legacyUnits as $legacyUnit) {
                $unitCode = (string) $legacyUnit->UNIT_CODE;
                $branchCode = substr($unitCode, 0, 6);

                if (strlen($unitCode) <= 6 || $unitCode === $branchCode) {
                    continue;
                }

                $branchId = $branchCodeMap[$branchCode] ?? null;
                if (!$branchId) {
                    continue;
                }

                BranchUnit::firstOrCreate(
                    ['unit_code' => $unitCode],
                    [
                        'branch_id' => $branchId,
                        'unit_name' => $legacyUnit->UNIT_NAME,
                    ]
                );
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
