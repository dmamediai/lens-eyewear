<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->status && $request->status !== 'all',
                fn($q) => $q->where('status', $request->status))
            ->when($request->search,
                fn($q) => $q->where('order_number', 'like', "%{$request->search}%")
                             ->orWhereHas('customer', fn($cq) => $cq->where('name', 'like', "%{$request->search}%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = collect(array_merge(['all'], Order::$statuses))
            ->mapWithKeys(fn($s) => [$s => $s === 'all'
                ? Order::count()
                : Order::where('status', $s)->count()]);

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load('customer');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:' . implode(',', Order::$statuses)]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }
}
