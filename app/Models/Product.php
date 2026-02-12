<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'selling_price',
        'production_cost',
        'description',
    ];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'production_cost' => 'decimal:2',
    ];

    /**
     * Bill of Materials (BOM) relationship
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'product_materials')
            ->withPivot('quantity_needed')
            ->withTimestamps();
    }
}
