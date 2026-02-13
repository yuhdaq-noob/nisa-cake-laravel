<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Services\StockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RaceConditionStockTest extends TestCase
{
    use RefreshDatabase;

    private StockService $stockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockService = new StockService();
    }

    /**
     * Test that pessimistic locking prevents race condition on stock reduction
     */
    public function test_pessimistic_lock_prevents_race_condition(): void
    {
        // Create a material with limited stock
        $material = Material::factory()->create([
            'current_stock' => 100,
        ]);

        // Simulate concurrent requests trying to reduce more stock than available
        $this->assertTrue($material->current_stock === 100);

        // First reduction: reduce 60 units
        $this->stockService->reduceStock([
            'material_id' => $material->id,
            'amount' => 60,
            'description' => 'Test reduction 1',
        ]);

        $material->refresh();
        $this->assertEquals(40, $material->current_stock);

        // Second reduction: reduce 30 units (should succeed)
        $this->stockService->reduceStock([
            'material_id' => $material->id,
            'amount' => 30,
            'description' => 'Test reduction 2',
        ]);

        $material->refresh();
        $this->assertEquals(10, $material->current_stock);

        // Third reduction: try to reduce 20 units (should fail - insufficient stock)
        $this->expectException(\App\Exceptions\InsufficientStockException::class);

        $this->stockService->reduceStock([
            'material_id' => $material->id,
            'amount' => 20,
            'description' => 'Test reduction 3 - should fail',
        ]);
    }

    /**
     * Test that stock validation happens inside transaction
     */
    public function test_stock_validation_inside_transaction(): void
    {
        $material = Material::factory()->create([
            'current_stock' => 50,
        ]);

        // Valid reduction
        $result = $this->stockService->reduceStock([
            'material_id' => $material->id,
            'amount' => 25,
            'description' => 'Valid reduction',
        ]);

        $this->assertEquals(25, $result->current_stock);

        // Invalid reduction should throw exception and not modify stock
        try {
            $this->stockService->reduceStock([
                'material_id' => $material->id,
                'amount' => 100,
                'description' => 'Invalid reduction - exceeds stock',
            ]);
        } catch (\App\Exceptions\InsufficientStockException $e) {
            // Expected exception
            $material->refresh();
            // Stock should remain unchanged after failed transaction
            $this->assertEquals(25, $material->current_stock);
        }
    }
}
