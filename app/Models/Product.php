<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;// trait
    protected $table = "products";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = [
        "name",
        "slug",
        "price",
        "thumbnail",
        "qty",
        "description",
        "category_id",
        "brand_id"
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('qty');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getSoldQuantity()
    {
        return $this->orders()->sum('order_products.qty');
    }
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }


    public function scopeSearch($query,$request){
        if($request->has("search")&& $request->get("search") != ""){
            $search = $request->get("search");
            $query->where("name","like","%$search%")
                ->orWhere("description","like","%$search%");
        }
        return $query;
    }

    public function scopeFilterCategory($query,$request){
        if($request->has("category_id")&& $request->get("category_id") != 0){
            $category_id = $request->get("category_id");
            $query->where("category_id",$category_id);
        }
        return $query;
    }

    public function scopeFromPrice($query,$request){
        if($request->has("price_from")&& $request->get("price_from") != 0){
            $price_from= $request->get("price_from");
            $query->where("price",">=",$price_from);
        }
        return $query;
    }
    public function scopeToPrice($query,$request){
        if($request->has("price_to")&& $request->get("price_to") != 0){
            $price_to= $request->get("price_to");
            $query->where("price","<=",$price_to);
        }
        return $query;
    }
    public function scopeBranding($query,$request){
        if($request->has("brand_id")&& $request->get("brand_id") != 0){
            $brand_id = $request->get("brand_id");
            $query->where("brand_id",$brand_id);
        }
        return $query;
    }
    public function scopeOutOfStock($query)
    {
        return $query->where('qty', 0);
    }

}
