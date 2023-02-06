<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminOrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request)// : View
    {
        $orders = Order::query();

        if ($request->has('status') && $request->get('status') !== 'all') {
            $orders = $orders->where('status', $request->get('status'))->get();
        } else {
            $orders = Order::all();
        }

        $statuses = Order::STATUS_LABELS;

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $statuses = Order::STATUS_LABELS;

        return view('admin.orders.show', compact('order', 'statuses'));
    }


    public function update(Order $order, AdminOrderUpdateRequest $request)// : RedirectResponse
    {
        $validated = $request->validated();

       $order->update($validated);

        return redirect()->back()->with('order-updated', 'Order has been updated');
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('order-deleted', 'Order has been deleted');
    }
}
