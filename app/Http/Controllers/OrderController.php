<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\MaterialNotFoundException;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Store a newly created order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Order processed successfully.',
                'data' => new OrderResource($order->load('items.product')),
            ], 201);

        } catch (InsufficientStockException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);

        } catch (MaterialNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Order creation failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order.',
            ], 500);
        }
    }
}
