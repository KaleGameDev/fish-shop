<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class WarehouseDashboardController extends Controller
{
    public function index()
    {
        // 1. Các con số tổng quan
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $lowStockProducts = Product::where('stock', '<', 5)->get();

        // 2. Dữ liệu cho Biểu đồ Doanh thu 7 ngày qua
        $revenue7Days = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total) as sum')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartDates = [];
        $chartRevenues = [];
        // Điền dữ liệu vào mảng cho biểu đồ
        foreach ($revenue7Days as $item) {
            $chartDates[] = Carbon::parse($item->date)->format('d/m');
            $chartRevenues[] = $item->sum;
        }

        // 3. Dữ liệu cho Biểu đồ Trạng thái đơn hàng
        $orderStats = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $chartOrderStatuses = [
            $orderStats['pending'] ?? 0,
            $orderStats['shipping'] ?? 0,
            $orderStats['completed'] ?? 0,
            $orderStats['cancelled'] ?? 0,
        ];

        return view('warehouse.dashboard', compact(
            'totalRevenue', 'pendingOrders', 'totalCustomers', 'lowStockProducts',
            'chartDates', 'chartRevenues', 'chartOrderStatuses'
        ));
    }
}