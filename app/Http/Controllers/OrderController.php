<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\MaterialNotFoundException;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Get all orders
     */
    public function index(): AnonymousResourceCollection
    {
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return OrderResource::collection($orders);
    }

    /**
     * Show a single order
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order->load('items.product'));
    }

    /**
     * Mark order as completed
     */
    public function complete(Order $order): JsonResponse
    {
        $order->status = OrderStatus::COMPLETED->value;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order marked as completed.',
            'data' => new OrderResource($order->load('items.product')),
        ]);
    }

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
