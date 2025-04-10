<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'webhook_url' => 'required|url',
        ]);

        $orderId = (string) Str::uuid();
        $payUrl = route('payment.form', ['orderId' => $orderId]);

        // Сохраняем данные без success_url и failed_url
        Cache::put("payment:$orderId", [
            'price' => $validated['price'],
            'webhook_url' => $validated['webhook_url'],
        ], now()->addMinutes(30));

        return response()->json([
            'pay_url' => $payUrl,
            'order_id' => $orderId,
        ]);
    }

    public function showForm($orderId)
    {
        if (!Cache::has("payment:$orderId")) {
            return response("Order not found", 404);
        }

        return view('pay.form', ['orderId' => $orderId]);
    }

    public function submitForm(Request $request, $orderId)
    {
        $order = Cache::get("payment:$orderId");

        if (!$order) {
            return response("Order expired", 404);
        }

        $card = preg_replace('/\s+/', '', $request->input('card_number'));
        $status = $card === '8888000000001111' ? 'success' : 'failed';

        Http::post($order['webhook_url'], [
            'order_id' => $orderId,
            'status' => $status,
        ]);

        Cache::forget("payment:$orderId");

        // Жестко прописываем URL для редиректа
        $redirectUrl = $status === 'success'
            ? 'http://localhost:8080/'
            : 'http://localhost:8080/payment/failed';

        return redirect()->away($redirectUrl);
    }
}
