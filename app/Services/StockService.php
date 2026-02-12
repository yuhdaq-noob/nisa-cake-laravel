<?php

namespace App\Services;

use App\Enums\StockLogType;
use App\Exceptions\InsufficientStockException;
use App\Models\Material;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    /**
     * Add stock to material
     */
    public function addStock(array $data): Material
    {
        return DB::transaction(function () use ($data) {
            // Create stock log
            StockLog::create([
                'material_id' => $data['material_id'],
                'type' => StockLogType::IN->value,
                'amount' => $data['amount'],
                'description' => $data['description'],
            ]);

            // Increment stock
            $material = Material::findOrFail($data['material_id']);
            $material->increment('current_stock', $data['amount']);

            Log::channel('business')->info('Stock added', [
                'material_id' => $material->id,
                'material_name' => $material->name,
                'amount' => $data['amount'],
                'description' => $data['description'],
                'current_stock' => $material->current_stock,
            ]);

            return $material;
        });
    }

    /**
     * Reduce stock from material
     *
     * @throws InsufficientStockException
     */
    public function reduceStock(array $data): Material
    {
        $material = Material::findOrFail($data['material_id']);

        // Check if stock is sufficient
        if ($material->current_stock < $data['amount']) {
            throw new InsufficientStockException(
                $material->name,
                $material->current_stock,
                $data['amount']
            );
        }

        return DB::transaction(function () use ($data, $material) {
            // Decrement stock
            $material->decrement('current_stock', $data['amount']);

            // Create stock log
            StockLog::create([
                'material_id' => $material->id,
                'type' => StockLogType::OUT->value,
                'amount' => $data['amount'],
                'description' => '[MANUAL] '.$data['description'],
            ]);

            Log::channel('business')->info('Stock reduced', [
                'material_id' => $material->id,
                'material_name' => $material->name,
                'amount' => $data['amount'],
                'description' => $data['description'],
                'current_stock' => $material->current_stock,
            ]);

            return $material;
        });
    }
}
