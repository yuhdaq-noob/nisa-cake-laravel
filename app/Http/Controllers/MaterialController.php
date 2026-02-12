<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Requests\ReduceStockRequest;
use App\Http\Requests\UpdateMaterialPriceRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use App\Models\MaterialPriceLog;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MaterialController extends Controller
{
    public function __construct(
        private StockService $stockService
    ) {}

    /**
     * Get all materials ordered by stock level
     */
    public function index(): AnonymousResourceCollection
    {
        $materials = Material::with('stockLogs')
            ->orderBy('current_stock', 'asc')
            ->get();

        return MaterialResource::collection($materials);
    }

    /**
     * Reduce stock from material (manual adjustment)
     */
    public function reduceStock(ReduceStockRequest $request): JsonResponse
    {
        try {
            $material = $this->stockService->reduceStock($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Stock successfully reduced. Adjustment recorded.',
                'data' => new MaterialResource($material),
            ], 200);

        } catch (InsufficientStockException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Stock reduction failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reduce stock.',
            ], 500);
        }
    }

    /**
     * Update material price per base unit and sync per-unit price.
     */
    public function updatePrice(UpdateMaterialPriceRequest $request, Material $material): JsonResponse
    {
        $unit = strtolower(trim((string) $material->unit));
        $conversionMap = [
            'gram' => ['unit_baku' => 'kg', 'factor' => 1000],
            'g' => ['unit_baku' => 'kg', 'factor' => 1000],
            'ml' => ['unit_baku' => 'liter', 'factor' => 1000],
        ];

        $pricePerBaku = (float) $request->validated()['price_per_unit_baku'];
        $oldPricePerUnit = $material->price_per_unit;
        $oldPricePerUnitBaku = $material->price_per_unit_baku;

        if (array_key_exists($unit, $conversionMap)) {
            $unitBaku = $conversionMap[$unit]['unit_baku'];
            $factor = $conversionMap[$unit]['factor'];
            $pricePerUnit = $pricePerBaku / $factor;
        } else {
            $unitBaku = $material->unit;
            $pricePerUnit = $pricePerBaku;
        }

        $material->unit_baku = $unitBaku;
        $material->price_per_unit_baku = $pricePerBaku;
        $material->price_per_unit = $pricePerUnit;
        $material->save();

        MaterialPriceLog::create([
            'material_id' => $material->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'old_price_per_unit' => $oldPricePerUnit,
            'new_price_per_unit' => $material->price_per_unit,
            'old_price_per_unit_baku' => $oldPricePerUnitBaku,
            'new_price_per_unit_baku' => $material->price_per_unit_baku,
            'unit_baku' => $material->unit_baku,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Harga berhasil diperbarui.',
            'data' => new MaterialResource($material),
        ], 200);
    }
}
