<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController
{
    public function addToCart(Product $product, Request $request){
        $buy_qty = $request->get("buy_qty");
        $cartShop = session()->has("cartShop") ? session("cartShop") : [];
        foreach ($cartShop as $item){
            if($item->id == $product->id){
                $item->buy_qty = $item->buy_qty + $buy_qty;
                session(["cartShop"=>$cartShop]);
                return redirect()->back()->with("success","Product added to cart");
            }
        }
        $product->buy_qty = $buy_qty;
        $cartShop[] = $product;
        session(["cartShop"=>$cartShop]);
        return redirect()->back()->with("success","Product added to cart");
    }

    public function cartShop()
    {
        $cartShop = session()->has("cartShop")?session("cartShop"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cartShop as $item){
            $subtotal += $item->price * $item->buy_qty;
            if($item->buy_qty > $item->qty)
                $can_checkout = false;
        }
        $total = $subtotal*1.1; // vat: 10%
        return view('pages.customer.cartShop', compact('cartShop', 'subtotal', 'total', 'can_checkout'));
    }

    public function deleteFromCart(Product $product){
        $cartShop = session()->has("cartShop") ? session("cartShop") : [];
        $cartShop = array_filter($cartShop, function ($item) use ($product) {
            return $item->id != $product->id;
        });
        session(["cartShop" => $cartShop]);
        return redirect()->back()->with("success", "Đã xóa sản phẩm khỏi giỏ hàng");


    }

    public function updateCart(Product $product, Request $request)
    {
        $buy_qty = $request->get("buy_qty");
        $cartShop = session()->has("cartShop") ? session("cartShop") : [];

        foreach ($cartShop as $item) {
            if ($item->id == $product->id) {
                $item->buy_qty = $buy_qty;
                break;
            }
        }

        session(["cartShop" => $cartShop]);
        return redirect()->back()->with("success", "Shopping cart updated");
    }

    public function clearCart(){
        session()->forget("cartShop");
        return redirect()->back()->with("success", "All products have been removed from the cart");
    }
}
