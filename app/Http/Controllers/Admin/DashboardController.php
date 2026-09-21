<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FinancialRecord;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $doneOrders     = Order::where('status', 'done')->count();

        // Rental Stats
        $readyCount     = Product::where('rental_status', 'Ready')->count();
        $rentCount      = Product::where('rental_status', 'Rent')->count();
        $onProcessCount = Product::where('rental_status', 'On Process')->count();

        // Revenue this month
        $revenueThisMonth = FinancialRecord::income()->thisMonth()->sum('amount');
        $expenseThisMonth = FinancialRecord::expense()->thisMonth()->sum('amount');
        $profitThisMonth  = $revenueThisMonth - $expenseThisMonth;

        // Chart: Orders per month (last 6 months)
        $ordersChart = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData   = [];
        $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($ordersChart as $row) {
            $chartLabels[] = $months[$row->month] . ' ' . $row->year;
            $chartData[]   = $row->total;
        }

        // Revenue chart (last 6 months)
        $revenueChart = FinancialRecord::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('SUM(CASE WHEN type="income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type="expense" THEN amount ELSE 0 END) as expense')
            )
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();

        $revenueLabels  = [];
        $incomeData     = [];
        $expenseData    = [];
        foreach ($revenueChart as $row) {
            $revenueLabels[] = $months[$row->month] . ' ' . $row->year;
            $incomeData[]    = (float)$row->income;
            $expenseData[]   = (float)$row->expense;
        }

        // Recent orders
        $recentOrders = Order::with('product')->latest()->limit(5)->get();

        // Low stock products
        $lowStock = Product::where('stock', '<', 5)->where('is_active', true)->with('category')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'pendingOrders', 'doneOrders',
            'readyCount', 'rentCount', 'onProcessCount',
            'revenueThisMonth', 'expenseThisMonth', 'profitThisMonth',
            'chartLabels', 'chartData',
            'revenueLabels', 'incomeData', 'expenseData',
            'recentOrders', 'lowStock'
        ));
    }
}
