<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Models\Category;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function qlDonHang(Request $request){
        $grand_total = $request->get("grand_total");
        $shipping_method = $request->get("shipping_method");
        $payment_method = $request->get("payment_method");
        $paid = $request->get("paid");
        $status = $request->get("rate");

        $orders = Order::Search($request)
            ->FilterByGrandTotal($request)
            ->FilterByShippingMethod($request)
            ->FilterByStatus($request)
            ->FilterByPaymentMethod($request)
            ->FilterByPaid($request)
            ->orderBy("id","desc")
            ->paginate(20);
        $categories = Category::all();
        return view("admin.pages.Order.qlDonHang",[
            "orders"=>$orders,
            'categories'=>$categories
        ]);
    }

    public function detail(Order $order){
        return view("admin.pages.Order.detail", compact('order'));
    }


    public function updateOrderStatus(Order $order){
        $currentStatus = $order->status;
        $currentPaymentMethod = $order->payment_method;
        // Kiểm tra trạng thái hiện tại và cập nhật trạng thái mới dựa trên điều kiện
        if ($currentStatus === Order::PENDING) {
            $newStatus = Order::CONFIRMED;
        } elseif ($currentStatus === Order::CONFIRMED) {
            $newStatus = Order::SHIPPING;
        } elseif ($currentStatus === Order::SHIPPING) {
            $newStatus = Order::SHIPPED;
        } else {
            // Trạng thái hiện tại không phù hợp với việc cập nhật
            // Bạn có thể xử lý tùy ý ở đây, ví dụ thông báo lỗi hoặc không thay đổi trạng thái.
            // Ví dụ: return redirect()->back()->with('error', 'Không thể cập nhật trạng thái cho đơn hàng này.');
            return redirect()->to("admin/admin-quan-ly-đon-hang");
        }

        if ($currentPaymentMethod === 'COD' && $newStatus === Order::SHIPPED) {
            $order->update([
                "is_paid" => true,
                "status" => $newStatus
            ]);
        } else {
            $order->update([
                "status" => $newStatus
            ]);
        }
        return redirect()->to("admin/admin-quan-ly-đon-hang");
    }

    public function updateOrderStatusCancel(Order $order){


        $newStatus = Order::CANCEL;

        // Lấy danh sách sản phẩm trong đơn hàng
        $products = $order->products;

        // Cập nhật trạng thái của đơn hàng
        $order->update([
            "status" => $newStatus
        ]);

        // Cập nhật số lượng sản phẩm trong bảng product
        foreach ($products as $product) {
            $product->update([
                'qty' => $product->qty + $product->pivot->qty
                // Giả sử 'quantity' là trường chứa số lượng sản phẩm trong bảng product,
                // 'pivot' là bảng trung gian giữa order và product, chứa thông tin thêm như số lượng trong đơn hàng
            ]);
        }


        return redirect()->to("admin/admin-quan-ly-đon-hang");
    }

}
