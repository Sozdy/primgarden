<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        "order_id",
        "product_id",
        "count",
        "total_price",
        "name",
        "price"
    ];

    protected $hidden = ["id", "order_id"];

    public $timestamps = false;
}
