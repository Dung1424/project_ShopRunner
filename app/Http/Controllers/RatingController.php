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
    public function adminRating(Request $request){
        $products = Product::with('reviews')
            ->withCount('reviews')
            ->when($request->has("search"), function ($query) use ($request) {
                return $query->search($request);
            })
            ->when($request->has("category_id"), function ($query) use ($request) {
                return $query->filterCategory($request);
            })
            ->when($request->has("price_from"), function ($query) use ($request) {
                return $query->fromPrice($request);
            })
            ->when($request->has("price_to"), function ($query) use ($request) {
                return $query->toPrice($request);
            })
            ->when($request->has("rate"), function ($query) use ($request) {
                $desiredRating = $request->input('rate');
                $query->whereHas('reviews', function ($q) use ($desiredRating) {
                    $q->select(DB::raw('AVG(rating) as avgRating'))
                        ->groupBy('product_id')
                        ->havingRaw('AVG(rating) = ?', [$desiredRating]);
                });
            })

            ->get()
            ->sortByDesc(function ($product) {
                return $product->averageRating();
            });

        $categories = Category::all();

        return view("admin.pages.ratings", compact('products', 'categories'));
    }

    public function ratingDetails($product_id, Request $request){
        $product = Product::find($product_id);
        $reviews = Review::where('product_id', $product_id);

        $search = $request->get("search");
        $customerName = $request->get("customer_name");
        $starRating = $request->get("star_rating");
        $email = $request->get("email");

        if ($search) {
            $reviews->search($search);
        }

        if ($customerName) {
            $reviews->searchCustomerName($customerName);
        }

        if ($starRating) {
            $reviews->filterByRating($starRating);
        }
        if ($email) {

            $reviews->filterByUserEmail($email);
        }

        $reviews = $reviews->paginate(20);

        return view('admin.pages.ratingDetails', compact('product', 'reviews', 'product_id'));
    }
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
