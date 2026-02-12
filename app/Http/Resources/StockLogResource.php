<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'material_id' => $this->material_id,
            'material' => [
                'id' => $this->material?->id,
                'name' => $this->material?->name,
                'unit_baku' => $this->material?->unit_baku,
                'price_per_unit_baku' => $this->material?->price_per_unit_baku,
            ],
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
