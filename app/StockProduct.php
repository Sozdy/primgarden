<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    protected $fillable = [
        "stock_id",
        "product_id",
        "is_active",
        "type",
        "discount_percent",
        "min_order",
        "discount_percent_max"
    ];

    public $timestamps = false;
}
