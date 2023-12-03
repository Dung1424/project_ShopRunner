<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function adminDashboard(){
        // ô số liệu tổng hợp
        $totalUser = User::whereNull('role')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '4')->sum('grand_total');
        $totalCancelledOrders = Order::getTotalCancelledOrders();
        $outOfStockProductCount = Product::outOfStock()->count();

        // đơn hàng chờ xác nhận

        $pendingOrders = Order::where('status', Order::PENDING)->paginate(5);


        // bảng sản phẩm bán chạy
        $bestSellingProducts = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng có trạng thái đã hoàn thành
            ->select('order_products.product_id', DB::raw('SUM(order_products.qty) as total_qty_sold'))
            ->groupBy('order_products.product_id')
            ->orderBy('total_qty_sold', 'desc')
            ->paginate(5);

        $bestSellingProductDetails = [];

        foreach ($bestSellingProducts as $product) {
            $productDetail = Product::find($product->product_id);
            if ($productDetail) {
                $productDetail->total_qty_sold = $product->total_qty_sold;
                $bestSellingProductDetails[] = $productDetail;
            }
        }


        // Truyền số liệu vào view và trả về view
        return view("admin.pages.adminDashboard", [
            'totalUser' =>  $totalUser,

            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalCancelledOrders' => $totalCancelledOrders,

            'outOfStockProductCount' => $outOfStockProductCount,

            'bestSellingProductDetails' => $bestSellingProductDetails,
            'bestSellingProducts' => $bestSellingProducts,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
