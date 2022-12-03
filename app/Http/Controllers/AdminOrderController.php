<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::all();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('order-deleted', 'Order has been deleted');
    }
}
