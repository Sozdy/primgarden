<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDeliveryAddress extends Model
{
    protected $fillable = ["user_id", "address"];
    public $timestamps = false;
}
