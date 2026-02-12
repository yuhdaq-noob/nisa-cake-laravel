<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit' => $this->unit,
            'unit_baku' => $this->unit_baku,
            'price_per_unit' => $this->price_per_unit,
            'price_per_unit_baku' => $this->price_per_unit_baku,
            'current_stock' => $this->current_stock,
            'min_stock_level' => $this->min_stock_level,
            'status' => $this->current_stock <= $this->min_stock_level ? 'Low Stock' : 'OK',
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
