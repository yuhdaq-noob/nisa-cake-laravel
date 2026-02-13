<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OverheadCostTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * Test that overhead cost is included in HPP calculation
     */
    public function test_overhead_cost_included_in_hpp(): void
    {
        // Create a material
        $material = Material::factory()->create([
            'price_per_unit_baku' => 10000, // Rp 10.000 per unit
            'current_stock' => 1000,
        ]);

        // Create a product with BOM and overhead cost
        $product = Product::factory()->create([
            'selling_price' => 100000,
            'overhead_cost_per_unit' => 5000, // Overhead: Rp 5.000 per unit
        ]);

        // Attach material to product: 2 units of material needed per product
        $product->materials()->attach($material, ['quantity_needed' => 2]);

        // Create order for 10 units
        $order = $this->orderService->createOrder([
            'customer_name' => 'Test Customer',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                ],
            ],
        ]);

        // Expected HPP calculation:
        // Per unit: (2 units × Rp 10.000) + Rp 5.000 (overhead) = Rp 25.000
        // Total for 10 units: Rp 25.000 × 10 = Rp 250.000
        $expectedHPP = (2 * 10000 + 5000) * 10;

        $this->assertEquals($expectedHPP, $order->total_hpp);
        $this->assertEquals(250000, $order->total_hpp);
    }

    /**
     * Test that overhead cost is calculated correctly when material price changes
     */
    public function test_hpp_reflects_current_material_price(): void
    {
        $material = Material::factory()->create([
            'price_per_unit_baku' => 5000,
            'current_stock' => 500,
        ]);

        $product = Product::factory()->create([
            'selling_price' => 50000,
            'overhead_cost_per_unit' => 2000,
        ]);

        $product->materials()->attach($material, ['quantity_needed' => 1]);

        // Create first order with original price
        $order1 = $this->orderService->createOrder([
            'customer_name' => 'Customer 1',
            'items' => [['product_id' => $product->id, 'quantity' => 5]],
        ]);

        // Expected: (1 × 5000) + 2000 = 7000 per unit × 5 = 35000
        $this->assertEquals(35000, $order1->total_hpp);

        // Update material price
        $material->update(['price_per_unit_baku' => 10000]);

        // Create second order with new price
        $order2 = $this->orderService->createOrder([
            'customer_name' => 'Customer 2',
            'items' => [['product_id' => $product->id, 'quantity' => 5]],
        ]);

        // Expected: (1 × 10000) + 2000 = 12000 per unit × 5 = 60000
        $this->assertEquals(60000, $order2->total_hpp);

        // Verify that orders have different HPP due to material price change
        $this->assertNotEquals($order1->total_hpp, $order2->total_hpp);
    }

    /**
     * Test that zero overhead cost is handled correctly
     */
    public function test_hpp_with_zero_overhead_cost(): void
    {
        $material = Material::factory()->create([
            'price_per_unit_baku' => 1000,
            'current_stock' => 100,
        ]);

        $product = Product::factory()->create([
            'selling_price' => 10000,
            'overhead_cost_per_unit' => 0, // No overhead
        ]);

        $product->materials()->attach($material, ['quantity_needed' => 1]);

        $order = $this->orderService->createOrder([
            'customer_name' => 'Test',
            'items' => [['product_id' => $product->id, 'quantity' => 3]],
        ]);

        // Expected: (1 × 1000) + 0 = 1000 per unit × 3 = 3000
        $this->assertEquals(3000, $order->total_hpp);
    }

    /**
     * Test that product without materials has only overhead cost
     */
    public function test_hpp_for_product_without_materials(): void
    {
        $product = Product::factory()->create([
            'selling_price' => 50000,
            'overhead_cost_per_unit' => 5000,
        ]);

        // Product has no materials attached

        $order = $this->orderService->createOrder([
            'customer_name' => 'Test',
            'items' => [['product_id' => $product->id, 'quantity' => 2]],
        ]);

        // Expected: 0 (no materials) + 5000 (overhead) = 5000 per unit × 2 = 10000
        $this->assertEquals(10000, $order->total_hpp);
    }
}
