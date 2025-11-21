<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_teller_via_api(): void
    {
        $this->actingAsAdmin();

        $response = $this->postJson('/api/admin/tellers', [
            'teller_id' => 'TEL100',
            'name' => 'API Teller',
            'email' => 'api.teller@example.com',
            'phone' => '123456789',
            'password' => 'secret123',
            'status' => 'approved',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.teller_id', 'TEL100')
            ->assertJsonPath('data.status', 'approved');

        $this->assertDatabaseHas('users', [
            'teller_id' => 'TEL100',
            'role' => 'teller',
        ]);
    }

    public function test_admin_can_update_teller_status(): void
    {
        $this->actingAsAdmin();

        $teller = User::factory()->create([
            'teller_id' => 'TEL101',
            'role' => 'teller',
            'status' => 'pending',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->patchJson("/api/admin/tellers/{$teller->id}/status", [
            'status' => 'approved',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'approved');

        $this->assertDatabaseHas('users', [
            'id' => $teller->id,
            'status' => 'approved',
        ]);
    }

    protected function actingAsAdmin(): User
    {
        $admin = User::factory()->create([
            'teller_id' => 'ADM001',
            'role' => 'admin',
            'status' => 'approved',
            'password' => Hash::make('secret123'),
        ]);

        Sanctum::actingAs($admin, ['admin']);

        return $admin;
    }
}
