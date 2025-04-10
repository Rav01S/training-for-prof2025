<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function index() {
        $orders = Order::all();

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
                    'image_url' => url($product->image_url)
                ]
            ];
        }

        return response()->json([
            'data' => $formated_orders
        ]);
    }

    public function store(Product $product, Request $request): JsonResponse
    {
        $httpClient = new Client(['verify' => false]);

        $data = [
            'price' => $product->price,
            'webhook_url' => env('APP_URL') . '/api/payments/webhook'
        ];

        $response = $httpClient->post('http://localhost:8081/payments', [
            'form_params' => $data,
            'headers' => [
                'accept' => 'application/json'
            ]
        ]);

        $dataFromPayment = json_decode($response->getBody()->getContents());

        Order::query()->create([
            'userId' => auth()->user()->id,
            'productId' => $product->id,
            'order_id' => $dataFromPayment->order_id
        ]);

        return response()->json([
            'pay_url' => $dataFromPayment->pay_url
        ]);
    }

    public function webhook(Request $request): Response
    {
        Log::debug($request);

        Order::query()->where('order_id', '=', $request->input('order_id'))->update([
            'status' => $request->input('status')
        ]);

        return response()->noContent();
    }
}
