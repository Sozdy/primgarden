<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "first_name",
        "last_name",
        "user_id",
        "contact_person",
        "phone",
        "email",
        "store_id",
        "delivery_type",
        "delivery_address",
        "delivery_comment",
        "comment",
        "is_synchronized",
        "status",
        "delivery_method_id",
        "is_paid",
        "payment_id",
        "payment_result",
        "is_cart_stock_got"
    ];

    protected $appends = ["products", "sum"];

    public function getProductsAttribute()
    {
        return OrderProduct::where("order_id", $this->id)->get();
    }

    public function getSumAttribute()
    {
        return OrderProduct::where("order_id", $this->id)->sum("total_price");
    }

}
