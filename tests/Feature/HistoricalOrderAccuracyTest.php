<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoricalOrderAccuracyTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * Test that order items store selling price at transaction time
     */
    public function test_order_items_store_selling_price_at_transaction_time(): void
    {
        // Create product with initial price
        $product = Product::factory()->create([
            'selling_price' => 100000,
        ]);

        // Create order with current price
        $order = $this->orderService->createOrder([
            'customer_name' => 'Customer 1',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 5],
            ],
        ]);

        // Verify order item stores correct price
        $orderItem = $order->items()->first();
        $this->assertEquals(100000, $orderItem->price_per_unit);

        // Now change product price
        $product->update(['selling_price' => 150000]);

        // Original order should still have old price
        $orderItem->refresh();
        $this->assertEquals(100000, $orderItem->price_per_unit);

        // New order should have new price
        $order2 = $this->orderService->createOrder([
            'customer_name' => 'Customer 2',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 5],
            ],
        ]);

        $orderItem2 = $order2->items()->first();
        $this->assertEquals(150000, $orderItem2->price_per_unit);

        // Orders have different prices
        $this->assertNotEquals($orderItem->price_per_unit, $orderItem2->price_per_unit);
    }

    /**
     * Test that order items store HPP per unit at transaction time
     */
    public function test_order_items_store_hpp_per_unit_at_transaction_time(): void
    {
        // Create material with initial price
        $material = Material::factory()->create([
            'price_per_unit_baku' => 50000,
            'current_stock' => 500,
        ]);

        // Create product with BOM
        $product = Product::factory()->create([
            'selling_price' => 100000,
            'overhead_cost_per_unit' => 5000,
        ]);

        // Attach material: 2 units needed per product
        $product->materials()->attach($material, ['quantity_needed' => 2]);

        // Create first order
        $order1 = $this->orderService->createOrder([
            'customer_name' => 'Customer 1',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 3],
            ],
        ]);

        // Expected HPP: (2 × 50000) + 5000 = 105000 per unit
        $orderItem1 = $order1->items()->first();
        $this->assertEquals(105000, $orderItem1->hpp_per_unit);

        // Now change material price
        $material->update(['price_per_unit_baku' => 70000]);

        // First order should still have old HPP
        $orderItem1->refresh();
        $this->assertEquals(105000, $orderItem1->hpp_per_unit);

        // Create second order with new price
        $order2 = $this->orderService->createOrder([
            'customer_name' => 'Customer 2',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 3],
            ],
        ]);

        // Expected new HPP: (2 × 70000) + 5000 = 145000 per unit
        $orderItem2 = $order2->items()->first();
        $this->assertEquals(145000, $orderItem2->hpp_per_unit);

        // Different HPP
        $this->assertNotEquals($orderItem1->hpp_per_unit, $orderItem2->hpp_per_unit);
    }

    /**
     * Test that profit margin can be accurately calculated from historical data
     */
    public function test_profit_margin_calculation_from_historical_data(): void
    {
        $material = Material::factory()->create([
            'price_per_unit_baku' => 30000,
            'current_stock' => 500,
        ]);

        $product = Product::factory()->create([
            'selling_price' => 100000,
            'overhead_cost_per_unit' => 5000,
        ]);

        $product->materials()->attach($material, ['quantity_needed' => 1]);

        // Create order
        $order = $this->orderService->createOrder([
            'customer_name' => 'Test',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 10],
            ],
        ]);

        // Get order item
        $orderItem = $order->items()->first();

        // Calculate profit margin from historical data
        $sellingPrice = $orderItem->price_per_unit; // 100000
        $cost = $orderItem->hpp_per_unit; // (1 × 30000) + 5000 = 35000
        $profit = $sellingPrice - $cost; // 65000
        $marginPercent = ($profit / $sellingPrice) * 100; // 65%

        $this->assertEquals(100000, $sellingPrice);
        $this->assertEquals(35000, $cost);
        $this->assertEquals(65000, $profit);
        $this->assertEquals(65, $marginPercent);

        // Now change prices - profit should NOT change for old order
        $material->update(['price_per_unit_baku' => 50000]);
        $product->update(['selling_price' => 120000]);

        // Recalculate from historical data
        $orderItem->refresh();
        $sellingPrice = $orderItem->price_per_unit;
        $cost = $orderItem->hpp_per_unit;
        $profit = $sellingPrice - $cost;

        // Should still reflect original prices
        $this->assertEquals(100000, $sellingPrice);
        $this->assertEquals(35000, $cost);
        $this->assertEquals(65000, $profit);
    }

    /**
     * Test that multiple price changes don't affect historical accuracy
     */
    public function test_multiple_price_changes_dont_affect_historical_accuracy(): void
    {
        $material = Material::factory()->create([
            'price_per_unit_baku' => 10000,
            'current_stock' => 1000,
        ]);

        $product = Product::factory()->create([
            'selling_price' => 50000,
            'overhead_cost_per_unit' => 2000,
        ]);

        $product->materials()->attach($material, ['quantity_needed' => 2]);

        // Create 3 orders with price changes in between
        $orders = [];
        for ($i = 1; $i <= 3; $i++) {
            $order = $this->orderService->createOrder([
                'customer_name' => "Customer {$i}",
                'items' => [
                    ['product_id' => $product->id, 'quantity' => 2],
                ],
            ]);
            $orders[] = $order;

            // Change prices after each order
            if ($i < 3) {
                $material->update(['price_per_unit_baku' => 10000 + (5000 * $i)]);
                $product->update(['selling_price' => 50000 + (10000 * $i)]);
            }
        }

        // Verify each order has correct historical data
        // Order 1: material=10000, product=50000, overhead=2000
        $this->assertEquals(50000, $orders[0]->items()->first()->price_per_unit);
        $this->assertEquals(22000, $orders[0]->items()->first()->hpp_per_unit); // (2×10000) + 2000

        // Order 2: material=15000 (updated), product=60000 (updated), overhead=2000
        $this->assertEquals(60000, $orders[1]->items()->first()->price_per_unit);
        $this->assertEquals(32000, $orders[1]->items()->first()->hpp_per_unit); // (2×15000) + 2000

        // Order 3: material=20000 (updated), product=70000 (updated), overhead=2000
        $this->assertEquals(70000, $orders[2]->items()->first()->price_per_unit);
        $this->assertEquals(42000, $orders[2]->items()->first()->hpp_per_unit); // (2×20000) + 2000
    }
}
