<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerManagerController
{
    public function qlKhachHang(){
        $user = User::whereNull('role')->get();
        return view("admin.pages.User.qlKhachHang", compact("user"));
    }
    public function orderUser(Request $request, User $user){
        $grand_total = $request->get("grand_total");
        $shipping_method = $request->get("shipping_method");
        $payment_method = $request->get("payment_method");
        $paid = $request->get("paid");
        $status = $request->get("rate");

        $orders = $user->orders()
            ->Search($request)
            ->FilterByGrandTotal($request)
            ->FilterByShippingMethod($request)
            ->FilterByStatus($request)
            ->FilterByPaymentMethod($request)
            ->FilterByPaid($request)
            ->orderBy("id","desc")
            ->paginate(20);

        $categories = Category::all();

        return view("admin.pages.User.orderUser", [
            "user" => $user,
            "orders" => $orders,
            "categories" => $categories
        ]);
    }

    public function orderDetailUser(Order $order){
        return view("admin.pages.User.orderDetailUser", compact('order'));
    }
}
