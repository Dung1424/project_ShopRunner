<?php

namespace App\Http\Controllers;

use App\Models\favoriteOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class baoCaoDoanhThuController
{
    function revenueChart(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $monthLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        $data = Order::selectRaw('MONTH(updated_at) AS month, SUM(order_products.qty) AS products_sold, SUM(orders.grand_total) AS total_revenue')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->where('orders.status', '4')
            ->groupBy('month')
            ->orderBy('month')
            ->whereYear('updated_at', $year)
            ->get();

        $productsSoldByMonth = $data->pluck('products_sold', 'month')->toArray();

        $productsSold = [];


        foreach (range(1, 12) as $month) {
            $productsSold[] = $productsSoldByMonth[$month] ?? 0;

        }

        return response()->json([
            'labels' => $monthLabels,
            'productsSold' => $productsSold,


        ]);
    }
    public function revenueChartDoanhThu(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $monthLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        $data = Order::selectRaw('MONTH(updated_at) AS month, SUM(order_products.qty) AS products_sold, SUM(orders.grand_total) AS total_revenue')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->where('orders.status', '4')
            ->groupBy('month')
            ->orderBy('month')
            ->whereYear('updated_at', $year)
            ->get();

        $revenueByMonth = $data->pluck('total_revenue', 'month')->toArray();

        $revenue = [];


        foreach (range(1, 12) as $month) {
            $revenue[] = $revenueByMonth[$month] ?? 0;

        }

        return response()->json([
            'labels' => $monthLabels,
            'revenue' => $revenue,

        ]);
    }

    protected function getDateRange($startDate, $endDate) {
        $dates = [];
        $currentDate = strtotime($startDate);
        $lastDate = strtotime($endDate);

        while ($currentDate <= $lastDate) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }
    public function revenueChartDay(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        $dateLabels = [];
        $productsSoldDay = [];

        $data = Order::selectRaw('DATE(updated_at) AS date, SUM(order_products.qty) AS products_sold, SUM(orders.grand_total) AS total_revenue')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->where('orders.status', '4')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $productsSoldByDate = $data->pluck('products_sold', 'date')->toArray();

        foreach ($this->getDateRange($startDate, $endDate) as $date) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $productsSoldDay[] = $productsSoldByDate[$formattedDate] ?? 0;
            $dateLabels[] = date('M d', strtotime($formattedDate)); // Định dạng ngày theo mong muốn
        }

        return response()->json([
            'labels' => $dateLabels,
            'productsSoldDay' => $productsSoldDay,
        ]);
    }
    public function revenueChartDoanhThuDay(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        $dateLabels = [];
        $revenueDay = [];

        $data = Order::selectRaw('DATE(updated_at) AS date, SUM(orders.grand_total) AS revenue')
            ->where('status', '4')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueByDate = $data->pluck('revenue', 'date')->toArray();

        foreach ($this->getDateRange($startDate, $endDate) as $date) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $revenueDay[] = $revenueByDate[$formattedDate] ?? 0;
            $dateLabels[] = date('M d', strtotime($formattedDate)); // Định dạng ngày theo mong muốn
        }

        return response()->json([
            'labels' => $dateLabels,
            'revenueDay' => $revenueDay,
        ]);
    }



    public function baoCaoDoanhThu() {
        // ô số liệu tổng hợp
        $totalEmployees = User::where('role', 'employee')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '4')->sum('grand_total');
        $totalCancelledOrders = Order::getTotalCancelledOrders();
        $outOfStockProductCount = Product::outOfStock()->count();

        // đơn hàng chờ xác nhận

        $pendingOrders = Order::where('status', Order::PENDING)->paginate(10);

        // bảng sản phẩm đã hết
        $outOfStockProducts = Product::outOfStock()
            ->orderBy("id", "desc")
            ->paginate(5);

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

        // bảng sản phẩm yêu thích
        $mostFavoriteProducts = FavoriteOrder::select('product_id', DB::raw('COUNT(user_id) as favorite_count'))
            ->groupBy('product_id')
            ->orderByRaw('COUNT(user_id) DESC')
            ->paginate(200);

        $mostFavoriteProductDetails = [];

        foreach ($mostFavoriteProducts as $product) {
            $productDetail = Product::find($product->product_id);
            if ($productDetail) {
                $mostFavoriteProductDetails[] = $productDetail;
            }
        }
        // review



        // bảng tổng đơn hàng
        $orders = Order::select('id', 'full_name', 'grand_total')
            ->with('Products')
            ->paginate(10);


        $orderTotals = [];

        foreach ($orders as $order) {
            $orderTotal = [
                'order_id' => $order->id,
                'customer' => $order->full_name,
                'products' => $order->Products->pluck('name')->implode(', '),
                'total_quantity' => $order->Products->count(),
                'total_amount' => $order->getGrandTotal(),
            ];

            $orderTotals[] = $orderTotal;
        }


        // Truyền số liệu vào view và trả về view
        return view("admin.pages.baoCaoDoanhThu", [
            'totalEmployees' => $totalEmployees,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalCancelledOrders' => $totalCancelledOrders,

            'outOfStockProductCount' => $outOfStockProductCount,
            'outOfStockProducts' => $outOfStockProducts,

            'mostFavoriteProductDetails' => $mostFavoriteProductDetails,
            'mostFavoriteProducts' => $mostFavoriteProducts,

            'bestSellingProductDetails' => $bestSellingProductDetails,
            'bestSellingProducts' => $bestSellingProducts,
            'orderTotals'=> $orderTotals,
            'orders' => $orders,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}


