<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCharacteristic extends Model
{
    protected $fillable = ["category_id", "characteristic_id"];
    public $timestamps = false;
}
