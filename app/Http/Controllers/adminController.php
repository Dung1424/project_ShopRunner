<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\favoriteOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class adminController extends Controller
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
    public function qlNhanVien(){
        $user =User::where('role', 'EMPLOYEE')->get();
        return view("admin.pages.qlNhanVien",compact("user"));
    }

    public function addNhanVien(){

        return view("admin.pages.addNhanVien");
    }

    public function editNhanVien(User $user){

        return view("admin.pages.editNhanVien", compact("user"));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|min:6',
            'email' => 'required|email|unique:users', // Giả sử tên bảng của bạn là 'users'
            'tel' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|string|min:8', // Điều chỉnh theo cần thiết
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ví dụ kiểm tra hình ảnh
        ]);


        try {
            $thumbnail = null;

            // Xử lý upload file
            if ($request->hasFile("thumbnail")) {
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5) . time() . Str::random(5) . "." . $file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/uploads/" . $file_name;
            }
            User::create([
                "name" => $request->get("name"),
                "thumbnail" => $thumbnail,
                "address" => $request->get("address"), // Sửa lỗi tại đây
                "tel" => $request->get("tel"), // Sửa lỗi tại đây
                "email" => $request->get("email"),
                "password" => Hash::make($request->get("password")),

                "role"=>"EMPLOYEE",
            ]);

            return redirect()->to("admin/admin-quan-ly-nhan-vien")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(User $user,Request $request){
        $request->validate([
            'name' => 'required|string|min:6',
            'email' => 'required|email',
            'tel' => 'required|string',
            'address' => 'required|string',
        ]);

        try {
            $thumbnail = $user->thumbnail;
            // xu ly upload file
            if($request->hasFile("thumbnail")){
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path,$file_name);
                $thumbnail = "/uploads/".$file_name;
            }
            $user->update([
                "name" => $request->get("name"),
                "thumbnail" => $thumbnail,
                "address" => $request->get("address"), // Sửa lỗi tại đây
                "tel" => $request->get("tel"), // Sửa lỗi tại đây
                "email" => $request->get("email"),
            ]);

            return redirect()->to("admin/admin-quan-ly-nhan-vien")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function delete(User $user){

        try {
            $user->delete();

            return redirect()->to("admin/admin-quan-ly-nhan-vien")->with("Product deletion successful");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


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
