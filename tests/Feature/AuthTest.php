<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_protected_route_without_token(): void
    {
        $response = $this->getJson('/api/materials');

        $response->assertStatus(401);
    }

    public function test_can_access_protected_route_with_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Material::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/materials');

        $response->assertStatus(200);
    }
}

