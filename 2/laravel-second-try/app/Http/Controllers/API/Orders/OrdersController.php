<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $orders = $user->orders()->get();

        $formated_orders = [];
        foreach ($orders as $order) {
            $product = $order->product();
            $formated_orders[] = [
                'id' => $order->id,
                'status' => $order->status,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image_url' => url($product->image_url),
                ]
            ];
        }

        return response()->json([
            'data' => $formated_orders
        ]);
    }

    public function store(Product $product, Request $request): JsonResponse
    {
        $user = auth()->user();

        $dataForRequest = [
            'price' => $product->price,
            'webhook_url' => url('/api/payments/webhook')
        ];

        try {
            $response = Http::post('http://localhost:8081/payments', $dataForRequest);

            $data = $response->json();

            $order = Order::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'status' => 'pending',
                'order_id' => $data['order_id']
            ]);

            return response()->json([
                'pay_url' => $data['pay_url']
            ]);

        } catch (e) {
            return response()->json([
                'error' => 'Не удалось создать ссылку на платеж'
            ], 500);
        }
    }

    public function webhook(Request $request): Response
    {
        $data = $request->all();

        $order = Order::query()
            ->where('order_id', '=', $data['order_id'])
            ->first()
            ->update([
                'status' => $data['status']
            ]);

        return response()->noContent();
    }
}
