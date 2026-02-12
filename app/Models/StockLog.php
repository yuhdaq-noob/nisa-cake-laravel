<?php

namespace App\Models;

use App\Enums\StockLogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'type' => StockLogType::class,
        'amount' => 'integer',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
