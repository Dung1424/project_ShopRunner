<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class RatingController extends Controller
{

    public function review(Product $product){
        $ratings = Review::all();
        $ratingSum = Review::where('product_id', $product->id)->sum('rating'); // where('status', 1)
        $ratingCount = Review::where('product_id', $product->id)->count();

        if ($ratingCount > 0) {
            $avgRating = round($ratingSum / $ratingCount, 2);
            $avgStarRating = round($ratingSum / $ratingCount);
        } else {
            // If there are no reviews, set default values
            $avgRating = 0;
            $avgStarRating = 0;
        }
        return view("pages.customer.rating", compact("ratings", "product", "avgRating", "avgStarRating","ratingCount"));
    }

    public function detailsRating(Request $request){
        if (!Auth::check()){
            $message = "Login to rate this product!!!";
            Session::flash('error', $message);
            return redirect()->back();
        }
        if (!isset($data['rating'])){
            $message = "You need to buy the product to be able to rating";
            Session::flash('error', $message);
            return redirect()->back();
        }
    }

    public function addRating(Request $request){
        if ($request->isMethod('post')){
            $data = $request->all();

            if (!Auth::check()){
                $message = "Login to rate this product!!!";
                Session::flash('error', $message);
                return redirect()->back();
            }

            if (!isset($data['rating'])){
                $message = "You need to rate the product";
                Session::flash('error', $message);
                return redirect()->back();
            }

            $ratingCount = Review::where(['user_id'=>Auth::user()->id, 'product_id'=>$data['product_id']])->count();
            if ($ratingCount > 0){
                $message = "Your rating already exists for this product";
                Session::flash('error', $message);
                return redirect()->back();
            } else {
                $rating = new Review;
                $rating->user_id = Auth::user()->id;
                $rating->product_id = $data['product_id'];
                $rating->message = $data['message'];
                $rating->rating = $data['rating'];
                $rating->save();

                $message = "Thanks for rating this product!!";
                Session::flash('success', $message);
                $product = Product::where('id', $data['product_id'])->first();

                if ($product) {
                    // Chuyển hướng về trang chi tiết sản phẩm sau khi thêm đánh giá thành công
                    return redirect()->route('details', ['product' => $product->slug]);
                } else {
                    // Xử lý nếu không tìm thấy sản phẩm
                    return redirect()->back(); // Hoặc điều hướng về trang khác tuỳ vào yêu cầu của bạn
                }
            }
        }
    }


}
