<?php

namespace App\Http\Controllers;

use App\Models\favoriteOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController
{
    public function addToFavorite(Request $request)
    {
        // Lấy dữ liệu từ request
        $user = Auth::user(); // Đảm bảo người dùng đã đăng nhập

        $name = $request->input('name');
        $price = $request->input('price');
        $thumbnail = $request->input('thumbnail');
        $productId = $request->input('product_id');
        $categoryId = $request->input('category_id');


        // Kiểm tra xem sản phẩm đã tồn tại trong danh sách yêu thích của người dùng hay chưa
        $existingFavorite = FavoriteOrder::where('user_id', $user->id)
            ->where('name', $name)
            ->first();

        if ($existingFavorite) {
            // Sản phẩm đã tồn tại trong danh sách yêu thích, bạn có thể xóa sản phẩm khỏi danh sách yêu thích ở đây
            $existingFavorite->delete();

            return redirect()->back()->with('success', 'Xóa sản phẩm khỏi danh sách yêu thích thành công');
        }

        // Nếu sản phẩm chưa tồn tại trong danh sách yêu thích, thêm nó vào cơ sở dữ liệu
        $favoriteOrder = new FavoriteOrder();
        $favoriteOrder->user_id = $user->id;
        $favoriteOrder->product_id = $productId;
        $favoriteOrder->category_id = $categoryId;
        $favoriteOrder->name = $name;
        $favoriteOrder->price = $price;
        $favoriteOrder->thumbnail = $thumbnail;
        $favoriteOrder->save();

        return redirect()->back()->with('success', 'Added product to favorites list successfully');
        return response()->json(['favorite' => true]); // Nếu sản phẩm đã được yêu thích

    }
    public function removeFavorite(Request $request)
    {
        $productId = $request->query('product_id');
        $favoriteOrder = FavoriteOrder::find($productId);

        if (!$favoriteOrder) {
            return redirect()->back();
        }

        $favoriteOrder->delete();

        // Chuyển hướng người dùng đến trang "Favorite Order" với thông báo thành công
        return redirect()->back()->with('success', 'Removed from favorite orders successfully.');
    }
    public function clearFavorite()
    {
        // Xóa toàn bộ sản phẩm trong danh sách yêu thích (favoriteOrder)

        FavoriteOrder::truncate(); // Xóa toàn bộ dữ liệu trong bảng FavoriteProduct

        // Redirect hoặc trả về phản hồi thích hợp
        return redirect()->back()->with('success', 'Successfully deleted all favorites');
    }
    public function favoriteOrder()
    {
        // Lấy danh sách các sản phẩm yêu thích từ cơ sở dữ liệu
        $favoriteProducts = FavoriteOrder::where('user_id', auth()->user()->id)->get();

        // Lấy thông tin sản phẩm tương ứng với từng sản phẩm yêu thích
        $products = [];
        foreach ($favoriteProducts as $favoriteProduct) {
            $product = Product::find($favoriteProduct->product_id); // Điều chỉnh nếu tên cột khác
            if ($product) {
                $products[] = $product;
            }
        }

        // Truyền danh sách sản phẩm yêu thích và thông tin sản phẩm đến view "favoriteOrder"
        return view("pages.customer.MyOrder.favoriteOrder", compact('favoriteProducts', 'products'));
    }
}
