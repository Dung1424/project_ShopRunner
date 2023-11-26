<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        "user_id",
        "full_name",
        "tel",
        "address",
        "email",
        "grand_total",
        "shipping_method",
        "payment_method",
        "status",
        "is_paid"
    ];

    const PENDING = 0; // chờ xác nhận
    const CONFIRMED = 1; // đã xác nhận
    const SHIPPING = 2; // đang giao hàng
    const SHIPPED = 3; // đã giao hàng
    const COMPLETE = 4; // hoàn thành
    const CANCEL = 5; // huỷ

    public function Products(){
        return $this->belongsToMany(Product::class,"order_products")->withPivot(["qty","price"]);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function getSoldQuantityByProduct()
    {
        return DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.status', self::COMPLETE) // Chỉ lấy đơn hàng có trạng thái đã hoàn thành
            ->select('order_products.product_id', DB::raw('SUM(order_products.qty) as total_qty_sold'))
            ->groupBy('order_products.product_id');
    }

    public static function getTotalCancelledOrders() {
        return Order::where('status', Order::CANCEL)->count();
    }

    public function getGrandTotal(){
        return "$".number_format($this->grand_total,2);
    }
    public function getPaid(){
        return $this->is_paid?"<span class='btn btn-success'>Paid</span>"
            :"<span class='btn btn-secondary'>Unpaid</span>";
    }
    public function getStatus(){
        switch ($this->status){
            case self::PENDING: return "<span class='text-secondary'>Pending</span>";
            case self::CONFIRMED: return "<span class='text-info'>Confirmed</span>";
            case self::SHIPPING: return "<span class='text-warning'>Shipping</span>";
            case self::SHIPPED: return "<span class='text-primary'>Shipped</span>";
            case self::COMPLETE: return "<span class='text-success'>Complete</span>";
            case self::CANCEL: return "<span class='text-danger'>Cancel</span>";
        }
    }

    public function scopeSearch($query,$request){
        if($request->has("search")&& $request->get("search") != ""){
            $search = $request->get("search");
            $query->where("name","like","%$search%")
                ->orWhere("description","like","%$search%");
        }
        return $query;
    }

    public function scopeFilterByGrandTotal($query, $request)
    {
        if ($request->has("grand_total") && $request->get("grand_total") != 0) {
            $grand_total = $request->get("grand_total");
            $query->where("grand_total", ">=", $grand_total);
        }
        return $query;
    }

    public function scopeFilterByShippingMethod($query, $request)
    {
        if ($request->has("shipping_method") && $request->get("shipping_method") != "") {
            $shipping_method = $request->get("shipping_method");
            $query->where("shipping_method", "like", "%$shipping_method%");
        }
        return $query;
    }

    public function scopeFilterByPaymentMethod($query, $request)
    {
        if ($request->has("payment_method") && $request->get("payment_method") != "") {
            $payment_method = $request->get("payment_method");
            $query->where("payment_method", "like", "%$payment_method%");
        }
        return $query;
    }

    public function scopeFilterByPaid($query, $request)
    {
        if ($request->has("paid") && $request->get("paid") !== "") {
            $paid = $request->get("paid");
            $query->where("is_paid", $paid);
        }
        return $query;
    }



    public function scopeFilterByStatus($query, $request)
    {
        if ($request->has("status") && $request->get("status") != "") {
            $status = $request->get("status");

            // Sử dụng một mảng chứa tên trạng thái và số tương ứng
            $statusMapping = [
                "pending" => self::PENDING,
                "confirmed" => self::CONFIRMED,
                "shipping" => self::SHIPPING,
                "shipped" => self::SHIPPED,
                "complete" => self::COMPLETE,
                "cancel"  => self::CANCEL,
            ];

            // Kiểm tra xem $status có tồn tại trong $statusMapping không
            if (array_key_exists($status, $statusMapping)) {
                $statusValue = $statusMapping[$status];
                $query->where("status", $statusValue);
            } else {
                // Nếu $status không khớp với bất kỳ tên trạng thái nào, bạn có thể xử lý tùy ý, ví dụ: không thực hiện lọc hoặc thông báo lỗi.
                // Ví dụ: return $query;
            }
        }

        return $query;
    }

}
