<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_teller_can_login_with_teller_id(): void
    {
        $user = User::factory()->create([
            'teller_id' => 'T0001',
            'role' => 'teller',
            'status' => 'approved',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'identifier' => 'T0001',
            'password' => 'secret',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'token',
                'token_type',
                'user' => [
                    'id',
                    'teller_id',
                    'role',
                ],
            ]);
    }

    public function test_pending_teller_cannot_login(): void
    {
        User::factory()->create([
            'teller_id' => 'T0002',
            'role' => 'teller',
            'status' => 'pending',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'identifier' => 'T0002',
            'password' => 'secret',
        ]);

        $response->assertStatus(403);
    }
}
