<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiProtectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that login endpoint is public
     */
    public function test_login_endpoint_is_public(): void
    {
        $response = $this->postJson('/api/login', [
            'username' => 'testuser',
            'password' => 'password',
        ]);

        // Should not be 401 for public endpoint
        $this->assertNotEquals(401, $response->status());
    }

    /**
     * Test that register endpoint is public
     */
    public function test_register_endpoint_is_public(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Should not be 401 for public endpoint
        $this->assertNotEquals(401, $response->status());
    }

    /**
     * Test that products endpoint requires authentication
     */
    public function test_products_endpoint_requires_authentication(): void
    {
        $response = $this->getJson('/api/products');
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test that orders endpoint requires authentication
     */
    public function test_orders_endpoint_requires_authentication(): void
    {
        $response = $this->getJson('/api/orders');
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test that materials endpoint requires authentication
     */
    public function test_materials_endpoint_requires_authentication(): void
    {
        $response = $this->getJson('/api/materials');
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test that order creation endpoint requires authentication
     */
    public function test_order_creation_requires_authentication(): void
    {
        $response = $this->postJson('/api/buat-pesanan', []);
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test that authenticated users can access protected routes
     */
    public function test_authenticated_users_can_access_products(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/products');

        $this->assertNotEquals(401, $response->status());
    }

    /**
     * Test that invalid tokens are rejected
     */
    public function test_invalid_token_is_rejected(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid_token_12345',
        ])->getJson('/api/products');

        $this->assertEquals(401, $response->status());
    }

    /**
     * Test that user endpoint returns authenticated user info
     */
    public function test_user_endpoint_returns_authenticated_user(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/user');

        $this->assertEquals(200, $response->status());
        $this->assertEquals($user->id, $response->json('id'));
    }

    /**
     * Test that logout endpoint is protected
     */
    public function test_logout_endpoint_is_protected(): void
    {
        $response = $this->postJson('/api/logout');
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test product creation requires authentication
     */
    public function test_product_creation_requires_authentication(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'selling_price' => 100000,
        ]);

        $this->assertEquals(401, $response->status());
    }

    /**
     * Test authenticated user can create product
     */
    public function test_authenticated_user_can_create_product(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/products', [
                'name' => 'Test Product',
                'selling_price' => 100000,
                'overhead_cost_per_unit' => 5000,
                'description' => 'Test description',
            ]);

        $this->assertNotEquals(401, $response->status());
    }
}

