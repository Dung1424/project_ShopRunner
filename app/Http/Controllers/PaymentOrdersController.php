<?php

namespace App\Http\Controllers;

use App\Events\CreateNewOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentOrdersController
{
    public function checkOut(){
        $cartShop = session()->has("cartShop") ? session("cartShop") : [];
        $subtotal = 0;
        $can_checkout = true;
        $errorMessages = [];

        foreach ($cartShop as $item) {
            $product = Product::find($item->id);

            if ($product->qty < $item->buy_qty) {
                // Sản phẩm không đủ số lượng
                $errorMessages['error_'.$item->id] = 'The product is out of stock or in insufficient quantity.';
                $can_checkout = false;
            }

            $subtotal += $item->price * $item->buy_qty;
            if ($item->buy_qty > $item->qty) {
                $can_checkout = false;
            }
        }

        $total = $subtotal * 1.1; // VAT: 10%

        if (count($cartShop) == 0 || !$can_checkout) {
            // Nếu giỏ hàng trống hoặc có sản phẩm không đủ số lượng, chuyển hướng về giỏ hàng
            session()->flash('cart_errors', $errorMessages);
            return redirect()->to("cart");
        }

        // Nếu mọi thứ đều ổn, tiến hành đến trang thanh toán
        return view("pages.customer.checkOut", compact("cartShop", "subtotal", "total"));
    }
    public function placeOrder(Request $request){
        $request->validate([
            "full_name"=>"required|min:6",
            "address"=>"required",
            "tel"=> "required|min:9|max:11",
            "email"=>"required",
            "shipping_method"=>"required",
            "payment_method"=>"required"
        ],[
            "required"=>"Vui lòng nhập thông tin."
        ]);


        $user = Auth::user(); // Truy cập thông tin người dùng đã đăng nhập

        if (!$user) {
            // Người dùng chưa đăng nhập, thực hiện xử lý tương ứng hoặc thông báo lỗi.
            return redirect()->back()->with('error', 'You need to log in to place an order.');
        }

        // calculate
        $cartShop = session()->has("cartShop") ? session("cartShop") : [];
        $subtotal = 0;
        foreach ($cartShop as $item) {
            $subtotal += $item->price * $item->buy_qty;
        }
        $shippingCost = 0;
        if ($request->get("shipping_method") == "Express") {
            $shippingCost = 5;
        }

        $total = $subtotal * 1.1 + $shippingCost;

        // Tạo đơn hàng mới và lưu vào cơ sở dữ liệu
        $order = Order::create([
            "user_id" => $user->id, // Lưu user_id của người dùng đã đăng nhập
            "grand_total" => $total,
            "full_name" => $request->get("full_name"),
            "email" => $request->get("email"),
            "tel" => $request->get("tel"),
            "address" => $request->get("address"),
            "shipping_method" => $request->get("shipping_method"),
            "payment_method" => $request->get("payment_method")
        ]);

        foreach ($cartShop as $item) {
            DB::table("order_products")->insert([
                "order_id" => $order->id,
                "product_id" => $item->id,
                "qty" => $item->buy_qty,
                "price" => $item->price
            ]);
            $product = Product::find($item->id);
            $product->update(["qty" => $product->qty - $item->buy_qty]);
        }
        if ($order->payment_method === 'COD') {
            // Nếu là "COD", xóa toàn bộ sản phẩm khỏi giỏ hàng
            session()->forget("cartShop");
            event(new CreateNewOrder($order));
        }

        // thanh toan paypal
        if($order->payment_method == "Paypal"){
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => url("paypal-success",['order'=>$order]),
                    "cancel_url" => url("paypal-cancel",['order'=>$order]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($order->grand_total,2,".","") // 1234.45
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {

                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                return redirect()
                    ->back()
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->back()
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }
        return redirect()->to("thank-you/$order->id");
    }

    // thanh toán paypal
    public function paypalSuccess(Order $order){
        // Đầu tiên, kiểm tra xem payment_method có phải là "COD" không
        // Cập nhật trạng thái đơn hàng và làm bất kỳ công việc khác liên quan đến thanh toán ở đây.
        session()->forget("cartShop");
        event(new CreateNewOrder($order));
        $order->update([
            "is_paid" => true,
            "status" => Order::CONFIRMED
        ]);

        return redirect()->to("thank-you/$order->id");
    }

    public function paypalCancel(Order $order){
        $order->update([
            "status" => Order::CANCEL
        ]);
        return redirect()->to("thank-you/$order->id");
    }
}
