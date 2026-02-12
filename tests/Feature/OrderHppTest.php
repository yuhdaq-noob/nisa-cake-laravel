<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderHppTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculates_hpp_correctly_from_bom_and_overhead(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $product = Product::factory()->create([
            'selling_price' => 5000,
            'overhead_cost_per_unit' => 50,
        ]);

        $material = Material::factory()->create([
            'price_per_unit_baku' => 100,
            'current_stock' => 1000,
        ]);

        $product->materials()->attach($material->id, ['quantity_needed' => 2]);

        $payload = [
            'customer_name' => 'Test Customer',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 3],
            ],
        ];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/buat-pesanan', $payload);

        $response->assertStatus(201);

        $order = Order::firstOrFail();
        $expectedHpp = ((2 * 100) + 50) * 3;

        $this->assertEquals($expectedHpp, (float) $order->total_hpp);
    }

    public function test_hpp_changes_when_material_price_updates(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $product = Product::factory()->create([
            'selling_price' => 5000,
            'overhead_cost_per_unit' => 0,
        ]);

        $material = Material::factory()->create([
            'price_per_unit_baku' => 100,
            'current_stock' => 1000,
        ]);

        $product->materials()->attach($material->id, ['quantity_needed' => 2]);

        $payload = [
            'customer_name' => 'Test Customer',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1],
            ],
        ];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/buat-pesanan', $payload)
            ->assertStatus(201);

        $order1 = Order::firstOrFail();

        $material->update(['price_per_unit_baku' => 150]);

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/buat-pesanan', $payload)
            ->assertStatus(201);

        $order2 = Order::latest('id')->firstOrFail();

        $this->assertNotEquals($order1->total_hpp, $order2->total_hpp);
        $this->assertGreaterThan($order1->total_hpp, $order2->total_hpp);
    }
}

