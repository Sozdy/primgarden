<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SliderSlide extends Model
{
    protected $casts = ['id' => 'string'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ["image_id", "link", "order"];
}
