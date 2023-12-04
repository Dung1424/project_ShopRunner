<?php

namespace App\Http\Controllers;

use App\Models\Order;

class MyOrderController
{
    public function myOrder(){
        $Order = Order::where('user_id', auth()->user()->id)
            ->orderBy("created_at", "desc")
            ->paginate(5);
        return view("pages.customer.MyOrder.myOrder", ['orders' => $Order]);
    }

    public function myOrderPending() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 0)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderPending", ['orders' => $orders]);
    }

    public function myOrderConfirmed() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 1)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderConfirmed", ['orders' => $orders]);
    }

    public function myOrderShipping() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 2)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderShipping", ['orders' => $orders]);
    }

    public function myOrderShipped() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 3)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderShipped", ['orders' => $orders]);
    }

    public function myOrderComplete() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 4)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderComplete", ['orders' => $orders]);
    }

    public function myOrderCancel() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 5)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.MyOrder.myOrderCancel", ['orders' => $orders]);
    }

    public function orderDetail(Order $order){

        return view("pages.customer.MyOrder.orderDetail",compact("order"));
    }

    public function updateComplete(Order $order){
        $order->update([
            "status" => Order::COMPLETE
        ]);
        return redirect()->to("my-order");    }

    public function updateOrderStatusCancel(Order $order) {
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

        return redirect()->to("my-order");
    }
}
