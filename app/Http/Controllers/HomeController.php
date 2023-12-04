<?php

namespace App\Http\Controllers;

use App\Mail\SendContactEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\favoriteOrder;
use App\Models\Product;
use App\Mail\OrderMail;
use App\Events\CreateNewOrder;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Database\Eloquent\Collection;
class HomeController
{
    public function __construct()
    {
//        $this->middleware("auth");
    }

    // home
    public function home(Request $request){

        $products = Product::all();
        $avgRatings = [];
        foreach ($products as $item) {
            $ratingSum = Review::where('product_id', $item->id)->sum('rating');
            $ratingCount = Review::where('product_id', $item->id)->count();

            if ($ratingCount > 0) {
                $avgRating = round($ratingSum / $ratingCount, 2);
                $avgStarRating = round($ratingSum / $ratingCount);
            } else {
                $avgRating = 0;
                $avgStarRating = 0;
            }

            $avgRatings[$item->id] = [
                'avgRating' => $avgRating,
                'avgStarRating' => $avgStarRating
            ];
        }

        return view("pages.customer.home",compact(
            "products",
            "avgRatings",
            "ratingCount"
        ));
    }

    // search
    public function search(\Illuminate\Http\Request $req){
        $product = Product::where('name','like','%'.$req->key. '%')
            ->orWhere('price',$req->key)
            ->get();
        return view("pages.customer.search",compact('product'));
    }


    // category
    public function categoryShop(Product $product,Request $request) {
        $query = Product::Search($request)->FromPrice($request)->ToPrice($request)->orderBy("created_at", "desc");
        $products = $query->paginate(12);


        // Tính toán đánh giá trung bình và số lượng đánh giá cho toàn bộ danh sách sản phẩm
        $avgRatings = [];
        foreach ($products as $item) {
            $ratingSum = Review::where('product_id', $item->id)->sum('rating');
            $ratingCount = Review::where('product_id', $item->id)->count();

            if ($ratingCount > 0) {
                $avgRating = round($ratingSum / $ratingCount, 2);
                $avgStarRating = round($ratingSum / $ratingCount);
            } else {
                $avgRating = 0;
                $avgStarRating = 0;
            }

            $avgRatings[$item->id] = [
                'avgRating' => $avgRating,
                'avgStarRating' => $avgStarRating
            ];
        }
        $categories = Category::all();

        return view("pages.customer.categoryShop", compact(
            "products",
            "categories",
            "avgRatings",
            "ratingCount"
        ));
    }


    public function category(Category $category)
    {
        // Fetch categories here
        $categories = Category::all();  // Assuming you have a Category model

        $products = Product::where("category_id", $category->id)
            ->orderBy("created_at", "desc")->paginate(12);
        $avgRatings = [];
        foreach ($products as $item) {
            $ratingSum = Review::where('product_id', $item->id)->sum('rating');
            $ratingCount = Review::where('product_id', $item->id)->count();

            if ($ratingCount > 0) {
                $avgRating = round($ratingSum / $ratingCount, 2);
                $avgStarRating = round($ratingSum / $ratingCount);
            } else {
                $avgRating = 0;
                $avgStarRating = 0;
            }

            $avgRatings[$item->id] = [
                'avgRating' => $avgRating,
                'avgStarRating' => $avgStarRating
            ];
        }
        // Pass both $products and $categories to the view
        return view("pages.customer.category", compact(
            "products",
            "avgRatings",
            "ratingCount",
            "categories"
        ));
    }

    // detials
    public function details(Product $product, Request $request)
    {
//        $ratings = Review::with("user")->where('product_id',  $product->id)->get()->toArray();
        $ratings = Review::all();
        $ratingSum = Review::where('product_id', $product->id)->sum('rating');
        $ratingCount = Review::where('product_id', $product->id)->count();
        if ($ratingCount > 0) {
            $avgRating = round($ratingSum / $ratingCount, 2);
            $avgStarRating = round($ratingSum / $ratingCount);
        } else {
            $avgRating = 0;
            $avgStarRating = 0;
        }
        $relate = Product::where("category_id", $product->category_id)
            ->where("id", "!=", $product->id)
            ->where("qty", ">", 0)
            ->orderBy("created_at", "desc")
            ->limit(4)
            ->get();
        $soldQuantity = $product->getSoldQuantity();
        $favoriteCount = FavoriteOrder::where('name', $product->name)->count();

        return view("pages.customer.shopDetails", compact(
            "product",
            "relate" ,
            "soldQuantity",
            "ratings",
            "favoriteCount",
            "avgRating",
            "avgStarRating",
            "ratingCount"
        ));
    }

    // contact
    public function contactShop(Request $request)
    {
        if ($request->isMethod('post')) {
            // Xử lý khi request là phương thức POST

            // Validate the form data
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'contact_message' => 'required',
            ]);

            // Create a new contact message
            $contact = new Contact();
            $contact->name = $validatedData['name'];
            $contact->email = $validatedData['email'];
            $contact->message = $validatedData['contact_message']; // Thay $validatedData['message'] bằng $validatedData['contact_message']
            $contact->save();

            // Gửi email
            $name = $validatedData['name'];
            $email = $validatedData['email'];
            $contact_message = $validatedData['contact_message'];


            Mail::to('dungdtth2209011@fpt.edu.vn')
                ->send(new SendContactEmail($name, $email, $contact_message));

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } elseif ($request->isMethod('get')) {
            // Xử lý khi request là phương thức GET

            // Hiển thị trang liên hệ
            return view('pages.customer.contactShop');
        }
    }

    // abous us
    public function aboutUs(){
        return view("pages.customer.aboutUs");
    }

    // thank you
    public function ThankYou(Order $order){
//        dd(session("cartShop"));
        return view("pages.customer.ThankYou.thankYou",compact("order"));
    }
    public function purchaseOrder(Order $order){
        return view("pages.customer.ThankYou.purchaseOrder",compact("order"));
    }


}
