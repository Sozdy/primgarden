<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "is_active",
        "type",
        "discount_percent_all",
        "min_order_all",
        "discount_percent_max_all"
    ];
}
