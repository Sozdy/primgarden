<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    protected $fillable = ["id", "characteristic_type_id", "name"];
    public $timestamps = false;
}
