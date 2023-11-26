<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = "reviews";
    protected $fillable = [
        "user_id",
        "product_id",
        "rating",
        "message",
        "status"
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }
    public function Product(){
        return $this->belongsTo(Product::class, "product_id");
    }


    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('review_text', 'like', '%' . $searchTerm . '%');
    }

    public function scopeSearchCustomerName($query, $customerName)
    {
        return $query->whereHas('user', function ($q) use ($customerName) {
            $q->where('name', 'like', '%' . $customerName . '%');
        });
    }

    public function scopeFilterByUserEmail($query, $email)
    {
        return $query->whereHas('user', function ($q) use ($email) {
            $q->where('email', $email);
        });
    }


    public function scopeFilterByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

}
