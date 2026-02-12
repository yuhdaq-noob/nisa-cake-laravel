<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Get all products with their materials
     */
    public function index(): AnonymousResourceCollection
    {
        $products = Product::with('materials')->get();

        return ProductResource::collection($products);
    }
}
