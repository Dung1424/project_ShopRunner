<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function qlSanPham(Request $request){
        $products = Product::onlyTrashed()->orderBy("id","desc")->paginate(20);
//        $products = Product::withTrashed()->orderBy("id","desc")->paginate(20);
        $search = $request->get("search");
        $category_id = $request->get("category_id");
        $price_from = $request->get("price_from");
        $price_to = $request->get("price_to");
        $rate = $request->get("rate");
        $qty_from = $request->get("qty_from");
        $qty_to = $request->get("qty_to");
        $products = Product::Search($request)
            ->FilterCategory($request)
            ->FromPrice($request)
            ->ToPrice($request)
            ->orderBy("id","desc")
            ->paginate(2000);
        // Scope search
        $categories = Category::all();
        return view("admin.pages.product.qlSanPham",[
            "products"=>$products,
            'categories'=>$categories
        ]);
    }

    public function addSanPham(){
        $categories = Category::all();
        return view("admin.pages.product.addSanPham",compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|min:6",
            "price"=>"required|numeric|min:0",
            "qty"=>"required|numeric|min:0",
            "category_id"=>"required|numeric|min:1",
            "thumbnail"=>"nullable|mimes:png,jpg,jpeg,gif|mimetypes:image/jpeg,image/png,image/jpg"
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

            // Tạo sản phẩm trong bảng products
            Product::create([
                "name" => $request->get("name"),
                "slug" => Str::slug($request->get("name")),
                "thumbnail" => $thumbnail,
                "price" => $request->get("price"),
                "qty" => $request->get("qty"),
                "category_id" => $request->get("category_id"),
                "description" => $request->get("description"),
            ]);


            return redirect()->to("admin/admin-quan-ly-san-pham")->with("success", "Added product successfully");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }



    public function editSanPham(Product $product){
        $categories = Category::all();
        return view("admin.pages.product.editSanPham",compact('product','categories'));
    }
    public function update(Product $product,Request $request){
        $request->validate([
            "name"=>"required|min:6",
            "price"=>"required|numeric|min:0",
            "qty"=>"required|numeric|min:0",
            "category_id"=>"required|numeric|min:1",
            "thumbnail"=>"nullable|mimes:png,jpg,jpeg,gif|mimetypes:image/jpeg,image/png,image/jpg"
        ]);
        try {
            $thumbnail = $product->thumbnail;
            // xu ly upload file
            if($request->hasFile("thumbnail")){
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path,$file_name);
                $thumbnail = "/uploads/".$file_name;
            }
            $product->update([
                "name"=>$request->get("name"),
                "slug"=> Str::slug($request->get("name")),
                "thumbnail"=>$thumbnail,
                "price"=>$request->get("price"),
                "qty"=>$request->get("qty"),
                "category_id"=>$request->get("category_id"),
                "description"=>$request->get("description"),
            ]);
            return redirect()->to("admin/admin-quan-ly-san-pham")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function delete(Product $product) {
        try {
            $product->delete();

            return redirect()->to("admin/admin-quan-ly-san-pham")->with("success", "Product deletion successful");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


}
