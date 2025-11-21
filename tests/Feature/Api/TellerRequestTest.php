<?php

namespace Tests\Feature\Api;

use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TellerRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_teller_can_create_onboarding_request_with_attachment(): void
    {
        Storage::fake('public');

        $branch = Branch::create([
            'BRANCH_CODE' => '000001',
            'BRANCH_NAME' => 'Main Branch',
        ]);

        DB::table('branches')->insert([
            'id' => $branch->id,
            'name' => 'Main Branch',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $unit = BranchUnit::create([
            'branch_id' => $branch->id,
            'unit_code' => '00000101',
            'unit_name' => 'Retail Unit',
        ]);

        $teller = User::factory()->create([
            'teller_id' => 'T2001',
            'role' => 'teller',
            'status' => 'approved',
            'password' => Hash::make('secret123'),
        ]);

        Sanctum::actingAs($teller, ['teller']);

        $response = $this->postJson('/api/teller/requests', [
            'store_name' => 'API Store',
            'business_type' => 'Retail',
            'store_address' => '123 Main St',
            'pos_serial' => 'POS123',
            'bank_account' => '1234567890',
            'branch_id' => $branch->id,
            'unit_id' => $unit->id,
            'installation_date' => now()->toDateString(),
            'attachments' => [
                UploadedFile::fake()->create('agreement.pdf', 10, 'application/pdf'),
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.store_name', 'API Store');

        $this->assertDatabaseHas('onboarding_requests', [
            'store_name' => 'API Store',
            'teller_id' => 'T2001',
        ]);
    }
}
