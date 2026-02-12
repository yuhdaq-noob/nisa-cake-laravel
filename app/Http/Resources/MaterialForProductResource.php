<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialForProductResource extends JsonResource
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
            'quantity_needed' => $this->pivot->quantity_needed,
            'total_cost' => $this->price_per_unit * $this->pivot->quantity_needed,
        ];
    }
}
