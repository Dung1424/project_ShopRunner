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


    // cart
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

    // check out
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

    // user : account , trạng thái dơn hàng , danh sách sản phẩm yêu thích
    public function myOrder(){
        $Order = Order::where('user_id', auth()->user()->id)
            ->orderBy("created_at", "desc")
            ->paginate(5);
        return view("pages.customer.myOrder", ['orders' => $Order]);
    }

    public function myOrderPending() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 0)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderPending", ['orders' => $orders]);
    }

    public function myOrderConfirmed() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 1)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderConfirmed", ['orders' => $orders]);
    }

    public function myOrderShipping() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 2)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderShipping", ['orders' => $orders]);
    }

    public function myOrderShipped() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 3)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderShipped", ['orders' => $orders]);
    }

    public function myOrderComplete() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 4)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderComplete", ['orders' => $orders]);
    }

    public function myOrderCancel() {
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('status', 5)  // Thêm điều kiện status là 0
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view("pages.customer.myOrderCancel", ['orders' => $orders]);
    }


    public function orderDetail(Order $order){

        return view("pages.customer.orderDetail",compact("order"));
    }
    public function updateComplete(Order $order){
        $order->update([
            "status" => Order::COMPLETE
        ]);
        return redirect()->to("my-order");    }

    public function updateOrderStatusCancel(Order $order) {
        $newStatus = Order::CANCEL;

        // Lấy danh sách sản phẩm trong đơn hàng
        $products = $order->products;

        // Cập nhật trạng thái của đơn hàng
        $order->update([
            "status" => $newStatus
        ]);

        // Cập nhật số lượng sản phẩm trong bảng product
        foreach ($products as $product) {
            $product->update([
                'qty' => $product->qty + $product->pivot->qty
                // Giả sử 'quantity' là trường chứa số lượng sản phẩm trong bảng product,
                // 'pivot' là bảng trung gian giữa order và product, chứa thông tin thêm như số lượng trong đơn hàng
            ]);
        }

        return redirect()->to("my-order");
    }
    public function purchaseOrder(Order $order){
        return view("pages.customer.purchaseOrder",compact("order"));
    }
    public function purchaseHome(){
        $orders = Order::orderBy("created_at", "asc")->paginate(12);
        return view("pages.customer.purchaseHome", compact('orders'));
    }
    public function changePassword(){
        return view("pages.customer.changePassword");
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return redirect()->route('change-password')->with('success', 'Password updated successfully.');

    }
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
        return view("pages.customer.favoriteOrder", compact('favoriteProducts', 'products'));
    }

    public function Profile()
    {
        return view("pages.customer.profile");
    }
    public function EditProfile(){
        return view("pages.customer.edit-profile");
    }
    public function updateProfile (Request $request)
    {
        // Validate the form input
        $request->validate([
            "name"=>"required|min:6",
            "address"=>"required",
            "tel"=> "required|min:9|max:11",
            "email"=>"required",
            //   'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size limit as needed
        ]);

        try {
            $user = Auth::user();

            $thumbnail = $user->thumbnail;

            // Handle file upload
            if ($request->hasFile("thumbnail")) {
                $path = public_path("images");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5) . time() . Str::random(5) . "." . $file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/images/" . $file_name;
            }

            $user->update([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "tel" => $request->input("tel"),
                "address" => $request->input("address"),
                "thumbnail" => $thumbnail,
            ]);

            return redirect()->to('/profile'); // Redirect to the profile page after successful update
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage()); // Pass the error message to the view
        }
    }


    // thank you
    public function ThankYou(Order $order){
//        dd(session("cartShop"));
        return view("pages.customer.thankYou",compact("order"));
    }
    // rating

}
