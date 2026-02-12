<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialPriceLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'material' => [
                'id' => $this->material?->id,
                'name' => $this->material?->name,
            ],
            'old_price_per_unit_baku' => $this->old_price_per_unit_baku,
            'new_price_per_unit_baku' => $this->new_price_per_unit_baku,
            'unit_baku' => $this->unit_baku,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
