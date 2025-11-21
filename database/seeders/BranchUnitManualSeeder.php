<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;

class BranchUnitManualSeeder extends Seeder
{
    public function run(): void
    {
        $definitions = [
            '400200' => [
                'name' => 'Branch 400200',
                'units' => [
                    '400201' => 'Unit 400201',
                    '400202' => 'Unit 400202',
                ],
            ],
            '400300' => [
                'name' => 'Branch 400300',
                'units' => [
                    '400301' => 'Unit 400301',
                    '400302' => 'Unit 400302',
                ],
            ],
        ];

        DB::connection('teller_portal')->transaction(function () use ($definitions) {
            foreach ($definitions as $branchCode => $config) {
                $branch = Branch::firstOrCreate(
                    ['BRANCH_CODE' => $branchCode],
                    ['BRANCH_NAME' => $config['name']]
                );

                foreach ($config['units'] as $unitCode => $unitName) {
                    BranchUnit::updateOrCreate(
                        ['unit_code' => $unitCode],
                        [
                            'branch_id' => $branch->id,
                            'unit_name' => $unitName,
                        ]
                    );
                }
            }
        });

        $this->command?->info('Manual branch/unit records ensured.');
    }
}
