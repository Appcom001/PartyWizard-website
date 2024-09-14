<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    // Display analytics overview
    public function index(Request $request)
    {
        $topProducts = Product::all();

        $totalSales = Order::sum('total_amount');

        $totalOrders = Order::count();

        $refundedAmount = Order::where('status', 'canceled')->sum('total_amount');

        $salesOverview = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as total_sales'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_sales', 'month');

        return view('admin.analytics', compact('topProducts', 'totalSales', 'totalOrders', 'refundedAmount', 'salesOverview'));
    }
}
