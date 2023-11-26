<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NhanVienOrderController extends Controller
{
    public function QuanLyDonHang(){
        $orders = Order::orderBy("id","desc")->paginate(20);
        return view("NhanVien.pages.Order.qlDonHang",["orders"=>$orders]);
    }

    public function editDonHang(Order $order){
        return view("NhanVien.pages.Order.editDonHang", compact('order'));
    }

    public function update(Order $order,Request $request){
        $request->validate([
            "full_name"=>"required|min:6",
            "grand_total"=>"required|numeric|min:0",
            "status"=>"required|numeric|min:0|max:5",
            "tel"=>"required|min:9|max:11",
        ]);
        try {
            $order->update([
                'user_id' => $request->get('user_id'),
                'full_name' => $request->get('full_name'),
                'tel' => $request->get('tel'),
                'address' => $request->get('address'),
                'grand_total' => $request->get('grand_total'),
                'shipping_method' => $request->get('shipping_method'),
                'payment_method' => $request->get('payment_method'),
                'status' => $request->get('status'),
                'note' => $request->get('note'),
                'is_paid' => $request->get('is_paid'),
            ]);



            return redirect()->to("/nhan-vien-quan-ly-đon-hang")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function delete(Order $order){
        try {
            DB::table('order_products')->where('order_id', $order->id)->delete();
            $order->delete();
            return redirect()->to("/admin-quan-ly-đon-hang")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
