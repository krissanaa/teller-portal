<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TellerPortalBranchSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection('teller_portal');
        $legacyUnits = $connection->table('unit')
            ->select('UNIT_CODE', 'UNIT_NAME')
            ->orderBy('UNIT_CODE')
            ->get();

        if ($legacyUnits->isEmpty()) {
            $this->command?->warn('unit table on teller_portal is empty. Nothing to import.');
            return;
        }

        $connection->statement('SET FOREIGN_KEY_CHECKS=0');
        try {
            $connection->table('branch_unit')->truncate();
            $connection->table('branch')->truncate();
        } finally {
            $connection->statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $connection->transaction(function () use ($connection, $legacyUnits) {
            $branchIdMap = [];

            foreach ($legacyUnits as $unit) {
                $codeInt = (int) $unit->UNIT_CODE;
                if ($codeInt % 10 === 0) {
                    $branchIdMap[$unit->UNIT_CODE] = $connection->table('branch')->insertGetId([
                        'BRANCH_CODE' => $unit->UNIT_CODE,
                        'BRANCH_NAME' => $unit->UNIT_NAME,
                    ]);
                }
            }

            foreach ($legacyUnits as $unit) {
                $codeInt = (int) $unit->UNIT_CODE;
                if ($codeInt % 10 === 0) {
                    continue;
                }

                $branchCodeInt = (int) floor($codeInt / 10) * 10;
                $branchCode = str_pad(
                    (string) $branchCodeInt,
                    strlen((string) $unit->UNIT_CODE),
                    '0',
                    STR_PAD_LEFT
                );

                if (! isset($branchIdMap[$branchCode])) {
                    $branchIdMap[$branchCode] = $connection->table('branch')->insertGetId([
                        'BRANCH_CODE' => $branchCode,
                        'BRANCH_NAME' => 'Branch '.$branchCode,
                    ]);
                }

                $connection->table('branch_unit')->insert([
                    'branch_id' => $branchIdMap[$branchCode],
                    'unit_code' => $unit->UNIT_CODE,
                    'unit_name' => $unit->UNIT_NAME,
                ]);
            }
        });

        $this->command?->info('Branch and unit data synced from legacy unit table.');
    }
}
