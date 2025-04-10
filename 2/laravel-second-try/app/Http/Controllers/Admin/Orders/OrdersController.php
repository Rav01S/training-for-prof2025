<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdersController extends Controller
{
    public function index(): View
    {
        $orders = Order::all();

        return view('pages.admin.orders.index', compact('orders'));
    }
}
