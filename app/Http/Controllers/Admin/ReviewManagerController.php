<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewManagerController
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
}
