<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
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

    /**
     * Show a single product
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('materials'));
    }

    /**
     * Store a new product
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'data' => new ProductResource($product->load('materials')),
        ], 201);
    }

    /**
     * Update a product including overhead cost
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product->load('materials')),
        ], 200);
    }
}
