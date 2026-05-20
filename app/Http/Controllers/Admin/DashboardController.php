<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $revenue30d  = Order::where('created_at', '>=', now()->subDays(30))
                            ->where('payment_status', 'paid')
                            ->sum('total');

        $orders30d   = Order::where('created_at', '>=', now()->subDays(30))->count();
        $newCustomers= Customer::where('created_at', '>=', now()->subDays(30))->count();
        $activeProds = Product::where('active', true)->count();

        $recentOrders = Order::with('customer')
                            ->latest()
                            ->limit(8)
                            ->get();

        $lowStock = Product::lowStock(5)->get();

        $topProducts = Order::select(
                            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(items, "$[*].product_id")) as pid'),
                            DB::raw('COUNT(*) as sales')
                        )
                        ->groupBy('pid')
                        ->limit(5)
                        ->get();

        // 7-day revenue chart data
        $chartData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label'   => $date->format('D'),
                'revenue' => Order::whereDate('created_at', $date)->sum('total'),
            ];
        });

        return view('admin.dashboard', compact(
            'revenue30d', 'orders30d', 'newCustomers', 'activeProds',
            'recentOrders', 'lowStock', 'chartData'
        ));
    }
}
