<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = ["id", "title", "description", "is_active"];
    protected $casts = ['id' => 'string'];
    public $incrementing = false;
    public $timestamps = false;
}
